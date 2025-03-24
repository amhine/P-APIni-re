<?php

namespace App\Repository;
use App\Repository\Interface\CommandeInterface;

use App\Models\commande;

class CommandeRepository implements CommandeInterface
{
    protected $model;

    public function __construct(Commande $Commande)
    {
        $this->model = $Commande;
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
        $Commande = $this->find($id);
        $Commande->update($data);
        return $Commande;
    }

    public function delete($id)
    {
        $Commande = $this->find($id);
        return $Commande->delete();
    }
}
