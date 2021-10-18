<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

abstract class Service implements ServiceInterface
{
    private $app;

    protected $model;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    abstract function setModel();

    public function makeModel()
    {
        $model = $this->app->make($this->setModel());
        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function get($columns = array('*'))
    {
        return $this->model->get($columns);
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        return $this->model->paginate($perPage, $columns);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $record = $this->model->findOrFail($id);
        $record->update($data);

        return $this->model->find($id);
    }

    public function delete($ids)
    {
        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }

        return $this->model->destroy($ids);
    }

    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id);
    }

    public function findOrFail($id, $columns = array('*'))
    {
        return $this->model->findOrFail($id, $columns);
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        return $this->model->where($field, '=', $value)->first($columns);
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }
}
