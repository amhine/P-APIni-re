<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catégories extends Model
{
    use HasFactory;
    protected $table='catégories';
    protected $fillable=[
        'name'
    ];
    public function plantes()
    {
        return $this->hasMany(Plantes::class);
    }
}
