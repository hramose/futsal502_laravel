<?php

namespace App\App\Managers;

use App\App\Repositories\PersonaRepo;
use App\App\Repositories\AlineacionRepo;
use App\App\Repositories\EventoPartidoRepo;

use App\App\Entities\EventoPartido;
use Redirect, Session, Twitter;
use Facebook\Facebook as Facebook;

class EventoPartidoManager extends BaseManager
{

	protected $entity;
	protected $data;

	public function __construct($entity, $data)
	{
		$this->entity = $entity;
        $this->data   = $data;

	}

	function getRules()
	{

		$rules = [
			'partido_id'  => 'required',
			'evento_id'  => 'required',
			'minuto'  => 'required|integer',
			'segundo' => 'required|integer'
		];

		return $rules;
	}

	function getRulesPersona()
	{
		$rules = [
			'partido_id'  => 'required',
			'equipo_id'  => 'required',
			'persona_id'  => 'required',
			'evento_id'  => 'required',
			'minuto'  => 'required|integer',
			'segundo' => 'required|integer',
		];
		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function agregar($partido)
	{

		$rules = $this->getRules();
		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
        try{
        	\DB::beginTransaction();
				$this->entity->fill($this->prepareData($this->data));
				if($this->entity->evento_id == 2){ //inicio de partido
					$partido->goles_local = 0;
					$partido->goles_visita = 0;
					$partido->faltas_local = 0;
					$partido->faltas_visita = 0;
					$partido->estado = 'J';
					$partido->save();
				}
				$this->entity->comentario = $this->getComentario($partido, $this->entity->evento_id,null, null);
				$this->entity->save();
			\DB::commit();


			/* Postear en redes sociales */
			$mensajePost = '';
			if($this->entity->evento_id == 10){
				$mensajePost = $this->entity->comentario;
				if(isset($this->data['publicar_minuto']))
					$mensajePost .= ' Minuto ' . str_pad($this->entity->minuto, 2, '0', STR_PAD_LEFT). ':' . str_pad($this->entity->segundo, 2, '0', STR_PAD_LEFT);
				$mensajePost .= ' ' . $partido->campeonato->hashtag;
			}
			else{
				$mensajePost = $this->entity->comentario. ' ' . $partido->campeonato->hashtag;
			}

			if(isset($this->data['facebook']))
				$this->postFacebook($mensajePost);
			if(isset($this->data['twitter']))
				$this->postTwitter($mensajePost);
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException('¡Error!', $ex);
		}

		
	}

	function agregarPersona($partido,$equipoId)
	{
		$rules = $this->getRulesPersona();
		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
        try{

        	if($equipoId == $partido->equipo_local_id) {
				$equipo = $partido->equipo_local;
				$equipoContrario = $partido->equipo_visita;
			}
			else {
				$equipo = $partido->equipo_visita;
				$equipoContrario = $partido->equipo_local;
			}

        	$eventoPartidoRepo = new EventoPartidoRepo();
        	$alineacionRepo = new AlineacionRepo();
        	$personaRepo = new PersonaRepo();
        	\DB::beginTransaction();

        		/*Se llenan los datos que vienen*/
				$this->entity->fill($this->prepareData($this->data));

				/*Se actualiza el partido --> Goles */
				if($this->entity->evento_id == 6 || $this->entity->evento_id == 7 ){

					if($equipoId == $partido->equipo_local_id)
					{
						$partido->goles_local = $partido->goles_local + 1;
					}
					else
					{
						$partido->goles_visita = $partido->goles_visita + 1;
					}
					$partido->save();
				}
				/*Se obtiene el comentario*/
				$this->entity->comentario = $this->getComentario($partido, $this->entity->evento_id, 
														$this->entity->equipo_id, $personaRepo->find($this->entity->persona_id));
				$this->entity->save();
				

			\DB::commit();

			$mensajePost = $this->entity->comentario . ' Minuto ' . str_pad($this->entity->minuto, 2, '0', STR_PAD_LEFT). ':' . str_pad($this->entity->segundo, 2, '0', STR_PAD_LEFT) . ' ' . $partido->campeonato->hashtag;

			if(isset($this->data['facebook']))
				$this->postFacebook($mensajePost);
			if(isset($this->data['twitter']))
				$this->postTwitter($mensajePost);

		}
		catch(\Exception $ex)
		{
			throw new SaveDataException('¡Error!', $ex);
		}
	}

	public function eliminarEvento($partido)
	{
		try{

        	\DB::beginTransaction();
				if($this->entity->evento_id == 6 || $this->entity->evento_id == 7 || $this->entity->evento_id == 8)
				{
					if($partido->equipo_local_id == $this->entity->equipo_id)
					{
						$partido->goles_local = $partido->goles_local - 1;
					}
					else{
						$partido->goles_visita = $partido->goles_visita - 1;
					}
					$partido->save();
				}
				$this->entity->delete();
			\DB::commit();
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException('¡Error!', $ex);
		}
	}


	private function getComentario($partido, $eventoId, $equipoId = null, $jugador = null)
	{

		if($eventoId == 2)
		{
			return 'Inicia el partido en el ' . $partido->domo->descripcion . '. ' . $this->getResultado($partido);
		}
		if($eventoId == 3)
		{
			return 'Fin del primer tiempo. ' . $partido->domo->descripcion . '. ' . $this->getResultado($partido);
		}
		if($eventoId == 4)
		{
			return 'Inicia el segundo tiempo. ' . $partido->domo->descripcion . '. ' . $this->getResultado($partido);
		}
		if($eventoId == 5)
		{
			return 'Finaliza el partido. ' . $partido->domo->descripcion . '. ' . $this->getResultado($partido);
		}
		if($eventoId == 11)
		{
			return 'Inicia el primer tiempo extra. ' . $partido->domo->descripcion . '. ' . $this->getResultado($partido);
		}
		if($eventoId == 12)
		{
			return 'Fin del primer tiempo extra. ' . $partido->domo->descripcion . '. ' . $this->getResultado($partido);
		}
		if($eventoId == 13)
		{
			return 'Inicia el segundo tiempo extra. ' . $partido->domo->descripcion . '. ' . $this->getResultado($partido);
		}
		if($eventoId == 14)
		{
			return 'Finaliza el segundo tiempo extra. ' . $partido->domo->descripcion . '. ' . $this->getResultado($partido);
		}
		if($eventoId == 6)
		{
			$equipo = $this->getEquipo($partido, $equipoId);
			return '¡¡GOL!! de ' .$equipo->descripcion . '. Anota ' . $jugador->nombre_completo . '. ' . $this->getResultado($partido);
		}
		if($eventoId == 7)
		{
			$equipo = $this->getEquipo($partido, $equipoId);
			return '¡¡GOL!! de ' .$equipo->descripcion . '. Anota en propia puerta ' . $jugador->nombre_completo . '. ' . $this->getResultado($partido);
		}
		if($eventoId == 8)
		{
			$equipo = $this->getEquipo($partido, $equipoId);
			return 'AMARILLA para ' . $jugador->nombre_completo .' de ' . $equipo->descripcion;
		}
		if($eventoId == 9)
		{
			$equipo = $this->getEquipo($partido, $equipoId);
			if(isset($this->entity->doble_amarilla)){
				return 'ROJA por doble amonestación para '.$jugador->nombreCompleto. ' de ' . $equipo->descripcion ;
			}
			return 'ROJA para ' . $jugador->nombre_completo .' de '. $equipo->descripcion;
		}
		if($eventoId == 10)
		{
			return $this->entity->comentario;
		}
	}

	private function getResultado($partido)
	{
		return $partido->equipo_local->descripcion . ' ' . 
					$partido->goles_local . ' - ' . $partido->goles_visita . ' ' . 
				$partido->equipo_visita->descripcion;
	}

	private function getEquipo($partido, $equipoId)
	{
		if($equipoId == $partido->equipo_local->id)
		{
			return $partido->equipo_local;
		}
		else
		{
			return $partido->equipo_visita;
		}
	}

	public function postFacebook($mensaje)
	{
		try{
			$config = array(
	 			'app_id' => env('FB_API_KEY'),
	         	'app_secret' => env('FB_API_SECRET'),
	        	'allowSignedRequest' => false
	    	);

	    	$facebook = new Facebook($config);
			$fanPageId = env('FB_FANPAGE_ID');
			$accessToken = \Session::get('access_token');
			$data['message'] = $mensaje;
    		$post_url = '/'.$fanPageId.'/feed';            		
    		$facebook->post($post_url, $data, $accessToken);
    		\Session::flash('fb-success', 'Se posteó en facebook correctamente.');
		}
		catch(\Exception $ex)
		{
			\Session::flash('fb-error', 'ERROR DE FACEBOOK: ' . $ex->getMessage());
            return Redirect::back();
		}
	}

	public function postImageFacebook($imagen, $mensaje)
	{
		try{
			$config = array(
	 			'app_id' => env('FB_API_KEY'),
	         	'app_secret' => env('FB_API_SECRET'),
	        	'allowSignedRequest' => false
	    	);

	    	$facebook = new Facebook($config);
			$fanPageId = env('FB_FANPAGE_ID');
			$accessToken = \Session::get('access_token');
			$data['caption'] = $mensaje;
			$data['url'] = $imagen;
			//dd($data);
    		$post_url = '/'.$fanPageId.'/photos';            		
    		$facebook->post($post_url, $data, $accessToken);
    		\Session::flash('fb-success', 'Se posteó en facebook correctamente.');
		}
		catch(\Exception $ex)
		{
			\Session::flash('fb-error', 'ERROR DE FACEBOOK: ' . $ex->getMessage());
            return Redirect::back();
		}
	}

	public function postTwitter($mensaje)
	{
		try{
			return Twitter::postTweet(array('status' => $mensaje, 'format' => 'json'));
			\Session::flash('tw-success', 'Se posteó en twitter correctamente.');
		}
		catch(\Exception $ex)
		{
			\Session::flash('tw-error', 'ERROR DE TWITTER: ' . $ex->getMessage());
            return Redirect::back();
		}
	}

	public function postImageTwitter($urlImagen, $mensaje)
	{
		$uploaded_media = Twitter::uploadMedia(['media' => file_get_contents($urlImagen)]);
  		return Twitter::postTweet(['status' => $mensaje, 'media_ids' =>  $uploaded_media->media_id_string]);
	}

}