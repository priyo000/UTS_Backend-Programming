<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasienController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //function index digunakan untuk menampilkan semua data
    public function index()
    {
        //membuat array untuk menampung data
        $value = [];

        //mendapatkan seluruh data pasien
        $data = Pasien::all();

        //getall data pasien
        foreach ($data as $data){
            //variabel status untuk mengambil nama status
            $status = app('App\Http\Controllers\StatusController')->getIdStatus($data->status_id);
            $pasien_data = [
                "id" => $data->id,
                "nama_pasien" => $data->nama_pasien,
                "no_hp" => $data->no_hp,
                "alamat" => $data->alamat,
                "status" => $status->original,
                "tgl_masuk" => $data->tgl_masuk,
                "tgl_keluar" => $data->tgl_keluar
            ];

            //menambahkan data kedalam array yg telah dibuat
            array_push($value, $pasien_data);
        };

        if(isset($data)){
            $hasil = [
                "message" => "Get All Resource",
                "data" => $value
            ];
            return response()->json($hasil, 200);
        }

        else {
            $hasil = [
                "message" => "Data is Empty",
            ];
            return response()->json($hasil, 200);
        }
        
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //function store digunakan untuk membuat/menambahkan data baru
    public function store(Request $request)
    {
        //validasi input
        $validasi_data = [
            'nama_pasien' => 'required',
            'no_hp' => 'required|numeric',
            'alamat' => 'required',
            'status_id' => 'required',
        ];

        //melakukan validasi
        $validation = Validator::make($request->all(), $validasi_data);
        if($validation->fails()){
            $error = [
                'message' => "Your resource incorrect, please check!"
            ];

            return response()->json($error, 404);
        }

        else {
            $pasien_data = Pasien::create([
                'nama_pasien' => $request->nama_pasien,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'status_id' => $request->status_id,
                'tgl_masuk' => $request->tgl_masuk
            ]);
            $success = [
                'message' => "Resource added successfully",
                'data' => $pasien_data
            ];
            return response()->json($success, 200);
        }

    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pasien  $pasien
     * @return \Illuminate\Http\Response
     */

    //function show digunakan untuk mendapatkan nilai spesifik
    public function show($id)
    {
        //mencari sebuah data yang sesuai dengan id
        $data = Pasien::find($id);
        if(isset($data)){
            $success = [
                "message" => "Get Detail Resource",
                "data" => $data
            ];
            return response()->json($success, 200);
        }

        else {
            $error = [
                "message" => "Resource not found"
            ];
            return response()->json($error, 404);
        }
        
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pasien  $pasien
     * @return \Illuminate\Http\Response
     */

    //function update digunakan untuk melakukan update/edit data
    public function update(Request $request, $id)
    {
            $pasien = Pasien::find($id);

        if ($pasien) {
            if ($request->status) {
                $status = $request->status;

                $request['status_id'] = $this->getStatusId($status);
            }

            $pasien->update([
            'nama_pasien' => $request->nama_pasien,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'status_id' => $request->status_id,
            'tgl_masuk' => $request->tgl_masuk,
            'tgl_keluar' => $request->tgl_keluar
        ]);

            $success = [
                'message' => "Resource update is successfully",
                'data' => $pasien
            ];
            return response()->json($success, 200);
        } else {

            $messages = [
                'message' => 'resource not found'
            ];
            return response()->json($messages, 404);
        }
    // }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pasien  $pasien
     * @return \Illuminate\Http\Response
     */

    //function destroy digunakan untuk menghapus data
    public function destroy($id)
    {
        //mencari data yang akan di hapus
        $data = Pasien::find($id);

        //melakukan seleksi kondisi
        if(isset($data)){

            //menghapus data
            $data->delete();
            $success = [
                'message' => "Resource delete is successfully"
            ];

            return response()->json($success, 200);
        }

        else {
            $error = [
                'message' => "Resource not found"
            ];

            return response()->json($error, 200);
        }
    }



    //merupakan function untuk mendapatkan nilai berdasarkan nama
    public function searchByName($request){
        if(isset($request)){

            //query build database untuk menemukan data sesuai inputan
            $filterData = Pasien::query()
            ->where('nama_pasien', 'LIKE', "%{$request}%") 
            ->get();

            $message = [
                "message" => "Get Searched Resource",
                "data" => $filterData
            ];
            return response()->json($message, 200);
        }

        else {
            $message = [
                "message" => "Resource Not Found",
            ];
            return response()->json($message, 404);
        }
        
    }


    //merupakan function untuk mendapatkan data positif covid
    public function searchByPositive(){
        $filterData = Pasien::query()
            ->where('status_id', '=', 2) 
            ->get();
            if(isset($filterData)){
                $message = [
                    "message" => "Get Positive Resource",
                    "data" => $filterData
                ];
                return response()->json($message, 200);
            }

            else {
                $message = [
                    "message" => "Resource not found",
                    "data" => $filterData
                ];
                return response()->json($message, 404);
            }
            
        
    }



    //merupakan function untuk mendapatkan data covid yang recovery
    public function searchByRecovered(){

        $filterData = Pasien::query()
            ->where('status_id', '=', 1) 
            ->get();
            if(isset($filterData)){
                $message = [
                    "message" => "Get Recovered Resource",
                    "data" => $filterData
                ];
                return response()->json($message, 200);
            }

            else {
                $message = [
                    "message" => "Resource not found",
                    "data" => $filterData
                ];
                return response()->json($message, 404);
            }
        
    }


    //merupakan function untuk mendapatkan data kematian akibat covid
    public function searchByDead(){

        $filterData = Pasien::query()
            ->where('status_id', '=', 3) 
            ->get();
            if(isset($filterData)){
                $message = [
                    "message" => "Get Death Resource",
                    "data" => $filterData
                ];
                return response()->json($message, 200);
            }

            else {
                $message = [
                    "message" => "Resource not found",
                    "data" => $filterData
                ];
                return response()->json($message, 404);
            }
        
    }
}
