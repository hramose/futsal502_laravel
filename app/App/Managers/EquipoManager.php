<?php

namespace App\App\Managers;

class EquipoManager extends BaseManager
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
			'descripcion'		=> 'required',
			'descripcion_corta'	=> 'required',
			'siglas'  			=> 'required',
			'estado'			=> 'required',
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	public function save()
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
			if(is_null($this->entity->id))
			{
				$this->entity->logo = 'equipos/logo.png';
			}
			$this->entity->save();
			if(\Input::hasFile('logo'))
			{
				$image = \Input::file('logo');
				$imageName = $this->entity->id.'.'.$image->getClientOriginalExtension();
				$this->entity->logo = $image->storeAs('equipos',$imageName,'public');
			}
			$this->entity->save();

			\DB::commit();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error!", $ex);			
		}
	}

}