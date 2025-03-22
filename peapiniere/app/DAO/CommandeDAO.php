<?php
namespace App\DAO;

use App\Models\Commande;
use App\Models\Plantes;
use Illuminate\Support\Facades\DB;

class CommandeDAO
{
   
    public function createCommande($iduser, $plante)
    {
        DB::beginTransaction();

        try {
            $commande = Commande::create([
                'user_id' => $iduser,
                'status' => 'en attente', 
            ]);

        
            $plantes = [];
            foreach ($plante as $slug => $quantite) {
                $plante = Plantes::where('slug', $slug)->first();

                if ($plante) {
                    $plantes[$plante->id] = ['quantite' => $quantite];
                }
            }

            $commande->plantes()->attach($plantes);

            DB::commit();

            return $commande;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
