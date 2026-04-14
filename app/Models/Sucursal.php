<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    // Indicamos que la tabla se llama 'sucursales' como en tu SQL
    protected $table = 'sucursales';

    protected $fillable = [
        'nombre',
    ];

    // Desactivamos timestamps si tu tabla no tiene created_at y updated_at
    public $timestamps = false;

    /**
     * Relación inversa: Una sucursal tiene muchos usuarios.
     */
    public function usuarios()
    {
        return $this->hasMany(User::class, 'sucursal_id');
    }
}