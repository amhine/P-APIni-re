<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Interface\CategorieInterface;
use App\Http\Requests\categoriestore;

class CategorieController extends Controller
{
    protected $categorieRepository;

    public function __construct(CategorieInterface $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
    }

    public function index()
    {
        $categories = $this->categorieRepository->all();

        return response()->json([
            'success' => true,
            'data' => $categories
        ], 200);
    }

    public function store(categoriestore $request)
    {
       

        $categorie = $this->categorieRepository->create([
            'name' => $request->name
        ]);

        return response()->json([
            'success' => true,
            'data' => $categorie
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $categorie = $this->categorieRepository->find($id);

        if (!$categorie) {
            return response()->json([
                'error' => 'Catégorie non trouvée'
            ], 404);
        }

        $categorie = $this->categorieRepository->update($id, $request->all());

        return response()->json([
            'success' => true,
            'data' => $categorie
        ], 200);
    }

    public function destroy($id)
    {
        $categorie = $this->categorieRepository->find($id);

        if (!$categorie) {
            return response()->json([
                'error' => 'Catégorie non trouvée'
            ], 404);
        }

        $this->categorieRepository->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Catégorie supprimée'
        ], 200);
    }
}
