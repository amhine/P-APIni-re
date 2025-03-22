<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commande extends Model
{
    use HasFactory;
    protected $table ='commandes';
    protected $fillable = [
        'nome',
        'status'
    ];
    public function utilisateur()
    {
        return $this->belongsTo(user::class);
    }
    public function plante()
    {
        return $this->belongsTo(Plantes::class);
    }
}
