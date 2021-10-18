<?php
namespace App\Services;

interface ServiceInterface {

    public function all();

    public function get($columns = array('*'));

    public function paginate($perPage = 15, $columns = array('*'));

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($ids);

    public function find($id, $columns = array('*'));

    public function findOrFail($id, $columns = array('*'));

    public function findBy($field, $value, $columns = array('*'));

    public function with($relations);
}