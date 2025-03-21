<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;
    protected $table = 'roles';

    protected $fillable = [
        'nomerole'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_role'); 
    }
}