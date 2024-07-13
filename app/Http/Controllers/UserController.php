<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

//*Models
use App\Models\User;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    public function getUsers(){
        try {
            $users = User::paginate(5);
            $message = 'success';

            if(empty($users)){
                $message = 'No hay usuarios';
            }

            return response()->json([
                'message' =>  $message,
                'status' => 200,
                'data' => $users
            ]);
        } catch (Throwable $e) {
            report($e);
            return false;
        }

    }


    public function getUser($id){
        try {
            $users = User::find($id);
            $message = 'success';

            if(empty($users)){
                $message = 'No hay usuarios';
            }

            return response()->json([
                'message' =>  $message,
                'status' => 200,
                'data' => $users
            ]);
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function createUser(Request $request){
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'ciudad' => 'required',
            'correo' => 'email|nullable',
            'telefono' => 'nullable'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' =>  'Datos invalidos por favor valide la informacion',
                'status' => 400,
                'errors' => $validator->errors()
            ]);
        }

        $user = User::create([
            "nombre" => $request->nombre,
            "ciudad" => $request->ciudad,
            "correo" => $request->correo,
            "telefono" => $request->telefono
        ]);

        return response()->json([
            'message' => 'success',
            'status' => 200,
            'data' => $user
        ]);
    }

    public function editUser(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nombre' => 'string|nullable',
            'ciudad' => 'string|nullable',
            'correo' => 'email|nullable',
            'telefono' => 'nullable'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' =>  'Datos invalidos por favor valide la informacion',
                'status' => 400,
                'errors' => $validator->errors()
            ]);
        }

        $user = User::find($id);

        if(empty($user)){
            return response()->json([
                'message' =>  'Usuario o informacion no valida',
                'status' => 400
            ]);
        }

        //*Validar si los campo nombre y ciudad estan en la data
        if(!empty($request->nombre)){
            $user->nombre = $request->nombre;
        }else{
            $user->nombre;
        }

        if(!empty($request->ciudad)){
            $user->ciudad = $request->ciudad;
        }else{
            $user->ciudad;
        }

        $user->correo = $request->correo;
        $user->telefono = $request->telefono;
        $user->save();

        return response()->json([
            'message' => 'success',
            'status' => 200,
            'data' => $user
        ]);

    }

    public function deleteUser($id){

        $user = User::find($id);
        $user->delete();

        return response()->json([
            'message' => 'success',
            'status' => 200,
        ]);
    }
}
