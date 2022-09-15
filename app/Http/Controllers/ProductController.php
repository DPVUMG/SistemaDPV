<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Image;
use App\Product;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    ///Vista de la pantalla de todos los registros
    public function index(Request $request)
    {
        $brands = Brand::orderBy('name','asc')->get();
        $categories = SubCategory::orderBy('name','asc')->get();

        if($request->has('search'))
            $items = Product::search($request->search)->orderBy('title','asc')->paginate(10);
        else
            $items = Product::orderBy('title','asc')->paginate(10);

        return view('system.product.index', compact('items','brands','categories'));
    }

    //Insert de datos
    public function store(Request $request)
    {
        $this->validate($request, $this->rules(), $this->messages());

        $brand = Brand::find($request->brand_id);
        $category = SubCategory::find($request->sub_category_id);
        if(!is_null(Product::where('title',$request->title)->where('brand_id',$brand->id)->where('sub_category_id',$category->id)->first()))
        {
            toastr()->warning("Le producto {$request->title} ya se encuentra asignada a la categoría {$category->getCategoryAttribute()}.");
            return redirect()->route('product.index');
        }

        $data = $request->all();

        $request->discount > 0 ? $data['offer'] = true : $data['offer'] = false;
        $data['current'] = true;
        $data['new_product'] = true;

        $product = Product::create($request->all());
        toastr()->success("Producto {$product->title} guardado.");

        return redirect()->route('product.index');
    }

    //Vista de la pantalla para editar registro
    public function edit(Product $product)
    {
        $brands = Brand::orderBy('name','asc')->get();
        $categories = SubCategory::orderBy('name','asc')->get();

        return view('system.product.edit', compact('product','brands','categories'));
    }

    //Update de datos
    public function update(Request $request, Product $product)
    {
        $this->validate($request, $this->rules(), $this->messages());

        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->stock = $request->stock;
        $product->brand_id = $request->brand_id;
        $product->sub_category_id = $request->sub_category_id;

        $product->discount > 0 ? $product->offer = 1 : $product->offer = 0;

        if(!$product->isDirty())
        {
            toastr()->info('El sistema no detecto cambios nuevos para guardar.');
            return redirect()->route('product.index');
        }

        $product->save();
        toastr()->success("Producto {$product->title} actualizado.");
        return redirect()->route('product.index');
    }

    //Delete de datos
    public function delete(Product $product)
    {
        try {
            $product->delete();
            toastr()->success("Producto {$product->title} eliminado.");
            return redirect()->route('product.index');
        } catch (\Exception $e)
        {
            if ($e instanceof QueryException) {
                $product->current ? $product->current = false : $product->current = true;
                $product->save();

                if($product->current)
                    toastr()->info("Producto {$product->title} fue dado de alta (activo).");
                else
                    toastr()->error("Producto {$product->title} fue dado de baja (inactivo).");

                return redirect()->route('product.index');
            }
        }
    }

    //Vista de la pantalla del producto seleccionado
    public function show(Product $product)
    {
        $images = Image::where('product_id',$product->id)->orderBy('id','desc')->paginate(12);
        return view('system.product.show',compact('product','images'));
    }

    //Accion para ofertar producto
    public function offer(Product $product)
    {
        if($product->discount > 0)
        {
            $product->offer ? $product->offer = false : $product->offer = true;
            $product->save();

            if($product->offer)
                toastr()->success("Producto {$product->title} ofertado.");
            else
                toastr()->error("Producto {$product->title} no ofertado.");

            return redirect()->route('product.index');
        }
        else
        {
            toastr()->warning("El producto {$product->title} que desea ofertar no tiene un descuento aplicado, por favor agregar uno.");
            return redirect()->route('product.edit', $product);
        }
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = array();

        if(is_null($id))
        {
            $validar = [
                'brand_id' => 'required|integer|exists:brands,id',
                'sub_category_id' => 'required|integer|exists:sub_categories,id',
                'title'=>'required|max:125',
                'price'=>'required|numeric|between:0,100000',
                'discount'=>'required|numeric|between:0,100',
                'stock'=>'required|integer|between:1,100000',
                'description'=>'required|max:200',
            ];
        }

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'brand_id.required' => 'La marca es obligatoria.',
            'brand_id.integer'  => 'La marca debe de ser un número entero.',
            'brand_id.exists'  => 'La marca seleccionada no existe.',

            'sub_category_id.required' => 'La categoría es obligatoria.',
            'sub_category_id.integer'  => 'La categoría debe de ser un número entero.',
            'sub_category_id.exists'  => 'La categoría seleccionada no existe.',

            'title.required' => 'El nombre del producto categoría es obligatorio.',
            'title.max'  => 'El nombre del producto debe tener menos de :max caracteres.',

            'price.required' => 'El precio del producto es obligatoria.',
            'price.numeric'  => 'El precio del producto debe de ser un número.',
            'price.between'  => 'El precio del producto debe ser un valor entre :min y :max.',

            'discount.required' => 'El descuento del producto es obligatoria.',
            'discount.numeric'  => 'El descuento del producto debe de ser un número.',
            'discount.between'  => 'El descuento del producto debe ser un valor entre :min y :max.',

            'stock.required' => 'El stock del producto es obligatoria.',
            'stock.integer'  => 'El stock del producto debe de ser un número entero.',
            'stock.between'  => 'El stock del producto debe ser un valor entre :min y :max.',

            'description.required' => 'La descripción del producto categoría es obligatorio.',
            'description.max'  => 'La descripción del producto debe tener menos de :max caracteres.',
        ];
    }
}
