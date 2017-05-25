<?php

namespace App\App\Managers;

class PersonaManager extends BaseManager
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
			'primer_nombre'  	=> 'required',
			'primer_apellido'  	=> 'required',
			'rol'  				=> 'required',
			'posicion' 			=> 'required',
			'fecha_nacimiento' 	=> 'required|date'
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
				$this->entity->fotografia = $this->entity->genero=='M'?'personas/male.png':'personas/female.png';
			}
			$this->entity->save();
			if(\Input::hasFile('fotografia'))
			{
				$image = \Input::file('fotografia');
				$imageName = $this->entity->id.'.'.$image->getClientOriginalExtension();
				$this->entity->fotografia = $image->storeAs('personas',$imageName,'public');
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