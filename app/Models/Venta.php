<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['total', 'productos', 'fecha_venta'];

    protected $casts = [
        'productos' => 'array', // Para manejar los productos como un array en JSON
    ];
}
