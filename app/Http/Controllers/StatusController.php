<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    //mendapatkan id status yg diinginkan
    public function getIdStatus($idstatus)
    {
        $data = Status::find($idstatus);
        return response()->json($data, 200);
    }


    //menampilkan data
    public function index()
    {
        //mendapatkan semua data dari tabel statuses
        $data = Status::all();
        return response()->json($data, 200);
    }
}
