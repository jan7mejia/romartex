<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre', 'apellido', 'email', 'password', 'rol', 'celular', 'sucursal_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // ESTO CORRIGE EL ERROR DE BCRYPT PARA TUS DATOS MANUALES
    public function getAuthPassword()
    {
        return $this->password;
    }
}