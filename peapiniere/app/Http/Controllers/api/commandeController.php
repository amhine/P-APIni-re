<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DAO\CommandeDAO;
use App\Http\Requests\passercommande;
use App\Models\commande;


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
    public function etatCommande($id)
    {
        try {
            $commande = Commande::findOrFail($id); 

            return response()->json([
                'success' => true,
                'commande' => [
                    'id' => $commande->id,
                    'status' => $commande->status, 
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Commande non trouvée',
                'message' => $e->getMessage(),
            ], 404);
        }
    }
    public function annulerCommande($id)
    {
        try {
            $commande = Commande::findOrFail($id); 
            if ($commande->status !== 'en attente') {
                return response()->json([
                    'error' => 'La commande ne peut pas  annuler',
                ], 400);
            }
            $commande->status = 'annulee';
            $commande->save();

            return response()->json([
                'success' => true,
                'message' => 'Votre commande  annuler avec succees.',
                'commande' => $commande,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Commande non trouver',
                'message' => $e->getMessage(),
            ], 404);
        }
    }
}

