<?php

namespace App\App\Managers;
use App\App\Entities\MediaArticulo;

class MediaArticuloManager extends BaseManager
{

	protected $entity;
	protected $data;

	public function __construct($entity, $data)
	{
		$this->entity = $entity;
        $this->data   = $data;
	}

	function getRulesImagen()
	{
		$rules = [
			'articulo_id' => 'required'
		];
		return $rules;
	}

	function getRules()
	{
		$rules = [
			'articulo_id'	=> 'required',
			'ruta' 			=> 'required'
		];
		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function agregarImagen()
	{
		$rules = $this->getRulesImagen();
		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
        try{
			\DB::beginTransaction();
			$imagenes = \Input::file('imagenes');
			if(count($imagenes)  > 0 && !is_null($imagenes[0]))
			{
				foreach($imagenes as $image){
					$nuevaImagen = new MediaArticulo();
					$nuevaImagen->fill($this->prepareData($this->data));
					$nuevaImagen->ruta = '';
					$nuevaImagen->save();
					//$image = \Input::file('imagen');
					$ruta = 'articulos/' . $nuevaImagen->articulo_id;
					$imageName = $nuevaImagen->id.'.'.$image->getClientOriginalExtension();
					$nuevaImagen->ruta = $image->storeAs($ruta,$imageName,'public');
					$nuevaImagen->save();
				}
			}			
			\DB::commit();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error!", $ex);			
		}
	}

	public function delete()
	{
		try{
			\DB::beginTransaction();
				$this->entity->delete();
			\DB::commit();
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error!", $ex);			
		}
	}

}