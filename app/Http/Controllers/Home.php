<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//import model suplier
use App\M_Suplier;

//import llibrary session
use Illuminate\Support\Facades\Session;

//import model pengadaan 
use App\M_Pengadaan;


class Home extends Controller
{
    //function index

    public function index(){
       // echo "fungsi index home";
        //panggil view di root folder view
        //return view('home');
        //panggil view di sub folder view (misal di folder utama)

        $key = env('APP_KEY');

        $token = Session::get('token');

        $tokenDb = M_Suplier::where('token', $token)->count();

        if ($tokenDb > 0){
            $data['token'] = $token;
        }else{
            $data['token'] = "kosong";
        }


        $data['pengadaan']= M_Pengadaan::where('status', '1')->paginate(15);

        return view('utama.home', $data);
    }

}
