<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Contamos los registros de tus tablas SQL de Romartex
        $cantBendix = DB::table('bendix')->count();
        $cantInducidos = DB::table('inducidos')->count();
        $cantReguladores = DB::table('reguladores')->count();

        // Obtenemos las últimas ventas uniendo con la tabla usuarios
        $ultimasVentas = DB::table('ventas')
            ->join('usuarios', 'ventas.usuario_id', '=', 'usuarios.id')
            ->select('usuarios.nombre as vendedor', 'ventas.fecha', 'ventas.total')
            ->orderBy('ventas.fecha', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'cantBendix', 
            'cantInducidos', 
            'cantReguladores', 
            'ultimasVentas'
        ));
    }
}