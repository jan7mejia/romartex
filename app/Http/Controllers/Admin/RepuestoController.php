<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepuestoController extends Controller
{
    public function index($tipo)
{
    if (!in_array($tipo, ['bendix', 'inducido', 'regulador'])) {
        return redirect()->route('admin.dashboard');
    }

    // Mapeo exacto según tus tablas de SQL
    if ($tipo === 'bendix') {
        $tabla = 'bendix';
    } elseif ($tipo === 'inducido') {
        $tabla = 'inducidos';
    } else {
        $tabla = 'reguladores';
    }

    $repuestos = DB::table($tabla)
        ->join('productos', $tabla . '.producto_id', '=', 'productos.id')
        ->join('producto_marcas', 'productos.id', '=', 'producto_marcas.producto_id')
        ->join('marcas', 'producto_marcas.marca_id', '=', 'marcas.id')
        ->select(
            'productos.id as producto_id',
            'productos.codigo',
            'marcas.nombre as marca_nombre',
            'producto_marcas.precio_dolares',
            $tabla . '.*'
        )
        ->get();

    return view('admin.repuestos.index', compact('repuestos', 'tipo'));
}

    public function create($tipo)
    {
        $marcas = DB::table('marcas')->get();
        return view('admin.repuestos.create', compact('tipo', 'marcas'));
    }

    public function store(Request $request, $tipo)
    {
        $tabla = ($tipo === 'bendix') ? 'bendix' : $tipo . 's';

        DB::transaction(function () use ($request, $tipo, $tabla) {
            // 1. Insertar en tabla productos (según tu SQL)
            $productoId = DB::table('productos')->insertGetId([
                'tipo' => $tipo,
                'codigo' => $request->codigo,
                'descripcion' => $request->descripcion,
                'imagen' => $request->imagen
            ]);

            // 2. Insertar en la tabla técnica específica
            if ($tipo === 'bendix') {
                DB::table('bendix')->insert([
                    'producto_id' => $productoId,
                    'dientes' => $request->dientes,
                    'estrias' => $request->estrias,
                    'largo' => $request->largo,
                    'sentido' => $request->sentido,
                    'diametro_externo' => $request->diametro_externo,
                    'diametro_interno' => $request->diametro_interno,
                ]);
            } elseif ($tipo === 'inducido') {
                DB::table('inducidos')->insert([
                    'producto_id' => $productoId,
                    'voltaje' => $request->voltaje,
                    'largo' => $request->largo,
                    'diametro' => $request->diametro,
                    'estrias' => $request->estrias,
                    'delgas' => $request->delgas,
                ]);
            } elseif ($tipo === 'regulador') {
                DB::table('reguladores')->insert([
                    'producto_id' => $productoId,
                    'sistema' => $request->sistema,
                    'voltaje' => $request->voltaje,
                    'terminales' => $request->terminales,
                    'circuito' => $request->circuito,
                ]);
            }

            // 3. Vincular Marca y Precio
            DB::table('producto_marcas')->insert([
                'producto_id' => $productoId,
                'marca_id' => $request->marca_id,
                'precio_dolares' => $request->precio
            ]);
        });

        return redirect()->route('admin.repuestos.index', $tipo)->with('success', 'Registrado con éxito');
    }

    public function destroy($id)
    {
        DB::table('productos')->where('id', $id)->delete();
        return back()->with('success', 'Eliminado correctamente');
    }
}