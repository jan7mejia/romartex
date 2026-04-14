<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre', 
        'apellido', 
        'email', 
        'password', 
        'rol', 
        'celular', 
        'sucursal_id'
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    /**
     * Relación con la sucursal.
     * Permite acceder al nombre de la sucursal desde el Header.
     */
    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}