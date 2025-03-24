<?php

namespace App\Repository;

use App\Repository\Interface\CategorieInterface; // Assurez-vous que c'est correct
use App\Models\Categories;

class CategorieRepository implements CategorieInterface
{
    protected $model;

    public function __construct(Categories $categorie)
    {
        $this->model = $categorie;
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
        $categorie = $this->find($id);
        $categorie->update($data);
        return $categorie;
    }

    public function delete($id)
    {
        $categorie = $this->find($id);
        return $categorie->delete();
    }
}
