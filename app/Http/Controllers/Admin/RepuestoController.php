<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RepuestoController extends Controller
{
    protected $tablas = [
        'bendix' => 'bendix',
        'inducido' => 'inducidos',
        'regulador' => 'reguladores'
    ];

    public function index($tipo) {
        if (!array_key_exists($tipo, $this->tablas)) {
            return redirect()->route('admin.dashboard');
        }

        $nombreTabla = $this->tablas[$tipo];

        $repuestos = DB::table('producto_marcas')
            ->join('productos', 'productos.id', '=', 'producto_marcas.producto_id')
            ->join($nombreTabla, 'productos.id', '=', $nombreTabla . '.producto_id')
            ->leftJoin('marcas', 'producto_marcas.marca_id', '=', 'marcas.id')
            ->select(
                'producto_marcas.id as pm_id', 
                'productos.id as producto_id',
                'productos.codigo_interno',
                'productos.descripcion',
                'productos.imagen',
                'marcas.nombre as marca_nombre',
                'producto_marcas.precio_lista_dolares',
                $nombreTabla . '.*' // Trae todas las columnas técnicas (dientes, voltaje, delgas, etc.)
            )
            ->where('productos.tipo', $tipo)
            ->get();

        return view('admin.repuestos.index', compact('repuestos', 'tipo'));
    }

    public function create($tipo) {
        $marcas = DB::table('marcas')->get();
        return view('admin.repuestos.create', compact('tipo', 'marcas'));
    }

    public function store(Request $request, $tipo) {
        $nombreTabla = $this->tablas[$tipo];
        $nombreImagen = null;

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $nombreImagen = $tipo . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('imagenes'), $nombreImagen);
        }

        DB::transaction(function () use ($request, $tipo, $nombreTabla, $nombreImagen) {
            $productoId = DB::table('productos')->insertGetId([
                'tipo' => $tipo,
                'codigo_interno' => $request->codigo_interno,
                'descripcion' => $request->descripcion,
                'imagen' => $nombreImagen
            ]);

            $datosTecnicos = ['producto_id' => $productoId];

            if ($tipo == 'bendix') {
                $datosTecnicos += [
                    'codigo_zen' => $request->codigo_zen,
                    'dientes' => $request->dientes,
                    'diametro_externo' => $request->diametro_externo,
                    'diametro_interno' => $request->diametro_interno,
                    'estrias' => $request->estrias,
                    'largo' => $request->largo,
                    'sentido' => $request->sentido,
                ];
            } elseif ($tipo == 'inducido') {
                $datosTecnicos += [
                    'voltaje' => $request->voltaje,
                    'largo' => $request->largo,
                    'diametro_externo' => $request->diametro_externo,
                    'estrias' => $request->estrias,
                    'delgas' => $request->delgas,
                    'codigo_original' => $request->codigo_original,
                ];
            } elseif ($tipo == 'regulador') {
                $datosTecnicos += [
                    'sistema' => $request->sistema,
                    'voltaje' => $request->voltaje,
                    'terminales' => $request->terminales,
                    'circuito' => $request->circuito,
                    'capacitor' => $request->has('capacitor') ? 1 : 0,
                ];
            }

            DB::table($nombreTabla)->insert($datosTecnicos);

            DB::table('producto_marcas')->insert([
                'producto_id' => $productoId,
                'marca_id' => $request->marca_id,
                'precio_lista_dolares' => $request->precio_lista_dolares
            ]);
        });

        return redirect()->route('admin.repuestos.index', $tipo)->with('success', 'Repuesto creado correctamente.');
    }

    public function edit($tipo, $id) {
        $nombreTabla = $this->tablas[$tipo];
        $marcas = DB::table('marcas')->get();

        $repuesto = DB::table('producto_marcas')
            ->join('productos', 'productos.id', '=', 'producto_marcas.producto_id')
            ->join($nombreTabla, 'productos.id', '=', $nombreTabla . '.producto_id')
            ->select(
                'productos.*',
                'producto_marcas.id as pm_id',
                'producto_marcas.precio_lista_dolares',
                'producto_marcas.marca_id',
                $nombreTabla . '.*'
            )
            ->where('producto_marcas.id', $id)
            ->first();

        if (!$repuesto) return redirect()->route('admin.repuestos.index', $tipo);

        return view('admin.repuestos.edit', compact('tipo', 'marcas', 'repuesto'));
    }

    public function update(Request $request, $tipo, $id) {
        $nombreTabla = $this->tablas[$tipo];
        $pm = DB::table('producto_marcas')->where('id', $id)->first();
        if (!$pm) return back();

        $productoId = $pm->producto_id;

        DB::transaction(function () use ($request, $tipo, $nombreTabla, $productoId, $id) {
            DB::table('productos')->where('id', $productoId)->update([
                'codigo_interno' => $request->codigo_interno,
                'descripcion' => $request->descripcion
            ]);

            $datosTecnicos = [];
            if ($tipo == 'bendix') {
                $datosTecnicos = [
                    'codigo_zen' => $request->codigo_zen,
                    'dientes' => $request->dientes,
                    'diametro_externo' => $request->diametro_externo,
                    'diametro_interno' => $request->diametro_interno,
                    'estrias' => $request->estrias,
                    'largo' => $request->largo,
                    'sentido' => $request->sentido,
                ];
            } elseif ($tipo == 'inducido') {
                $datosTecnicos = [
                    'voltaje' => $request->voltaje,
                    'largo' => $request->largo,
                    'diametro_externo' => $request->diametro_externo,
                    'estrias' => $request->estrias,
                    'delgas' => $request->delgas,
                    'codigo_original' => $request->codigo_original,
                ];
            } elseif ($tipo == 'regulador') {
                $datosTecnicos = [
                    'sistema' => $request->sistema,
                    'voltaje' => $request->voltaje,
                    'terminales' => $request->terminales,
                    'circuito' => $request->circuito,
                    'capacitor' => $request->has('capacitor') ? 1 : 0,
                ];
            }

            DB::table($nombreTabla)->where('producto_id', $productoId)->update($datosTecnicos);

            DB::table('producto_marcas')->where('id', $id)->update([
                'marca_id' => $request->marca_id,
                'precio_lista_dolares' => $request->precio_lista_dolares
            ]);
        });

        return redirect()->route('admin.repuestos.index', $tipo)->with('success', 'Actualizado correctamente');
    }

    public function destroy($id) {
        $pm = DB::table('producto_marcas')->where('id', $id)->first();
        if (!$pm) return back();

        $enVenta = DB::table('detalle_ventas')->where('producto_marca_id', $id)->exists();
        if ($enVenta) return back()->with('error', 'No se puede eliminar, ya fue vendido');

        DB::table('producto_marcas')->where('id', $id)->delete();
        return back()->with('success', 'Eliminado correctamente');
    }
}