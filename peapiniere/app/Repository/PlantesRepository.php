<?php

namespace App\Repository;

use App\Models\plantes;
use App\Repository\Interface\plantesInterface;

class plantesRepository implements plantesInterface
{
    protected $model;

    public function __construct(plantes $plantes)
    {
        $this->model = $plantes;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $plantes = $this->find($id);
        $plantes->update($data);
        return $plantes;
    }

    public function delete($id)
    {
        $plantes = $this->find($id);
        return $plantes->delete();
    }
    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
}
