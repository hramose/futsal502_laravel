<?php

namespace App\App\Managers;

class ArticuloManager extends BaseManager
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
			'titulo'  			=> 'required',
			'descripcion'		=> 'required',
			'autor_id'			=> 'required',
			'categoria_id'		=> 'required',
			'imagen_portada' 	=> 'image|mimes:jpeg,jpg,png,gif|max:1024',
			'fecha_publicacion' => 'required|date'
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function save()
	{
		$rules = $this->getRules();
		$this->data['imagen_portada'] = \Input::file('imagen_portada');
		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
		try{
			\DB::beginTransaction();
			$this->entity->fill($this->prepareData($this->data));
			$this->entity->save();
			if(\Input::hasFile('imagen_portada'))
			{
				$image = \Input::file('imagen_portada');
				$imageName = 'portada.' . $image->getClientOriginalExtension();
				$url = 'articulos/'. $this->entity->id;  
				$this->entity->imagen_portada = $image->storeAs($url,$imageName,'public');
				$this->entity->save();
			}

			\DB::commit();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error!", $ex);			
		}
	}

}