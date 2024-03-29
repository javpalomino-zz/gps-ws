<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use App\Services\Filterer;
use App\Services\Formater;

class Repository {

	public function __construct(Builder $model,
								Formater $formater){

		$this->model = $model;
		$this->formater = $formater;
	}

	public function exists($id){
		return ($model->find($id)==null?false:true);
	}

	public function getAll(){
		$collection = $this->model->get();

		return $this->formater->format_collection($collection);
	}

	public function updateOrCreate($check, $change){
		$item = $this->model->updateOrCreate($check, $change);
	}

	public function update($fields){
		$item = $this->model->find($fields['id']);
		unset($fields['id']);
		$position = $item->position;
		foreach ($fields as $key => $value) {
			$position->$key = $value;
		}

		$position->save();
	}
}