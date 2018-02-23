<?php

namespace App\App\Managers;

class DomoManager extends BaseManager
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
			'direccion' => 'required',
			'longitud' => 'required',
			'latitud' => 'required',
			'estado' => 'required'
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
				$this->entity->imagen = 'domos/domo.png';
			}
			$this->entity->save();
			if(\Input::hasFile('imagen'))
			{
				$image = \Input::file('imagen');
				$imageName = $this->entity->id.'.'.$image->getClientOriginalExtension();
				$this->entity->imagen = $image->storeAs('domos',$imageName,'public');
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
