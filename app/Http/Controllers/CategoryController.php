<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    ///Vista de la pantalla de todos los registros
    public function index(Request $request)
    {
        if($request->has('search'))
            $items = Category::search($request->search)->orderBy('name','asc')->paginate(10);
        else
            $items = Category::orderBy('name','asc')->paginate(10);

        return view('system.category.index', compact('items'));
    }

    //Insert de datos
    public function store(Request $request)
    {
        $this->validate($request, $this->rules(), $this->messages());

        Category::create($request->all());
        toastr()->success('Registro guardado.');
        return redirect()->route('category.index');
    }

    //Vista de la pantalla para editar registro
    public function edit(Category $category)
    {
        return view('system.category.edit', compact('category'));
    }

    //Update de datos
    public function update(Request $request, Category $category)
    {
        $this->validate($request, $this->rules($category->id), $this->messages());

        $category->name = $request->name;

        if(!$category->isDirty())
        {
            toastr()->info('El sistema no detecto cambios nuevos para guardar.');
            return redirect()->route('category.index');
        }

        $category->save();
        toastr()->success('Registro actualizado.');
        return redirect()->route('category.index');
    }

    //Delete de datos
    public function delete(Category $category)
    {
        try {
            $category->delete();
            toastr()->success('Registro eliminado.');
            return redirect()->route('category.index');
        } catch (\Exception $e)
        {
            if ($e instanceof QueryException) {
                toastr()->error("El sistema no puede eliminar el registro {$category->name}, porque tiene información asociada.");
                return redirect()->route('category.index');
            }
        }
    }

    //Vista de la pantalla de sub categorías
    public function show(Request $request, Category $category)
    {
        if($request->has('search'))
            $items = SubCategory::with('category')->search($request->search)->where('category_id',$category->id)->orderBy('name','asc')->paginate(10);
        else
            $items = SubCategory::with('category')->where('category_id',$category->id)->orderBy('name','asc')->paginate(10);

        return view('system.sub_category.index', compact('items','category'));
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = array();

        if(is_null($id))
        {
            $validar = [
                'name'=>'required|max:25|unique:categories,name'
            ];
        }
        else
        {
            $validar = [
                'name'=>'required|max:25|unique:categories,name,'.$id
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
