<?php

namespace App\Http\Controllers\Vendedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon; 

class VentaController extends Controller
{
    public function store(Request $request)
    {
        // Validar datos incluyendo el nuevo campo de precio regateado (precio_final)
        $request->validate([
            'producto_marca_id' => 'required|exists:producto_marcas,id',
            'cantidad' => 'required|integer|min:1',
            'precio_final' => 'required|numeric|min:0', // Este es el campo del "Regateo"
        ]);

        try {
            DB::beginTransaction();

            $usuario = Auth::user();
            $sucursalId = $usuario->sucursal_id;

            // 1. Obtener el precio de lista original y el tipo de cambio
            $productoMarca = DB::table('producto_marcas')
                ->where('id', $request->producto_marca_id)
                ->first();

            $tipoCambio = DB::table('configuraciones')
                ->where('parametro', 'tipo_cambio_usd') 
                ->value('valor') ?? 6.96; 

            // 2. Buscar el registro exacto en la tabla stock para esa sucursal
            $stock = DB::table('stock')
                ->where('producto_marca_id', $request->producto_marca_id)
                ->where('sucursal_id', $sucursalId)
                ->lockForUpdate()
                ->first();

            // Verificar si existe el registro de stock y si hay suficiente cantidad
            if (!$stock || $stock->cantidad < $request->cantidad) {
                return back()->with('error', 'Stock insuficiente. Disponible: ' . ($stock->cantidad ?? 0));
            }

            // 3. Calcular total usando el precio regateado
            $totalVentaUSD = $request->precio_final * $request->cantidad;
            $totalVentaBS = $totalVentaUSD * $tipoCambio;
            
            // 4. Crear el registro de la Venta (MEJORA: Ajuste de Zona Horaria Bolivia)
            $ventaId = DB::table('ventas')->insertGetId([
                'usuario_id' => $usuario->id,
                'sucursal_id' => $sucursalId,
                'fecha_hora' => Carbon::now('America/La_Paz'), // <--- Esto garantiza hora de Bolivia
                'total_venta' => $totalVentaUSD,
            ]);

            // 5. Crear el Detalle de la Venta
            DB::table('detalle_ventas')->insert([
                'venta_id' => $ventaId,
                'producto_marca_id' => $request->producto_marca_id,
                'cantidad' => $request->cantidad,
                'precio_lista' => $productoMarca->precio_lista_dolares,
                'precio_final_cobrado' => $request->precio_final,
            ]);

            // 6. DESCONTAR EL STOCK
            DB::table('stock')
                ->where('id', $stock->id)
                ->decrement('cantidad', $request->cantidad);

            DB::commit();

            // Mensaje optimizado para el Modal
            return back()->with('success', "Se procesó la venta de {$request->cantidad} unidades por un total de $" . number_format($totalVentaUSD, 2) . " (" . number_format($totalVentaBS, 2) . " Bs).");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error crítico: ' . $e->getMessage());
        }
    }
}