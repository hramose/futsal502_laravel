<?php

namespace App\App\Managers;

use App\App\Entities\CampeonatoEquipo;
use App\App\Entities\CampeonatoEquipoPersona;
use App\App\Repositories\CampeonatoEquipoRepo;
use App\App\Repositories\PlantillaRepo;

class CampeonatoEquipoManager extends BaseManager
{

	protected $entity;
	protected $data;

	public function __construct($entity, $data)
	{
		$this->entity = $entity;
        $this->data   = $data;
	}

	public function getRules()
	{

	}

	public function agregarEquipos($campeonatoId)
	{
		try{
			\DB::beginTransaction();
				$equipos = $this->data['equipos'];
		        foreach($equipos as $equipo)
		        {
		        	if(isset($equipo['seleccionado']))
		        	{
		        		$ec = new CampeonatoEquipo();
		        		$ec->campeonato_id = $campeonatoId;
		        		$ec->equipo_id = $equipo['id'];
		        		$ec->grupo = isset($equipo['grupo']) ? $equipo['grupo'] : 0;
		        		$ec->save();
		        	}
		        }
	        \DB::commit();
	    }
	    catch(\Exception $ex)
	    {
	    	throw new SaveDataException('Error',$ex);
	    }
	}

	public function eliminarEquipos()
	{
		$plantillaRepo = new PlantillaRepo();
		try{
			\DB::beginTransaction();

				$equipos = $this->data['equipos'];
		        foreach($equipos as $equipo)
		        {
		        	if(isset($equipo['seleccionado']))
		        	{
		        		$ec = CampeonatoEquipo::find($equipo['id']);
		        		$ec->delete();
		        		$personas = $plantillaRepo->getByCampeonatoByEquipo($ec->campeonato_id, $ec->equipo_id);
						foreach($personas as $persona){
							$persona->delete();
						}
		        	}
		        }

	        \DB::commit();
	    }
	    catch(\Exception $ex)
	    {
	    	throw new SaveDataException('Error',$ex);
	    }
	}

	public function trasladarEquipos($campeonatoNuevo, $campeonatoAntiguo)
	{
		try{
			\DB::beginTransaction();

				$campeonatoEquipoRepo = new CampeonatoEquipoRepo();
				$plantillaRepo = new PlantillaRepo();

				$equipos = $this->data['equipos'];
		        foreach($equipos as $equipo)
		        {
		        	if(isset($equipo['seleccionado']))
		        	{
		        		$e = $campeonatoEquipoRepo->getEquipoByCampeonato($campeonatoNuevo, $equipo['id']);
		        		if(is_null($e)){
		        			$ec = new CampeonatoEquipo();
			        		$ec->campeonato_id = $campeonatoNuevo;
			        		$ec->equipo_id = $equipo['id'];
			        		$ec->save();
			        	}
			        	else{
			        		$ec = $e;
			        	}

			        	if(isset($this->data['incluir_personas'])){

							$personas = $plantillaRepo->getPersonas($campeonatoNuevo, $equipo['id']);
							foreach($personas as $persona){
								$persona->delete();
							}
							$personas = $plantillaRepo->getPersonas($campeonatoAntiguo, $equipo['id']);
							foreach($personas as $persona){
								$p = new CampeonatoEquipoPersona();
				        		$p->campeonato_id = $campeonatoNuevo;
				        		$p->equipo_id = $equipo['id'];
				        		$p->persona_id = $persona->persona_id;
				        		$p->save();
							}
			        	}

		        	}
		        }

	        \DB::commit();
	    }
	    catch(\Exception $ex)
	    {
	    	throw new SaveDataException('Error',$ex);
	    }
	}

}
