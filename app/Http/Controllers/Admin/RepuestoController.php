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
        $sucursalId = auth()->user()->sucursal_id; 

        $repuestos = DB::table('producto_marcas')
            ->join('productos', 'productos.id', '=', 'producto_marcas.producto_id')
            ->join($nombreTabla, 'productos.id', '=', $nombreTabla . '.producto_id')
            ->leftJoin('marcas', 'producto_marcas.marca_id', '=', 'marcas.id')
            ->join('stock', function($join) use ($sucursalId) {
                $join->on('producto_marcas.id', '=', 'stock.producto_marca_id')
                     ->where('stock.sucursal_id', '=', $sucursalId);
            })
            ->select(
                'producto_marcas.id as pm_id', 
                'productos.id as producto_id',
                'productos.codigo_interno',
                'productos.descripcion',
                'productos.imagen',
                'marcas.nombre as marca_nombre',
                'producto_marcas.precio_lista_dolares',
                $nombreTabla . '.*',
                'stock.cantidad as stock_sucursal',
                DB::raw('(SELECT COUNT(*) FROM detalle_ventas WHERE detalle_ventas.producto_marca_id = producto_marcas.id) = 0 as es_eliminable')
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
        $request->validate([
            'codigo_interno' => 'required', 
            'marca_id' => 'required',
            'precio_lista_dolares' => 'required|numeric',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'codigo_interno.required' => 'Debes escribir un código para el repuesto.',
            'marca_id.required' => 'Por favor, selecciona una marca.',
            'precio_lista_dolares.numeric' => 'El precio debe ser un número.',
        ]);

        $nombreTabla = $this->tablas[$tipo];

        $existeDuplicadoIdentico = DB::table('productos')
            ->join('producto_marcas', 'productos.id', '=', 'producto_marcas.producto_id')
            ->where('productos.codigo_interno', $request->codigo_interno)
            ->where('producto_marcas.marca_id', $request->marca_id)
            ->exists();

        if ($existeDuplicadoIdentico) {
            return back()->withErrors(['error' => '¡Error! Ya existe este código registrado para la marca seleccionada.'])->withInput();
        }

        $nombreImagen = null;
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $nombreImagen = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('imagenes'), $nombreImagen);
        }

        $sucursalId = auth()->user()->sucursal_id; 

        DB::transaction(function () use ($request, $tipo, $nombreTabla, $nombreImagen, $sucursalId) {
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
                    'sentido' => $request->sentido
                ];
            } elseif ($tipo == 'inducido') {
                $datosTecnicos += [
                    'voltaje' => $request->voltaje, 
                    'largo' => $request->largo, 
                    'diametro_externo' => $request->diametro_externo, 
                    'estrias' => $request->estrias, 
                    'delgas' => $request->delgas, 
                    'codigo_original' => $request->codigo_original
                ];
            } elseif ($tipo == 'regulador') {
                $datosTecnicos += [
                    'sistema' => $request->sistema, 
                    'voltaje' => $request->voltaje, 
                    'terminales' => $request->terminales, 
                    'circuito' => $request->circuito, 
                    'capacitor' => $request->has('capacitor') ? 1 : 0
                ];
            }

            DB::table($nombreTabla)->insert($datosTecnicos);

            $pm_id = DB::table('producto_marcas')->insertGetId([
                'producto_id' => $productoId,
                'marca_id' => $request->marca_id,
                'precio_lista_dolares' => $request->precio_lista_dolares
            ]);

            DB::table('stock')->insert([
                'producto_marca_id' => $pm_id,
                'sucursal_id' => $sucursalId,
                'cantidad' => $request->stock_inicial ?? 0
            ]);
        });

        return redirect()->route('admin.repuestos.index', $tipo)->with('success', 'Repuesto registrado con éxito.');
    }

    public function edit($tipo, $id) {
        if (!array_key_exists($tipo, $this->tablas)) {
            return redirect()->route('admin.dashboard');
        }

        $nombreTabla = $this->tablas[$tipo];
        $marcas = DB::table('marcas')->get();
        $sucursalId = auth()->user()->sucursal_id;

        $repuesto = DB::table('producto_marcas')
            ->join('productos', 'productos.id', '=', 'producto_marcas.producto_id')
            ->join($nombreTabla, 'productos.id', '=', $nombreTabla . '.producto_id')
            ->leftJoin('stock', function($join) use ($sucursalId) {
                $join->on('producto_marcas.id', '=', 'stock.producto_marca_id')
                     ->where('stock.sucursal_id', '=', $sucursalId);
            })
            ->select('producto_marcas.*', 'productos.*', $nombreTabla . '.*', 'stock.cantidad as stock_actual', 'producto_marcas.id as pm_id')
            ->where('producto_marcas.id', $id)
            ->first();

        if (!$repuesto) {
            return redirect()->route('admin.repuestos.index', $tipo)->with('error', 'Repuesto no encontrado.');
        }

        return view('admin.repuestos.edit', compact('repuesto', 'tipo', 'marcas'));
    }

    public function update(Request $request, $tipo, $id) {
        $pm = DB::table('producto_marcas')->where('id', $id)->first();
        if (!$pm) return back();
        
        $productoId = $pm->producto_id;
        $productoActual = DB::table('productos')->where('id', $productoId)->first();

        $request->validate([
            'codigo_interno' => 'required',
            'precio_lista_dolares' => 'required|numeric',
        ]);

        $nombreImagen = $productoActual->imagen;
        if ($request->hasFile('imagen')) {
            if ($productoActual->imagen && File::exists(public_path('imagenes/' . $productoActual->imagen))) {
                File::delete(public_path('imagenes/' . $productoActual->imagen));
            }
            $file = $request->file('imagen');
            $nombreImagen = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('imagenes'), $nombreImagen);
        }
        
        DB::transaction(function () use ($request, $tipo, $productoId, $id, $nombreImagen) {
            $nombreTabla = $this->tablas[$tipo];
            $sucursalId = auth()->user()->sucursal_id;

            DB::table('productos')->where('id', $productoId)->update([
                'codigo_interno' => $request->codigo_interno,
                'descripcion' => $request->descripcion,
                'imagen' => $nombreImagen
            ]);
            
            $datosTecnicos = [];
            if ($tipo == 'bendix') {
                $datosTecnicos = ['codigo_zen' => $request->codigo_zen, 'dientes' => $request->dientes, 'diametro_externo' => $request->diametro_externo, 'diametro_interno' => $request->diametro_interno, 'estrias' => $request->estrias, 'largo' => $request->largo, 'sentido' => $request->sentido];
            } elseif ($tipo == 'inducido') {
                $datosTecnicos = ['voltaje' => $request->voltaje, 'largo' => $request->largo, 'diametro_externo' => $request->diametro_externo, 'estrias' => $request->estrias, 'delgas' => $request->delgas, 'codigo_original' => $request->codigo_original];
            } elseif ($tipo == 'regulador') {
                $datosTecnicos = ['sistema' => $request->sistema, 'voltaje' => $request->voltaje, 'terminales' => $request->terminales, 'circuito' => $request->circuito, 'capacitor' => $request->has('capacitor') ? 1 : 0];
            }
            DB::table($nombreTabla)->where('producto_id', $productoId)->update($datosTecnicos);

            DB::table('producto_marcas')->where('id', $id)->update([
                'marca_id' => $request->marca_id, 
                'precio_lista_dolares' => $request->precio_lista_dolares
            ]);

            DB::table('stock')->updateOrInsert(
                ['producto_marca_id' => $id, 'sucursal_id' => $sucursalId],
                ['cantidad' => $request->stock_actual]
            );
        });

        return redirect()->route('admin.repuestos.index', $tipo)->with('success', 'Repuesto actualizado correctamente.');
    }

    public function destroy($id) {
        $enVenta = DB::table('detalle_ventas')->where('producto_marca_id', $id)->exists();
        if ($enVenta) return back()->with('error', 'No se puede eliminar porque ya se han realizado ventas de este producto.');

        $pm = DB::table('producto_marcas')->where('id', $id)->first();
        if (!$pm) return back();

        $productoId = $pm->producto_id;
        $producto = DB::table('productos')->where('id', $productoId)->first();
        $tipo = $producto->tipo;
        $nombreTablaTecnica = $this->tablas[$tipo];

        DB::transaction(function () use ($id, $productoId, $nombreTablaTecnica, $producto) {
            DB::table('stock')->where('producto_marca_id', $id)->delete();
            DB::table('producto_marcas')->where('id', $id)->delete();
            DB::table($nombreTablaTecnica)->where('producto_id', $productoId)->delete();
            DB::table('productos')->where('id', $productoId)->delete();

            if ($producto->imagen && File::exists(public_path('imagenes/' . $producto->imagen))) {
                File::delete(public_path('imagenes/' . $producto->imagen));
            }
        });

        return back()->with('success', 'Eliminado correctamente.');
    }
}