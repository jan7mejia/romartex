<?php

namespace App\Http\Controllers\Vendedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendedorController extends Controller
{
    public function index(Request $request)
    {
        $sucursalUsuario = auth()->user()->sucursal_id;

        $tipoCambio = DB::table('configuraciones')
            ->where('parametro', 'tipo_cambio_usd')
            ->value('valor') ?? 6.96;

        $marcas = DB::table('marcas')->get();

        // MEJORA: Iniciamos la consulta desde la tabla STOCK para asegurar 
        // que solo se vean productos que pertenecen a la sucursal actual.
        $query = DB::table('stock as s')
            ->join('producto_marcas as pm', 's.producto_marca_id', '=', 'pm.id')
            ->join('productos as p', 'pm.producto_id', '=', 'p.id')
            ->join('marcas as m', 'pm.marca_id', '=', 'm.id')
            ->leftJoin('bendix as b', 'p.id', '=', 'b.producto_id')
            ->leftJoin('inducidos as i', 'p.id', '=', 'i.producto_id')
            ->leftJoin('reguladores as r', 'p.id', '=', 'r.producto_id')
            ->leftJoin('producto_aplicacion as pa', 'p.id', '=', 'pa.producto_id')
            ->leftJoin('aplicaciones as a', 'pa.aplicacion_id', '=', 'a.id')
            ->where('s.sucursal_id', $sucursalUsuario); // Filtro crítico de sucursal

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('p.codigo_interno', 'LIKE', '%'.$search.'%')
                  ->orWhere('p.descripcion', 'LIKE', '%'.$search.'%')
                  ->orWhere('m.nombre', 'LIKE', '%'.$search.'%')
                  ->orWhere('b.codigo_zen', 'LIKE', '%'.$search.'%')
                  ->orWhere('i.codigo_original', 'LIKE', '%'.$search.'%')
                  ->orWhere('a.nombre', 'LIKE', '%'.$search.'%');
            });
        }

        if ($request->filled('tipo')) {
            $query->where('p.tipo', $request->tipo);
            if ($request->tipo == 'bendix') {
                if ($request->filled('dientes')) $query->where('b.dientes', $request->dientes);
                if ($request->filled('estrias')) $query->where('b.estrias', $request->estrias);
                if ($request->filled('largo'))   $query->where('b.largo', 'LIKE', $request->largo.'%');
                if ($request->filled('d_externo')) $query->where('b.diametro_externo', 'LIKE', $request->d_externo.'%');
                if ($request->filled('d_interno')) $query->where('b.diametro_interno', 'LIKE', $request->d_interno.'%');
            }
            if ($request->tipo == 'inducido') {
                if ($request->filled('sistema_i')) {
                    $query->where(function($q) use ($request) {
                        $q->where('p.descripcion', 'LIKE', '%'.$request->sistema_i.'%')
                          ->orWhere('i.codigo_original', 'LIKE', '%'.$request->sistema_i.'%');
                    });
                }
                if ($request->filled('voltaje'))   $query->where('i.voltaje', $request->voltaje);
                if ($request->filled('diametro'))  $query->where('i.diametro_externo', 'LIKE', $request->diametro.'%');
                if ($request->filled('estrias_i')) $query->where('i.estrias', $request->estrias_i);
                if ($request->filled('largo_i'))   $query->where('i.largo', 'LIKE', $request->largo_i.'%');
            }
            if ($request->tipo == 'regulador') {
                if ($request->filled('sistema'))    $query->where('r.sistema', 'LIKE', '%'.$request->sistema.'%');
                if ($request->filled('voltaje_r'))  $query->where('r.voltaje', $request->voltaje_r);
                if ($request->filled('circuito'))   $query->where('r.circuito', $request->circuito);
                if ($request->filled('capacitor'))  $query->where('r.capacitor', $request->capacitor);
                if ($request->filled('terminales')) $query->where('r.terminales', $request->terminales);
            }
        }

        if ($request->has('marcas')) {
            $query->whereIn('pm.marca_id', $request->marcas);
        }

        $productos = $query->select(
            'p.id as producto_id', 'p.tipo', 'p.codigo_interno', 'p.descripcion', 'p.imagen',
            'm.nombre as marca_nombre', 'pm.id as pm_id', 'pm.precio_lista_dolares',
            'b.codigo_zen', 'b.dientes', 'b.diametro_externo', 'b.diametro_interno', 'b.estrias as b_estrias', 'b.largo as b_largo', 'b.sentido',
            'i.voltaje as i_voltaje', 'i.largo as i_largo', 'i.diametro_externo as i_diametro', 'i.estrias as i_estrias', 'i.delgas', 'i.codigo_original',
            'r.sistema as r_sistema', 'r.voltaje as r_voltaje', 'r.terminales', 'r.circuito', 'r.capacitor',
            's.cantidad as stock_actual', // Obtenemos directamente la cantidad de la tabla s (stock)
            DB::raw("GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ', ') as aplicaciones_nombres"),
            DB::raw("(SELECT cantidad FROM stock WHERE producto_marca_id = pm.id AND sucursal_id = 1) as stock_s1"),
            DB::raw("(SELECT cantidad FROM stock WHERE producto_marca_id = pm.id AND sucursal_id = 2) as stock_s2")
        )
        ->groupBy(
            'p.id', 'p.tipo', 'p.codigo_interno', 'p.descripcion', 'p.imagen', 
            'm.nombre', 'pm.id', 'pm.precio_lista_dolares',
            'b.codigo_zen', 'b.dientes', 'b.diametro_externo', 'b.diametro_interno', 'b.estrias', 'b.largo', 'b.sentido',
            'i.voltaje', 'i.largo', 'i.diametro_externo', 'i.estrias', 'i.delgas', 'i.codigo_original',
            'r.sistema', 'r.voltaje', 'r.terminales', 'r.circuito', 'r.capacitor', 's.cantidad'
        )
        ->get();

        return view('catalogo', compact('productos', 'marcas', 'tipoCambio', 'sucursalUsuario'));
    }
}