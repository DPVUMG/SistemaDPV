<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class SubCategoryController extends Controller
{
    //Insert de datos
    public function store(Request $request)
    {
        $this->validate($request, $this->rules(), $this->messages());

        $category = Category::find($request->category_id);
        if(!is_null(SubCategory::where('name',$request->name)->where('category_id',$category->id)->first()))
        {
            toastr()->warning("La sub categoría {$request->name} ya se encuentra asignada a la categoría {$category->name}.");
            return redirect()->route('category.show', $category);
        }

        SubCategory::create($request->all());
        toastr()->success('Registro guardado.');

        return redirect()->route('category.show', $category);
    }

    //Vista de la pantalla para editar registro
    public function edit(SubCategory $sub_category)
    {
        $category = Category::find($sub_category->category_id);
        return view('system.sub_category.edit', compact('sub_category','category'));
    }

    //Update de datos
    public function update(Request $request, SubCategory $sub_category)
    {
        $this->validate($request, $this->rules($sub_category->id), $this->messages());

        $category = Category::find($sub_category->category_id);
        $sub_category->name = $request->name;

        if(!$sub_category->isDirty())
        {
            toastr()->info('El sistema no detecto cambios nuevos para guardar.');
            return redirect()->route('category.show', $category);
        }

        if(!is_null(SubCategory::where('name',$request->name)->where('category_id',$category->id)->first()))
        {
            toastr()->warning("La sub categoría {$request->name} ya se encuentra asignada a la categoría {$category->name}.");
            return redirect()->route('category.show', $category);
        }

        $sub_category->save();
        toastr()->success('Registro actualizado.');
        return redirect()->route('category.show', $category);
    }

    //Delete de datos
    public function delete(SubCategory $sub_category)
    {
        try {
            $category = Category::find($sub_category->category_id);
            $sub_category->delete();
            toastr()->success('Registro eliminado.');
            return redirect()->route('category.show', $category);
        } catch (\Exception $e)
        {
            $category = Category::find($sub_category->category_id);
            if ($e instanceof QueryException) {
                toastr()->error("El sistema no puede eliminar el registro {$sub_category->name}, porque tiene información asociada.");
                return redirect()->route('category.show', $category);
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
                'name'=>'required|max:25',
                'category_id' => 'required|integer|exists:categories,id'
            ];
        }
        else
        {
            $validar = [
                'name'=>'required|max:25',
            ];
        }

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'name.required' => 'El nombre de la sub categoría es obligatorio.',
            'name.max'  => 'El nombre debe tener menos de :max caracteres.',
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.integer'  => 'La categoría debe de ser un número entero.',
            'category_id.exists'  => 'La categoría seleccionada no existe.'
        ];
    }
}
