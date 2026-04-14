<?php

namespace App\Http\Controllers\Vendedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarcaController extends Controller
{
    public function index()
    {
        // Obtenemos las marcas y contamos cuántos productos tienen asociados
        $marcas = DB::table('marcas as m')
            ->leftJoin('producto_marcas as pm', 'm.id', '=', 'pm.marca_id')
            ->select('m.id', 'm.nombre', DB::raw('COUNT(pm.producto_id) as total_productos'))
            ->groupBy('m.id', 'm.nombre')
            ->orderBy('m.nombre', 'asc')
            ->get();

        // Necesitamos el tipo de cambio para el header component
        $tipoCambio = DB::table('configuraciones')
            ->where('parametro', 'tipo_cambio_usd')
            ->value('valor') ?? 6.96;

        return view('vendedor.marcas', compact('marcas', 'tipoCambio'));
    }
}