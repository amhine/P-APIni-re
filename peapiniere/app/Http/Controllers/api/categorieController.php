<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Interface\CategorieInterface;
use App\Http\Requests\categoriestore;

/**
 * @OA\Info(
 *     title="API de Gestion des Catégories",
 *     version="1.0.0",
 *     description="Documentation de l'API pour la gestion des catégories"
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Serveur local"
 * )
 */
class CategorieController extends Controller
{
    protected $categorieRepository;

    public function __construct(CategorieInterface $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/categories/afficher",
     *     summary="Afficher toutes les catégories",
     *     operationId="getCategories",
     *     tags={"Catégories"},
     *     @OA\Response(response="200", description="Liste des catégories"),
     * )
     */
    public function index()
    {
        $categories = $this->categorieRepository->all();

        return response()->json([
            'success' => true,
            'data' => $categories
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/categories/ajouter",
     *     summary="Ajouter une nouvelle catégorie",
     *     operationId="storeCategory",
     *     tags={"Catégories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Nouvelle Catégorie")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Catégorie créée")
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/categories/{id}/update",
     *     summary="Mettre à jour une catégorie",
     *     operationId="updateCategory",
     *     tags={"Catégories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la catégorie à mettre à jour",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Catégorie Modifiée")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Catégorie mise à jour")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}/supprimer",
     *     summary="Supprimer une catégorie",
     *     operationId="deleteCategory",
     *     tags={"Catégories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la catégorie à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Catégorie supprimée"),
     *     @OA\Response(response="404", description="Catégorie non trouvée")
     * )
     */
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
