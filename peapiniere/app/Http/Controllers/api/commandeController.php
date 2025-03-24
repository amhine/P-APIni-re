<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DAO\CommandeDAO;
use App\Http\Requests\passercommande;
use App\Models\commande;
use App\Repository\Interface\CommandeInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\plantes;
use Illuminate\Support\Str;

class CommandeController extends Controller
{
    protected $commandeRepository;

    public function __construct(CommandeInterface $commandeRepository)
    {
        $this->commandeRepository = $commandeRepository;
    }

    public function passerCommande(passercommande  $request)
    {
        

        $validated = $request->validated();
        try {
            $slugquantites = [];
            
            foreach ($validated['plantes'] as $plante) {
                $slug = Str::slug($plante['slug']);
                $quantite = $plante['quantite'];
                if (!Plantes::where('slug', $slug)->exists()) {
                    return response()->json([
                        'error' => "Plante avec le slug '{$slug}' non trouvée."
                    ], 404);
                }

                $slugQuantites[$slug] = $quantite;
        
            }
            
            $commande = $this->commandeRepository->create([
                'user_id' => $validated['user_id'],
                'slug_quantites' => $slugquantites,  
            ]);
        
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
    public function comandestatus($id)
    {
        if (Auth::user()->role->nomerole !== 'employe') {
           
            return response()->json(['error' => 'Accès refusé'], 403);
        }
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json(['error' => 'Commande introuvable'], 404);
        }
        $commande->update(['status' => Commande::STATUS_PRETE]);

        return response()->json([
            'message' => 'Commande marquée comme prête à être livrée',
            'commande' => $commande
        ]);
    }
}

