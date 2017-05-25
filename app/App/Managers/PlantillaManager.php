<?php

namespace App\App\Managers;

use App\App\Entities\Plantilla;

class PlantillaManager extends BaseManager
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
		return [];
	}

	public function prepareData($data)
	{
		return $data;
	}

	public function agregarPersonas($campeonatoId, $equipoId)
	{
		\DB::beginTransaction();

			$personas = $this->data['personas'];
	        foreach($personas as $persona)
	        {
	        	if(isset($persona['seleccionado']))
	        	{
	        		$p = new Plantilla();
	        		$p->campeonato_id = $campeonatoId;
	        		$p->equipo_id = $equipoId;
	        		$p->persona_id = $persona['id'];
	        		$p->estado = 'A';
	        		$p->save();
	        	}
	        }
	        
        \DB::commit();
	}

	public function eliminarPersonas()
	{
		\DB::beginTransaction();

			$personas = $this->data['personas'];
	        foreach($personas as $persona)
	        {
	        	if(isset($persona['seleccionado']))
	        	{
	        		$ec = Plantilla::find($persona['id'])->delete();
	        	}
	        }
	        
        \DB::commit();
	}

}
