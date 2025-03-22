<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commande extends Model
{
    use HasFactory;
    protected $table ='commandes';
    protected $fillable = [
        'status',
        'user_id'
    ];
    public function utilisateur()
    {
        return $this->belongsTo(user::class);
    }
    public function plantes()
{
    return $this->belongsToMany(Plantes::class, 'commande_plante', 'commande_id', 'plante_id')
                ->withPivot('quantite')
                ->withTimestamps();
}

}
