<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\plantes;
use Exception;


class plantescontroller extends Controller
{
    public function index()
    {
        try {
            $plantes = Plantes::all();

            if ($plantes->isEmpty()) {
                return response()->json([
                    'error' => 'Aucune plante trouvée',
                    'code' => 404
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $plantes
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Une erreur est survenue lors de la récupération des plantes',
                'message' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }
}
