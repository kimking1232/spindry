<?php

namespace App\Http\Controllers;

use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    public function register(request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:users,name',
                'email' => 'required|unique:users,email',
                'telephone' => 'required',
                'address' => 'required',
                'password' => 'required',
            ],
            [   
                'name.required' => 'username tidak boleh kosong!',
                'name.unique' => 'username telah terdaftar sebelumnya!',
                'password.required' => 'password tidak boleh kosong!',
                'email.required' => 'password tidak boleh kosong!',
                'email.unique' => 'password telah terdaftar sebelumnya!',
                'address.required' => 'password tidak boleh kosong!',
                'telephone.required' => 'password tidak boleh kosong!',
            ]
        );

        if($validator->fails())
        {
            return response()->json(
                [
                    'message'=>json_decode($validator->errors())
                ]
            );
        }

        user::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'telephone' => $request->telephone,
            'role' => 'users',
            'password' => Hash::make($request->password),
        ]);

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Berhasil registrasi',

            ]
        );
    }


    public function login(request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'password' => 'required',
            ],
            [   
                'name.required' => 'username tidak boleh kosong!',
                'password.required' => 'password tidak boleh kosong!',
            ]
        );

        if($validator->fails())
        {
            return response()->json(
                [
                    'message'=>json_decode($validator->errors())
                ]
            );
        }
        $credential = [
            'name' => $request->name,
            'password' => $request->password
        ];

        if(Auth::attempt($credential)){
            $user = User::where('name', $request->name)->first();
            $token = $user->createToken('authToken')->plainTextToken;
            $user->token = $token;
            $user->token_type = 'Bearer';
            $data = [
                'status' => 'success',
                'message'=> 'user berhasil login',
                'data' => $user,
            ];
            return response()->json($data);
        }else{
            $data = [
                'status' => 'success',
                'message'=> 'user gagal login',
                'data' => NULL,
            ];
            return response()->json($data);
        }
    }

    public function logout()
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user->tokens()->delete();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'berhasil keluar',
                'data' => Null,
            ]
        );
    }
}
