<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//import library validasi (karena validasinya akan digunakan di coding bawah, untuk validasi isian di view registrasi.blade.php)
use illuminate\Support\Facades\Validator;


//import fungsi encrypt, karena di bawah ada script enkripsi password (tulisan warna biru)
use illuminate\Contracts\Encryption\DecryptException;

//import llibrary session
use Illuminate\Support\Facades\Session;

//import model suplier
use App\M_Suplier;

class Registrasi extends Controller
{
    //
    public function index(){

// $key = env('APP_KEY');

        $token = Session::get('token');

        $tokenDb = M_Suplier::where('token', $token)->count();

        if ($tokenDb > 0){
            $data['token'] = $token;
        }else{
            $data['token'] = "kosong";
        }

        return view('registrasi.registrasi',$data);
    }

    public function regis(Request $request){
        $this->validate($request,
            [
                'nama_usaha' =>'required',
                'email' =>'required',
                'alamat' =>'required',
                'npwp'  =>'required',
                'password' =>'required'
            ]
        );

    if(M_Suplier::create(
        [
            'nama_usaha' =>$request->nama_usaha,
            'email' =>$request->email,
            'alamat' =>$request->alamat,
            'no_npwp' =>$request->npwp,
            'password' =>encrypt($request->password)

        ]
    )){
        return redirect('/registrasi')->with('berhasil', 'Data berhasil disimpan');

    }else{
        return redirect('/registrasi')->with('gagal', 'Data gagal disimpan');
    }

    }
}
