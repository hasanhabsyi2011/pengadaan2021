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

//import storage
use Illuminate\Support\Facades\Storage;


use App\M_Admin;
use App\M_Pengadaan;

use App\M_Suplier;

class Pengadaan extends Controller
{
    //
    public function index(){
        $token = Session::get('token');

        $tokenDb = M_Admin::where('token',$token)->count();

        if($tokenDb > 0){
            $data['adm'] = M_Admin::where('token',$token)->first();

            $data['pengadaan'] = M_Pengadaan::where('status','1')->paginate(15);


        return view('pengadaan.list', $data);
        }else{
            return redirect('/masukAdmin')->with('gagal','Anda sudah logout, silakan login kembali');
        }
    }

    public function tambahPengadaan(Request $request){

        $token = Session::get('token');

        $tokenDb = M_Admin::where('token', $token)->count();

        if ($tokenDb > 0) {
            
            $this->validate($request,
            [                
                'nama_pengadaan' => 'required',                
                'deskripsi' => 'required',
                'gambar' => 'required|image|mimes:jpg,png,jpeg|max:10000',
                'anggaran' => 'required' 

            ]
        );

            $path = $request->file('gambar')->store('public/gambar');
            if(M_Pengadaan::create(

                [
                    "nama_pengadaan" => $request->nama_pengadaan,
                    "deskripsi" => $request->deskripsi,
                    "gambar" => $path,
                    "anggaran" => $request->anggaran,
                ])){
                return redirect('/listPengadaan')->with('berhasil','data berhasil disimpan');

            }else{
                return redirect('/listPengadaan')->with('gagal','data gagal disimpan');

            }

        }else{
            return redirect('/masukAdmin')->with('gagal','Anda sudah logout, silakan login kembali');
        }
    }

    public function hapusGambar($id)
    {
        $token = Session::get('token');

        $tokenDb = M_Admin::where('token',$token)->count();

        if($tokenDb > 0){
            $pengadaan = M_Pengadaan::where('id_pengadaan',$id)->count();

            if($pengadaan > 0){

                $dataPengadaan = M_Pengadaan::where('id_pengadaan',$id)->first();

                if(Storage::delete($dataPengadaan->gambar)){
                    if(M_pengadaan::where('id_pengadaan',$id)->update(["gambar" => "-"])){
                        return redirect('/listPengadaan')->with('berhasil','gambar berhasil dihapus');

                    }else{
                        return redirect('/listPengadaan')->with('gagal','gambar gagal dihapus');
                    }

                }else{

                    return redirect('/listPengadaan')->with('gagal','gambar gagal dihapus');

                }

            }else{
                return redirect('/listPengadaan')->with('gagal','Data tidak ditemukan');

            }

        }else{
            return redirect('/masukAdmin')->with('gagal','Anda sudah logout, silakan login kembali');   
        }
    }



    public function uploadGambar(Request $request){

        $token = Session::get('token');

        $tokenDb = M_Admin::where('token', $token)->count();

        if ($tokenDb > 0) {
            
            $this->validate($request,
            [                
                'gambar' => 'required|image|mimes:jpg,png,jpeg|max:10000',
                
            ]
        );

            $path = $request->file('gambar')->store('public/gambar');
            if(M_Pengadaan::where('id_pengadaan', $request->id_pengadaan)->update(

                [
                    "gambar" => $path,
                ])){
                return redirect('/listPengadaan')->with('berhasil','data berhasil disimpan');

            }else{
                return redirect('/listPengadaan')->with('gagal','data gagal disimpan');

            }

        }else{
            return redirect('/masukAdmin')->with('gagal','Anda sudah logout, silakan login kembali');
        }
    }


    public function ubahGambar(Request $request){

        $token = Session::get('token');

        $tokenDb = M_Admin::where('token', $token)->count();

        if ($tokenDb > 0) {
            
            $this->validate($request,
            [                
                'u_nama_pengadaan' => 'required',                
                'u_deskripsi' => 'required',                
                'u_anggaran' => 'required'
                
            ]
        );

            if(M_Pengadaan::where('id_pengadaan', $request->id_pengadaan)->update(

                [
                    "nama_pengadaan" => $request->u_nama_pengadaan,
                    "deskripsi" => $request->u_deskripsi,
                    "anggaran" => $request->u_anggaran,
                ])){
                return redirect('/listPengadaan')->with('berhasil','data berhasil disimpan');

            }else{
                return redirect('/listPengadaan')->with('gagal','data gagal disimpan');

            }

        }else{
            return redirect('/masukAdmin')->with('gagal','Anda sudah logout, silakan login kembali');
        }
    }


  public function ubahPengadaan(Request $request){

        $token = Session::get('token');

        $tokenDb = M_Admin::where('token', $token)->count();

        if ($tokenDb > 0) {
            
            $this->validate($request,
            [                
                'u_nama_pengadaan' => 'required',                
                'u_deskripsi' => 'required',
                'u_anggaran' => 'required'
                
            ]
        );

            
            if(M_Pengadaan::where('id_pengadaan', $request->id_pengadaan)->update(

                [
                    "nama_pengadaan" => $request->u_nama_pengadaan,
                    "deskripsi" => $request->u_deskripsi,
                    "anggaran" => $request->u_anggaran
                ])){
                return redirect('/listPengadaan')->with('berhasil','data berhasil disimpan');

            }else{
                return redirect('/listPengadaan')->with('gagal','data gagal disimpan');

            }

        }else{
            return redirect('/masukAdmin')->with('gagal','Anda sudah logout, silakan login kembali');
        }
    }  



    public function hapusPengadaan($id)
    {
        $token = Session::get('token');

        $tokenDb = M_Admin::where('token',$token)->count();

        if($tokenDb > 0){
            $pengadaan = M_Pengadaan::where('id_pengadaan',$id)->count();

            if($pengadaan > 0){

                $dataPengadaan = M_Pengadaan::where('id_pengadaan',$id)->first();

                if(Storage::delete($dataPengadaan->gambar)){
                    if(M_pengadaan::where('id_pengadaan',$id)->delete()){
                        return redirect('/listPengadaan')->with('berhasil','data berhasil dihapus');

                    }else{
                        return redirect('/listPengadaan')->with('gagal','data gagal dihapus');
                    }

                }else{

                    return redirect('/listPengadaan')->with('gagal','data gagal dihapus');

                }

            }else{
                return redirect('/listPengadaan')->with('gagal','Data tidak ditemukan');

            }

        }else{
            return redirect('/masukAdmin')->with('gagal','Anda sudah logout, silakan login kembali');   
        }
    }


//
    public function listSuplier(){
        $token = Session::get('token');

        $tokenDb = M_Suplier::where('token',$token)->count();

        if($tokenDb > 0){

            $data['sup'] = M_Suplier::where('token',$token)->first();

            $data['pengadaan'] = M_Pengadaan::where('status','1')->paginate(15);


        return view('suplier.pengadaan', $data);
        }else{
            return redirect('/masukSuplier')->with('gagal','Password Anda Salah');
        }
    }


}
