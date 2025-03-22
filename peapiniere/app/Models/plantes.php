<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plantes extends Model
{
    use HasFactory;
    protected $table ='plantes';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'prix'
    ];

    public function categories()
    {
        return $this->belongsToMany(catégories::class);
    }
}
