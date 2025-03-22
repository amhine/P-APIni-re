<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DAO\CommandeDAO;
use App\Http\Requests\passercommande;


class CommandeController extends Controller
{
    protected $commandeDAO;

    public function __construct(CommandeDAO $commandeDAO)
    {
        $this->commandeDAO = $commandeDAO;
    }

    public function passerCommande(passercommande  $request)
    {
        

        $validated = $request->validated();
        try {
            $slugquantites = [];
            
            foreach ($validated['plantes'] as $plante) {
                $slug = $plante['slug'];
                $quantite = $plante['quantite'];
                $slugquantites[$slug] = $quantite;
            }
            
            $commande = $this->commandeDAO->createCommande(
                $validated['user_id'],
                $slugquantites
            );
        
            return response()->json([
                'success' => true,
                'commande' => $commande,
            ], 201);
        }catch (\Exception $e) {
            return response()->json([
                'error' => 'Une erreur est survenue lors du traitement de la commande.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

