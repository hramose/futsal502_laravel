<?php

namespace App\App\Managers;

class LigaManager extends BaseManager
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
			'descripcion'  	=> 'required',
			'orden'   		=> 'required',
			'estado'  		=> 'required'
		];

		return $rules;
	}

	function prepareData($data)
	{
		$data['mostrar_app'] = isset($data['mostrar_app']) ? 1 : 0;
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
				$this->entity->imagen_app = 'ligas/imagen_app.png';
			}
			$this->entity->save();
			if(\Input::hasFile('imagen_app'))
			{
				$image = \Input::file('imagen_app');
				$imageName = $this->entity->id.'.'.$image->getClientOriginalExtension();
				$this->entity->imagen_app = $image->storeAs('ligas',$imageName,'public');
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
