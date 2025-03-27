<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Interface\plantesInterface;
use App\Models\plantes;
use App\Http\Requests\plantestore;
use Exception;


class plantescontroller extends Controller
{
    protected $plantesRepository;

    public function __construct(plantesInterface $plantesRepository)
    {
        $this->plantesRepository = $plantesRepository;
    }
    public function index()
    {
        try {
            $plantes = $this->plantesRepository->all(); 

            if ($plantes->isEmpty()) {
                return response()->json([
                    'error' => 'Aucune plante ',
                    'code' => 404
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $plantes
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => ' erreur ',
                'message' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }
    public function show($slug)
    {
        try {
            $plante = $this->plantesRepository->findBySlug($slug);  
            if (!$plante) {
                return response()->json([
                    'error' => 'Plante non trouver',
                    'code' => 404
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $plante
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => ' erreur ',
                'message' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }
    public function store(plantestore $request)
    {
        try {
            $images = $request->input('images', []);

        if (count($images) > 4) {
            return response()->json([
                'error' => 'Vous ne pouvez pas ajouter plus de 4 images pour une plante.',
                'code' => 422
            ], 422);
        }
            $plante = Plantes::create($request->validated());
            if (!empty($images)) {
                $plante->images = $images; 
                $plante->save();
            }
            return response()->json(['success' => true, 'data' => $plante], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => ' erreur ',
                'message' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $plante = $this->plantesRepository->find($id);
            if (!$plante) {
                return response()->json([
                    'error' => 'Plante non trouvée.',
                    'code' => 404
                ], 404);
            }
            $images = $request->input('images', []);
        
        if (count($images) > 4) {
            return response()->json([
                'error' => 'Vous ne pouvez pas ajouter plus de 4 images pour une plante.',
                'code' => 422
            ], 422);
        }

            $plante->update($request->all());
            if (!empty($images)) {
                $plante->images = $images; 
                $plante->save();
            }

            return response()->json(['success' => true, 'data' => $plante], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => ' erreur ',
                'message' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }
    public function destroy($id)
        {
            try {
                $plante = $this->plantesRepository->find($id);

                if (!$plante) {
                    return response()->json([
                        'error' => 'Plante non trouvée.',
                        'code' => 404
                    ], 404);
                }

                $this->plantesRepository->delete($id);

                return response()->json(['success' => true, 'message' => 'Plante supprimée avec succès.'], 200);
            } catch (Exception $e) {
                
                return response()->json([
                    'error' => 'Erreur lors de la suppression.',
                    'message' => $e->getMessage(),
                    'code' => 500
                ], 500);
            }
    }


}
