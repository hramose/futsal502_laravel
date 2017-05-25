<?php

namespace App\App\Managers;

class CampeonatoManager extends BaseManager
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
			'descripcion'  => 'required',
			'liga_id' => 'required',
			'fecha_inicio' => 'required|date',
			'fecha_fin' => 'required|date',
			'hashtag' => 'required',
			'estado' => 'required'
		];

		return $rules;
	}

	function prepareData($data)
	{
		$data['mostrar_app'] = isset($data['mostrar_app']) ? 1 : 0;
		$data['actual'] = isset($data['actual']) ? 1 : 0;
		return $data;
	}

}