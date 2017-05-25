<?php

namespace App\App\Managers;

class ModuloManager extends BaseManager
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
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

}