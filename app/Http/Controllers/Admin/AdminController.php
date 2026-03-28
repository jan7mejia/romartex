<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Contamos registros de tus tablas
        $cantBendix = DB::table('bendix')->count();
        $cantInducidos = DB::table('inducidos')->count();
        $cantReguladores = DB::table('reguladores')->count();

        // Obtenemos ventas con las columnas reales de tu DB
        $ultimasVentas = DB::table('ventas')
            ->join('usuarios', 'ventas.usuario_id', '=', 'usuarios.id')
            ->select(
                'ventas.id',
                'ventas.fecha',
                'ventas.total',
                'usuarios.nombre',
                'usuarios.apellido'
            )
            ->orderBy('ventas.fecha', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('cantBendix', 'cantInducidos', 'cantReguladores', 'ultimasVentas'));
    }

    public function verVentaDetalle($id)
    {
        $venta = DB::table('ventas')
            ->join('usuarios', 'ventas.usuario_id', '=', 'usuarios.id')
            ->select(
                'ventas.id',
                'ventas.fecha',
                'ventas.total',
                'usuarios.nombre',
                'usuarios.apellido',
                'usuarios.email'
            )
            ->where('ventas.id', $id)
            ->first();

        if (!$venta) return redirect()->route('admin.dashboard');

        $detalles = DB::table('detalle_ventas')
            ->join('producto_marcas', 'detalle_ventas.producto_marca_id', '=', 'producto_marcas.id')
            ->join('productos', 'producto_marcas.producto_id', '=', 'productos.id')
            ->join('marcas', 'producto_marcas.marca_id', '=', 'marcas.id')
            ->select(
                'productos.codigo',
                'productos.tipo',
                'marcas.nombre as marca_nombre',
                'detalle_ventas.cantidad',
                'detalle_ventas.precio_final',
                DB::raw('(detalle_ventas.cantidad * detalle_ventas.precio_final) as subtotal')
            )
            ->where('detalle_ventas.venta_id', $id)
            ->get();

        return view('admin.ventas.detalle', compact('venta', 'detalles'));
    }
}