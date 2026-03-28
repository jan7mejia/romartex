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
        if (!array_key_exists($tipo, $this->tablas)) return redirect()->route('admin.dashboard');
        $nombreTabla = $this->tablas[$tipo];
        $repuestos = DB::table($nombreTabla)
            ->join('productos', $nombreTabla . '.producto_id', '=', 'productos.id')
            ->join('producto_marcas', 'productos.id', '=', 'producto_marcas.producto_id')
            ->join('marcas', 'producto_marcas.marca_id', '=', 'marcas.id')
            ->select('productos.*', 'marcas.nombre as marca_nombre', 'producto_marcas.precio_dolares', 'producto_marcas.marca_id', $nombreTabla . '.*')
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
                'tipo' => $tipo, 'codigo' => $request->codigo, 'descripcion' => $request->descripcion, 'imagen' => $nombreImagen
            ]);

            $datosTecnicos = $this->mapearDatosTecnicos($request, $tipo, $productoId);
            DB::table($nombreTabla)->insert($datosTecnicos);

            DB::table('producto_marcas')->insert([
                'producto_id' => $productoId, 'marca_id' => $request->marca_id, 'precio_dolares' => $request->precio
            ]);
        });
        return redirect()->route('admin.repuestos.index', $tipo);
    }

    public function edit($tipo, $id) {
        $nombreTabla = $this->tablas[$tipo];
        $marcas = DB::table('marcas')->get();
        $repuesto = DB::table($nombreTabla)
            ->join('productos', $nombreTabla . '.producto_id', '=', 'productos.id')
            ->join('producto_marcas', 'productos.id', '=', 'producto_marcas.producto_id')
            ->select('productos.*', 'producto_marcas.precio_dolares as precio', 'producto_marcas.marca_id', $nombreTabla . '.*')
            ->where('productos.id', $id)
            ->first();
        return view('admin.repuestos.edit', compact('tipo', 'marcas', 'repuesto'));
    }

    public function update(Request $request, $tipo, $id) {
        $nombreTabla = $this->tablas[$tipo];
        $producto = DB::table('productos')->where('id', $id)->first();

        $nombreImagen = $producto->imagen;
        if ($request->hasFile('imagen')) {
            if ($nombreImagen && File::exists(public_path('imagenes/' . $nombreImagen))) File::delete(public_path('imagenes/' . $nombreImagen));
            $file = $request->file('imagen');
            $nombreImagen = $tipo . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('imagenes'), $nombreImagen);
        }

        DB::transaction(function () use ($request, $tipo, $id, $nombreTabla, $nombreImagen) {
            DB::table('productos')->where('id', $id)->update([
                'codigo' => $request->codigo, 'descripcion' => $request->descripcion, 'imagen' => $nombreImagen
            ]);

            $datosTecnicos = $this->mapearDatosTecnicos($request, $tipo, $id);
            DB::table($nombreTabla)->where('producto_id', $id)->update($datosTecnicos);

            DB::table('producto_marcas')->where('producto_id', $id)->update([
                'marca_id' => $request->marca_id, 'precio_dolares' => $request->precio
            ]);
        });
        return redirect()->route('admin.repuestos.index', $tipo);
    }

    public function destroy($id) {
        $producto = DB::table('productos')->where('id', $id)->first();
        if ($producto->imagen && File::exists(public_path('imagenes/' . $producto->imagen))) {
            File::delete(public_path('imagenes/' . $producto->imagen));
        }
        DB::table('productos')->where('id', $id)->delete();
        return back();
    }

    private function mapearDatosTecnicos($request, $tipo, $productoId) {
        $datos = ['producto_id' => $productoId];
        if ($tipo === 'bendix') {
            return array_merge($datos, [
                'dientes' => $request->dientes, 'estrias' => $request->estrias, 'sentido' => $request->sentido,
                'diametro_externo' => $request->diametro_externo, 'diametro_interno' => $request->diametro_interno, 'largo' => $request->largo,
            ]);
        } elseif ($tipo === 'inducido') {
            return array_merge($datos, [
                'voltaje' => $request->voltaje, 'largo' => $request->largo, 'diametro' => $request->diametro,
                'estrias' => $request->estrias, 'delgas' => $request->delgas, 'codigo_original' => $request->codigo_original,
            ]);
        } elseif ($tipo === 'regulador') {
            return array_merge($datos, [
                'sistema' => $request->sistema, 'voltaje' => $request->voltaje, 'terminales' => $request->terminales,
                'circuito' => $request->circuito, 'capacitor' => $request->has('capacitor') ? 1 : 0,
            ]);
        }
        return $datos;
    }
}