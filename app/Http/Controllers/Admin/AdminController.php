<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $sucursalId = Auth::user()->sucursal_id;

        $cantBendix = DB::table('bendix')
            ->join('productos', 'bendix.producto_id', '=', 'productos.id')
            ->join('producto_marcas', 'productos.id', '=', 'producto_marcas.producto_id')
            ->join('stock', 'producto_marcas.id', '=', 'stock.producto_marca_id')
            ->where('stock.sucursal_id', $sucursalId)
            ->where('stock.cantidad', '>', 0)
            ->distinct('productos.id')
            ->count();

        $cantInducidos = DB::table('inducidos')
            ->join('productos', 'inducidos.producto_id', '=', 'productos.id')
            ->join('producto_marcas', 'productos.id', '=', 'producto_marcas.producto_id')
            ->join('stock', 'producto_marcas.id', '=', 'stock.producto_marca_id')
            ->where('stock.sucursal_id', $sucursalId)
            ->where('stock.cantidad', '>', 0)
            ->distinct('productos.id')
            ->count();

        $cantReguladores = DB::table('reguladores')
            ->join('productos', 'reguladores.producto_id', '=', 'productos.id')
            ->join('producto_marcas', 'productos.id', '=', 'producto_marcas.producto_id')
            ->join('stock', 'producto_marcas.id', '=', 'stock.producto_marca_id')
            ->where('stock.sucursal_id', $sucursalId)
            ->where('stock.cantidad', '>', 0)
            ->distinct('productos.id')
            ->count();

        $sucursalAdmin = DB::table('sucursales')->where('id', $sucursalId)->value('nombre');

        $ultimasVentas = DB::table('ventas')
            ->join('usuarios', 'ventas.usuario_id', '=', 'usuarios.id')
            ->join('sucursales', 'ventas.sucursal_id', '=', 'sucursales.id')
            ->select(
                'ventas.id',
                'ventas.fecha_hora',
                'ventas.total_venta',
                'usuarios.nombre',
                'usuarios.apellido',
                'sucursales.nombre as sucursal_nombre'
            )
            ->where('ventas.sucursal_id', $sucursalId)
            ->orderBy('ventas.fecha_hora', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('cantBendix', 'cantInducidos', 'cantReguladores', 'ultimasVentas', 'sucursalAdmin'));
    }

    public function verVentaDetalle($id)
    {
        $venta = DB::table('ventas')
            ->join('usuarios', 'ventas.usuario_id', '=', 'usuarios.id')
            ->join('sucursales', 'ventas.sucursal_id', '=', 'sucursales.id')
            ->select(
                'ventas.id', 
                'ventas.fecha_hora as fecha', 
                'ventas.total_venta as total', 
                'usuarios.nombre', 
                'usuarios.apellido', 
                'usuarios.email', 
                'sucursales.nombre as sucursal_nombre'
            )
            ->where('ventas.id', $id)
            ->where('ventas.sucursal_id', Auth::user()->sucursal_id)
            ->first();

        if (!$venta) return redirect()->route('admin.dashboard');

        $detalles = DB::table('detalle_ventas')
            ->join('producto_marcas', 'detalle_ventas.producto_marca_id', '=', 'producto_marcas.id')
            ->join('productos', 'producto_marcas.producto_id', '=', 'productos.id')
            ->join('marcas', 'producto_marcas.marca_id', '=', 'marcas.id')
            // Joins para traer TODAS las especificaciones de cada tipo
            ->leftJoin('bendix', 'productos.id', '=', 'bendix.producto_id')
            ->leftJoin('inducidos', 'productos.id', '=', 'inducidos.producto_id')
            ->leftJoin('reguladores', 'productos.id', '=', 'reguladores.producto_id')
            ->select(
                'productos.codigo_interno as codigo',
                'productos.tipo',
                'marcas.nombre as marca_nombre',
                'detalle_ventas.cantidad',
                'detalle_ventas.precio_final_cobrado as precio_final',
                DB::raw('(detalle_ventas.cantidad * detalle_ventas.precio_final_cobrado) as subtotal'),
                
                // ESPECIFICACIONES BENDIX
                'bendix.codigo_zen', 'bendix.dientes', 'bendix.estrias', 'bendix.sentido', 
                'bendix.diametro_externo as b_ext', 'bendix.diametro_interno as b_int', 'bendix.largo as b_largo',
                
                // ESPECIFICACIONES INDUCIDOS
                'inducidos.voltaje as i_voltaje', 'inducidos.largo as i_largo', 
                'inducidos.diametro_externo as i_ext', 'inducidos.estrias as i_estrias', 
                'inducidos.delgas as i_delgas', 'inducidos.codigo_original as i_original',
                
                // ESPECIFICACIONES REGULADORES
                'reguladores.sistema as r_sistema', 'reguladores.voltaje as r_voltaje', 
                'reguladores.terminales as r_term', 'reguladores.circuito as r_circuito', 'reguladores.capacitor as r_cap'
            )
            ->where('detalle_ventas.venta_id', $id)
            ->get();

        return view('admin.ventas.detalle', compact('venta', 'detalles'));
    }
}