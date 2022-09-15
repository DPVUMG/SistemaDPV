<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    ///Vista de la pantalla de todos los registros
    public function index(Request $request)
    {
        if($request->has('search'))
            $items = User::search($request->search)->orderBy('name','asc')->paginate(12);
        else
            $items = User::orderBy('name','asc')->paginate(12);

        return view('system.user.index', compact('items'));
    }

    //Insert de datos
    public function store(Request $request)
    {
        $this->validate($request, $this->rules(), $this->messages());

        $data = $request->all();
        if(!empty($request->avatar))
        {
            $img_data = file_get_contents($request->file('avatar'));
            $base64 = base64_encode($img_data);
            $data['avatar'] = $base64;
        }

        $data['current'] = true;
        $data['system'] = true;
        $user = User::create($data);

        toastr()->success("El usuario {$user->name} fue creado.");
        return redirect()->route('user.index');
    }

    //Vista de la pantalla para editar registro
    public function edit(User $user)
    {
        return view('system.user.edit', compact('user'));
    }

    //Update de datos
    public function update(Request $request, User $user)
    {
        if(!$request->has('avatar'))
            $this->validate($request, $this->rules($user->id,$user->id), $this->messages());
        else
            $this->validate($request, $this->rules($user->id), $this->messages());

        if(!empty($request->avatar))
        {
            if($request->avatar != $user->avatar)
            {
                $img_data = file_get_contents($request->file('avatar'));
                $base64 = base64_encode($img_data);
                $user->avatar = $base64;
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->nickname = $request->nickname;

        if(!$user->isDirty())
        {
            toastr()->info('El sistema no detecto cambios nuevos para guardar.');
            return redirect()->route('user.index');
        }

        $user->save();
        toastr()->success("El usuario {$user->name} fue actualizado.");
        return redirect()->route('user.index');
    }

    //Delete de datos
    public function delete(User $user)
    {
        try {
            $user->delete();
            toastr()->success("Usuario {$user->name} eliminado.");
            return redirect()->route('user.index');
        } catch (\Exception $e)
        {
            if ($e instanceof QueryException) {
                $user->current ? $user->current = false : $user->current = true;
                $user->save();

                if($user->current)
                    toastr()->info("Usuario {$user->name} fue dado de alta (activo).");
                else
                    toastr()->error("Usuario {$user->name} fue dado de baja (inactivo).");

                return redirect()->route('user.index');
            }
        }
    }

    //Accion para darle acceso al sistema a un usuario existente
    public function system(User $user)
    {
        $user->system ? $user->system = false : $user->system = true;
        $user->save();

        if($user->system)
            toastr()->success("Usuario {$user->name} con acceso al sistema.");
        else
            toastr()->error("Usuario {$user->name} sin acceso al sistema.");

        return redirect()->route('user.index');
    }

    //Información del usuario
    public function perfil()
    {
        $user = Auth::user();

        $pedidos_count = Order::where('user_id', $user->id)->where('status', Order::PEDIDO)->count();
        $procesos_count = Order::where('user_id', $user->id)->where('status', Order::PROCESO)->count();
        $entregados_count = Order::where('user_id', $user->id)->where('status', Order::ENTREGADO)->count();
        $anulados_count = Order::where('user_id', $user->id)->where('status', Order::ANULADO)->count();

        return view('system.user.perfil', compact('user','pedidos_count','procesos_count','entregados_count','anulados_count'));
    }

    //Paasword reset
    public function password_reset(Request $request, User $user)
    {
        $rules = [
            'password' => 'required|min:6|confirmed|max:15',
            'password_confirmation' => 'required|min:6|max:15'
        ];

        $this->validate($request, $rules, $this->messages());

        $user->password = $request->password;
        $user->save();

        toastr()->success("Al usuario {$user->name} se le cambio la contraseña.");
        return redirect()->route('user.perfil');
    }

    //Reglas de validaciones
    public function rules($id = null, $foto = null)
    {
        if(is_null($id))
        {
            return [
                'name'=>'required|max:100',
                'nickname'=>'required|max:15',
                'email'=>'required|email|max:25|unique:users,email',
                'avatar'=>'required|file',
                'password' => 'required|min:6|confirmed|max:15',
                'password_confirmation' => 'required|min:6|max:15'
            ];
        }
        elseif(!is_null($id) && !is_null($foto))
        {
            return [
                'name'=>'required|max:100',
                'nickname'=>'required|max:15',
                'email'=>'required|email|max:25|unique:users,email',
            ];
        }
        else
        {
            return [
                'name'=>'required|max:100',
                'nickname'=>'required|max:15',
                'email'=>'required|email|max:25|unique:users,email,'.$id,
                'avatar'=>'required|file'
            ];
        }
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'name.required' => 'El nombre del usuario es obligatorio.',
            'name.max'  => 'El nombre del usuario debe tener menos de :max caracteres.',

            'nickname.required' => 'El alias del usuario es obligatorio.',
            'nickname.max'  => 'El alias del usuario debe tener menos de :max caracteres.',

            'email.required' => 'El correo electrónico del usuario es obligatorio.',
            'email.max'  => 'El correo electrónico del usuario debe tener menos de :max caracteres.',
            'email.email'  => 'El correo electrónico del usuario debe no es válido.',
            'email.unique'  => 'El correo electrónico ya se encuentra en uso por otro usuario.',

            'avatar.required' => 'El avatar del usuario es obligatorio.',
            'avatar.file'  => 'El avatar del usuario debe de ser imagen.',

            'password.required' => 'La contraseña del usuario es obligatorio.',
            'password.min'  => 'La contraseña debe de ser mayor a :min caracteres.',
            'password.confirmed'  => 'La contraseña no coincide con la confirmación.',
            'password.max'  => 'La contraseña del usuario debe tener menos de :max caracteres.',

            'password_confirmation.required' => 'La contraseña de confirmación es obligatorio.',
            'password_confirmation.min'  => 'La contraseña de confirmación debe de ser mayor a :min caracteres.',
            'password_confirmation.max'  => 'La contraseña de confirmación debe tener menos de :max caracteres.',
        ];
    }
}
