<?php

namespace App\Repositories;

use App\Traits\ApiResponser;

abstract class BusinessLogic{
    use ApiResponser;

    protected $model;

    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    protected function resolveModel(){
        return app($this->model);
    }

    public function getAll(){
        return $this->model->all();
    }

    public function create($request){
        $newModel = new $this->model;
        $createdModel = $newModel->create($request->all());

        return $this->success("Created", $createdModel);
    }

    public function getByID($id){
        return $this->model->where('id', $id)->get();
    }

    public function update($request){
        $this->model->where('id', $request->id)->update($request->all());

        return $this->success("ID {$request->id} updated");
    }

    public function delete($id){
        $this->model->where('id', $id)->delete();

        return $this->success("ID {$id} successfully deleted!");
    }

    public function validateName($name){
        $attr = $name->validate([
            'name' => 'required|string|max:60',
        ]);
        return $attr;
    }    
}