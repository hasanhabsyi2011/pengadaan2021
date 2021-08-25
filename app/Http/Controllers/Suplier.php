<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//import llibrary session
use Illuminate\Support\Facades\Session;


//import library JWT
use \Firebase\JWT\JWT;

//import library Response
use Illuminate\Response;

//import library validasi
use illuminate\Support\Facades\Validator;

//import fungsi encrypt, karena di bawah ada script enkripsi password (tulisan warna biru)
use illuminate\Contracts\Encryption\DecryptException;

//import model suplier
use App\M_Suplier;

//import model Admin
use App\M_Admin;

class Suplier extends Controller
{
    //

    public function login(){
        return view('login_sup.login');
    }

    public function masukSuplier(Request $request){
        $this->validate($request,
            [                
                'email' =>'required',                
                'password' =>'required'
            ]
        );

        $cek = M_Suplier::where('email',$request->email)->count();

        // echo $cek;

        $sup = M_Suplier::where('email',$request->email)->get();

        if($cek > 0){
            //email terdaftar
            foreach($sup as $su){
                if(decrypt($su->password) == $request->password){
                    //jika password benar

                    $key = env('APP_KEY');
                    // echo $key;

                    $data = array(
                        "id_suplier" => $su->id_suplier
                    );

                  
                    $jwt = JWT::encode($data, $key);

                    if(M_Suplier::where('id_suplier', $su->id_suplier)->update(
                        [
                            'token' => $jwt
                        ]

                    )){

                        //kalau berhasil udate token di database

                        Session::put('token', $jwt);

                        return redirect('/listSuplier');
                    
                    }else{
                        return redirect('/login')->with('gagal','Token gagal diupdate');

                    }

                    

                }else{
                    //jika password salah
                    return redirect('/login')->with('gagal','Password Tidak Sama');        
                }
            }

        }else{
            return redirect('/login')->with('gagal','Email tidak terdaftar');

        }
    }


    public function suplierKeluar(){
        $token = Session::get('token');
        if(M_Suplier::where('token',$token)->update(
            [
                'token' => 'keluar',
            ]
        )){
            Session::put('token',"");
            return redirect('/');            
        }else{
            return redirect('/masukSuplier')->with('gagal','Anda gagal logout');

        }
    }

    public function listSup(){
        $token = Session::get('token');

        $tokenDb = M_Admin::where('token',$token)->count();

        if($tokenDb > 0){
            $data['adm'] = M_Admin::where('token',$token)->first();
            $data['suplier'] = M_Suplier::paginate(15);
            // print_r($data);

            return view('admin.listSup',$data);
        }else{
            return redirect('/masukAdmin')->with('gagal','Anda sudah logout, silakan login kembali');
        }
    }

    public function nonAktif($id){
       
        $token = Session::get('token');

        $tokenDb = M_Admin::where('token',$token)->count();

        if($tokenDb > 0){
            if(M_Suplier::where('id_suplier', $id)->update(
                [
                    "status" => "0"
                ])){
                return redirect('/listSup')->with('berhasil','Data Berhasil Diupdate');
            }else{
                return redirect('/listSup')->with('gagal','Data Gagal Diupdate');
            }
        }else{
            return redirect('/masukAdmin')->with('gagal','Anda sudah logout, silakan login kembali');
        } 
    }

    public function Aktif($id){
       
        $token = Session::get('token');

        $tokenDb = M_Admin::where('token',$token)->count();

        if($tokenDb > 0){
            if(M_Suplier::where('id_suplier', $id)->update(
                [
                    "status" => "1"
                ])){
                return redirect('/listSup')->with('berhasil','Data Berhasil Diupdate');
            }else{
                return redirect('/listSup')->with('gagal','Data Gagal Diupdate');
            }
        }else{
            return redirect('/masukAdmin')->with('gagal','Anda sudah logout, silakan login kembali');
        } 
    }

    public function ubahPassword(Request $request){
        $token = Session::get('token');
        $tokenDb = M_Suplier::where('token',$token)->count();

        if($tokenDb > 0){
            $key = env('APP_KEY');

            $sup = M_Suplier::where('token',$token)->first();

            $decode = JWT::decode($token, $key, array('HS256'));
            $decode_array = (array) $decode;

            if(decrypt($sup->password) == $request->passwordLama){

                if(M_Suplier::where('id_suplier', $decode_array['id_suplier'])->update(
                [
                    "password" => encrypt($request->password)
                ])){
                return redirect('/login')->with('gagal','Password Berhasil Diupdate');
            }else{
                return redirect('/listSuplier')->with('gagal','Data Gagal Diupdate');
            }

        }else{
            return redirect('/listSuplier')->with('gagal','Password gagal Diupdate, password lama tidak sama');
        }

            
        }else{
            return redirect('/masukSuplier')->with('gagal','Anda sudah logout, silakan login kembali');
        }
    }

}
