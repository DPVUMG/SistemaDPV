<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class BrandController extends Controller
{
    ///Vista de la pantalla de todos los registros
    public function index(Request $request)
    {
        if($request->has('search'))
            $items = Brand::search($request->search)->orderBy('name','asc')->paginate(10);
        else
            $items = Brand::orderBy('name','asc')->paginate(10);

        return view('system.brand.index', compact('items'));
    }

    //Insert de datos
    public function store(Request $request)
    {
        $this->validate($request, $this->rules(), $this->messages());

        Brand::create($request->all());
        toastr()->success('Registro guardado.');
        return redirect()->route('brand.index');
    }

    //Vista de la pantalla para editar registro
    public function edit(Brand $brand)
    {
        return view('system.brand.edit', compact('brand'));
    }

    //Update de datos
    public function update(Request $request, Brand $brand)
    {
        $this->validate($request, $this->rules($brand->id), $this->messages());

        $brand->name = $request->name;

        if(!$brand->isDirty())
        {
            toastr()->info('El sistema no detecto cambios nuevos para guardar.');
            return redirect()->route('brand.index');
        }

        $brand->save();
        toastr()->success('Registro actualizado.');
        return redirect()->route('brand.index');
    }

    //Delete de datos
    public function delete(Brand $brand)
    {
        try {
            $brand->delete();
            toastr()->success('Registro eliminado.');
            return redirect()->route('brand.index');
        } catch (\Exception $e)
        {
            if ($e instanceof QueryException) {
                toastr()->error("El sistema no puede eliminar el registro {$brand->name}, porque tiene información asociada.");
                return redirect()->route('brand.index');
            }
        }
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = array();

        if(is_null($id))
        {
            $validar = [
                'name'=>'required|max:25|unique:brands,name'
            ];
        }
        else
        {
            $validar = [
                'name'=>'required|max:25|unique:brands,name,'.$id
            ];
        }

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'name.required' => 'El nombre de la marca es obligatorio.',
            'name.max'  => 'El nombre debe tener menos de :max caracteres.',
            'name.unique'  => 'El nombre de la marca ingresado ya existe en registrado en el sistema.'
        ];
    }
}
