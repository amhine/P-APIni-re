<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistiquesController extends Controller
{
    public function topPlantes()
    {
        $topPlantes = DB::table('commande_plante')
            ->join('plantes', 'commande_plante.plante_id', '=', 'plantes.id')
            ->select('plantes.name', 'plantes.slug', DB::raw('SUM(commande_plante.quantite) as total_commandes'))
            ->groupBy('plantes.id', 'plantes.name', 'plantes.slug')
            ->orderByDesc('total_commandes')
            ->limit(5)
            ->get();

        return response()->json($topPlantes);
    }
 
    
    public function statistiquesParStatut()
    {
        $statistiquesParStatut = DB::table('commandes')
            ->select('status', DB::raw('COUNT(id) as total_commandes'))
            ->groupBy('status')
            ->get();

        return response()->json($statistiquesParStatut);
    }
}
