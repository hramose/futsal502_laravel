<?php

namespace App\App\Managers;
use App\App\Entities\Partido;
use App\App\Repositories\PartidoRepo;

class PartidoManager extends BaseManager
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
			'fecha'  			=> 'required|date',
			'equipo_local_id'  	=> 'required',
			'equipo_visita_id'  => 'required',
			'campeonato_id'  	=> 'required',
			'estado'  			=> 'required',
			'jornada_id'  		=> 'required',
		];

		return $rules;
	}

	function prepareData($data)
	{
		if($data['arbitro_central_id']== ''){
			$data['arbitro_central_id'] = null;
		}
		return $data;
	}

	function agregarJornada($campeonatoId, $data)
	{
		$partidoRepo = new PartidoRepo();
		\DB::beginTransaction();
	 	try{

			foreach($this->data['partidos'] as $p){
				$partido = new Partido();
				$partido->jornada_id = $data['jornada_id'];
				$partido->fecha = $data['fecha'] . ' ' . $p['hora'];
				$partido->equipo_local_id = $p['local'];
				$partido->equipo_visita_id = $p['visita'];
				$partido->domo_id = $p['domo'] == '' ? null : $p['domo'];
				$partido->arbitro_central_id = $p['arbitro'] == '' ? null : $p['arbitro'];
				$partido->estado = 'P';
				$partido->campeonato_id = $campeonatoId;
				$partido->save();
			}
			\DB::commit();
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException('¡Error!', $ex);
		}
		return true;
	}

	function editarJornada($data)
	{
		$partidoRepo = new PartidoRepo();
		\DB::beginTransaction();
	 	try{
			foreach($this->data['partidos'] as $p){
				$partido = $partidoRepo->find($p['id']);
				if($p['arbitro_central_id'] != "")
					$partido->arbitro_central_id = $p['arbitro_central_id'];
				else
					$partido->arbitro_central_id = null;
				if($p['domo_id'] != "")
					$partido->domo_id = $p['domo_id'];
				else
					$partido->domo_id = null;
				$partido->fecha = $p['fecha'] . ' ' . $p['hora'];
				$partido->save();
			}
			\DB::commit();
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException('¡Error!', $ex);
		}
		return true;
	}

}