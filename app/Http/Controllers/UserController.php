<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function createRegister()
    {
        return view('pages.register');
    }

    public function storeRegister(Request $request)
    {
        // return $request;
        $request->validate(
        [
            'email' => 'required',
            'username' => 'required|min:5|max:30|unique:users,name',
            'telephone' => 'required|numeric',
            'address' => 'required|min:10|max:50',
            'role' => 'required',
            'password' => 'required|min:5|max:20',
            'confirm_password' => 'required|same:password'
        ],
        [
            'email.required' => 'Kolom Email Tidak Boleh Kosong!',
            'username.required' => 'Kolom UserName Tidak Boleh Kosong!',
            'username.min' => 'UserName Terlalu Pendek!',
            'username.max' => 'UserName Terlalu Panjang',
            'username.unique' => '',
            'telephone.required' => 'Kolom Telephone Tidak Boleh Kosong!',
            'telephone.numeric' => 'Kolom Telephone Harus Menggunakan Angka!',
            'address.required' => 'Kolom Alamat Tidak Boleh Kosong!',
            'address.min' => 'Kolom Alamat Terlalu Pendek!',
            'address.max' => 'Kolom Alamat Terlalu Panjang!',
            'role.required' => 'Role Harus Diisi!',
            'password.required' => 'Kolom Password Tidak Boleh Kosong!',
            'password.min' => 'Password Terlalu Pendek!',
            'password.max' => 'Password Terlalu Panjang!',
            'confirm_password.required' => 'Kolom Confirm Password Tidak Boleh Kosong!',
            'confirm_password.same' => 'Kolom Comfirm Password Harus Sama Dengan Password!',
        ]);

        User::create([
            'email' => $request->email,
            'name' => $request->username,
            'telephone' => $request->telephone,
            'address' => $request->address,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back();
    }

    public function login()
    {
        return view('pages.login');
    }

    public function prosesLogin(request $request)
    {
        //return $request
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required|min:5|max:20',
            ],
            [
                'email.required' => 'Kolom Email Tidak Boleh Kosong!',
                'password.required' => 'Kolom Password Tidak Boleh Kosong!',
                'password.min' => 'Password Terlalu Pendek!',
                'password.max' => 'Password Terlalu Panjang!',
            ]);

            $credential = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if(Auth::attempt($credential)){
                return redirect('/dashboard');
            }else{
                return redirect()->back()->with('gagal', 'Email atau Password tidak sesuai');
            }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
