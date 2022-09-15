<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyAddress;
use App\CompanyPhone;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    ///Vista de la pantalla de todos los registros
    public function index_pagina()
    {
        $web = Company::with('phones', 'addresses')->where('current', true)->first();
        return view('system.company.index_pagina', compact('web'));
    }

    ///Vista de la pantalla de todos los registros
    public function index_sistema()
    {
        $web = Company::with('phones', 'addresses')->where('system', true)->first();
        return view('system.company.index_sistema', compact('web'));
    }

    //Insert de datos
    public function store(Request $request)
    {
        $this->validate($request, $this->rules(), $this->messages());

        $data = $request->all();
        if (!empty($request->logotipo)) {
            $img_data = file_get_contents($request->file('logotipo'));
            $base64 = base64_encode($img_data);
            $data['logotipo'] = $base64;
        }
        $data['current'] = false;
        $data['system'] = true;

        Company::create($data);
        toastr()->success('Registro guardado.');
        return redirect()->route('company.index_sistema');
    }

    //Update de datos
    public function update(Request $request, Company $company)
    {
        if (is_null($request->logotipo))
            $this->validate($request, $this->rules(1), $this->messages());
        else
            $this->validate($request, $this->rules(), $this->messages());

        $company->nit = $request->nit;
        $company->name = $request->name;
        $company->slogan = $request->slogan;
        $company->vision = $request->vision;
        $company->mision = $request->mision;
        $company->ubication_x = $request->ubication_x;
        $company->ubication_y = $request->ubication_y;
        $company->facebook = $request->facebook;
        $company->twitter = $request->twitter;
        $company->instagram = $request->instagram;
        $company->page = $request->page;

        if (!empty($request->logotipo)) {
            if ($request->logotipo != $company->logotipo) {
                $img_data = file_get_contents($request->file('logotipo'));
                $base64 = base64_encode($img_data);
                $company->logotipo = $base64;
            }
        }

        if (!$company->isDirty()) {
            toastr()->info('El sistema no detecto cambios nuevos para guardar.');
            return redirect()->route("company.{$request->redireccionar}");
        }

        $company->save();
        toastr()->success('Registro actualizado.');
        return redirect()->route("company.{$request->redireccionar}");
    }

    //Insert de datos telefono
    public function phone_store(Request $request, Company $company)
    {
        $rules = [
            'redireccionar' => 'required|starts_with:index_pagina,index_sistema',
            'phone' => 'required|integer|digits:8'
        ];

        $messages = [
            'redireccionar.required' => 'El parámetro de redireccionamiento es obligatorio.',
            'redireccionar.starts_with' => 'El parámetro de redireccionamiento solo pueder ser index_pagina o index_sistema.',

            'phone.required' => 'El número de teléfono es obligatorio.',
            'phone.digits' => 'El número de teléfono debe contener :digits dígitos.',
            'phone.integer' => 'El número de teléfono debe de ser números enteros.',
        ];

        $this->validate($request, $rules, $messages);

        $nuevo_telefono = new CompanyPhone();
        $nuevo_telefono->phone = $request->phone;
        $nuevo_telefono->company_id = $company->id;
        $nuevo_telefono->save();

        $company->updated_at = $nuevo_telefono->updated_at;
        $company->save();

        toastr()->success("Número de teléfono {$nuevo_telefono->phone} agregado.");
        return redirect()->route("company.{$request->redireccionar}");
    }

    //Insert de datos direccion
    public function direction_store(Request $request, Company $company)
    {
        $rules = [
            'redireccionar' => 'required|starts_with:index_pagina,index_sistema',
            'direction' => 'required|max:200'
        ];

        $messages = [
            'redireccionar.required' => 'El parámetro de redireccionamiento es obligatorio.',
            'redireccionar.starts_with' => 'El parámetro de redireccionamiento solo pueder ser index_pagina o index_sistema.',

            'direction.required' => 'La dirección es obligatorio.',
            'direction.max'  => 'La dirección debe tener menos de :max caracteres.'
        ];

        $this->validate($request, $rules, $messages);

        $nueva_direccion = new CompanyAddress();
        $nueva_direccion->direction = $request->direction;
        $nueva_direccion->company_id = $company->id;
        $nueva_direccion->save();

        $company->updated_at = $nueva_direccion->updated_at;
        $company->save();

        toastr()->success("Dirección {$nueva_direccion->direction} agregada.");
        return redirect()->route("company.{$request->redireccionar}");
    }

    //Delete de datos telefono
    public function phone_delete(CompanyPhone $phone)
    {
        $phone->delete();
        toastr()->success("El número de teléfono {$phone->phone} fue eliminado.");
        return redirect()->back();
    }

    //Delete de datos direccion
    public function direction_delete(CompanyAddress $direction)
    {
        $direction->delete();
        toastr()->success("La dirección {$direction->direction} fue eliminada.");
        return redirect()->back();
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        if (is_null($id)) {
            return [
                'redireccionar' => 'required|starts_with:index_pagina,index_sistema',
                'nit' => 'required|max:10|unique:business,nit',
                'name' => 'required|max:50',
                'slogan' => 'required|max:5',
                'vision' => 'required|max:1000',
                'mision' => 'required|max:1000',
                'logotipo' => 'required|file',
                'ubication_x' => 'required|numeric',
                'ubication_y' => 'required|numeric',
                'facebook' => 'required|url|max:100',
                'twitter' => 'required|url|max:100',
                'instagram' => 'required|url|max:100',
                'page' => 'required|url|max:100',
            ];
        } else {
            return [
                'redireccionar' => 'required|starts_with:index_pagina,index_sistema',
                'nit' => 'required|max:10|unique:business,nit,' . $id,
                'name' => 'required|max:50',
                'slogan' => 'required|max:5',
                'vision' => 'required|max:1000',
                'mision' => 'required|max:1000',
                'ubication_x' => 'required|numeric',
                'ubication_y' => 'required|numeric',
                'facebook' => 'required|url|max:100',
                'twitter' => 'required|url|max:100',
                'instagram' => 'required|url|max:100',
                'page' => 'required|url|max:100',
            ];
        }
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'redireccionar.required' => 'El parámetro de redireccionamiento es obligatorio.',
            'redireccionar.starts_with' => 'El parámetro de redireccionamiento solo pueder ser index_pagina o index_sistema.',

            'nit.required' => 'El nit es obligatorio.',
            'nit.max'  => 'El nit debe tener menos de :max caracteres.',
            'nit.unique'  => 'El nit ingresado ya existe en registrado en el sistema.',

            'name.required' => 'El nombre de la empresa es obligatorio.',
            'name.max'  => 'El nombre de la empresa debe tener menos de :max caracteres.',

            'slogan.required' => 'El slogan es obligatorio.',
            'slogan.max'  => 'El slogan debe tener menos de :max caracteres.',

            'vision.required' => 'La visión de la empresa es obligatorio.',
            'vision.max'  => 'La visión de la empresa debe tener menos de :max caracteres.',

            'mision.required' => 'La misión de la empresa es obligatorio.',
            'mision.max'  => 'La misión de la empresa debe tener menos de :max caracteres.',

            'logotipo.required' => 'El logotipo de la empresa es obligatorio.',
            'logotipo.file'  => 'El logotipo de la empresa debe de ser imagen.',

            'ubication_x.required' => 'La longitud es obligatoria.',
            'ubication_x.numeric'  => 'La longitud solo debe contener números.',

            'ubication_y.required' => 'La latitud es obligatoria.',
            'ubication_y.numeric'  => 'La latitud solo debe contener números.',

            'facebook.required' => 'La URL de facebook es obligatorio.',
            'facebook.url' => 'La URL de facebook no es válida.',
            'facebook.max'  => 'La URL de facebook debe tener menos de :max caracteres.',

            'twitter.required' => 'La URL de twitter es obligatorio.',
            'twitter.url' => 'La URL de twitter no es válida.',
            'twitter.max'  => 'La URL de twitter debe tener menos de :max caracteres.',

            'instagram.required' => 'La URL de instagram es obligatorio.',
            'instagram.url' => 'La URL de instagram no es válida.',
            'instagram.max'  => 'La URL de instagram debe tener menos de :max caracteres.',

            'page.required' => 'La URL de página es obligatorio.',
            'page.url' => 'La URL de página no es válida.',
            'page.max'  => 'La URL de página debe tener menos de :max caracteres.',
        ];
    }
}
