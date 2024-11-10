<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Buku::orderBy('judul','asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data Ditemukan',
            'data' => $data
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBukuRequest $request)
    {
        $validate = $request->validated();
        $post = Buku::create($validate);
        if($post){
            return response()->json([
                        'status' => true,
                        'message' => 'Data Berhasil Disimpan',
                        'data' => $post
                    ],200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data Gagal Disimpan'
            ]);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Buku::find($id);

        if($data){
            return response()->json([
                'status' => true,
                'message' => 'Data Ditemukan',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak Ditemukan!'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBukuRequest $request, string $id)
    {
        $dataBuku = Buku::find($id);

        if(!$dataBuku)
        {
            return response()->json([
                'status' => false,
                'message' => 'Data Tidak Ditemukan'
            ]);
        }

        $validate = $request->validated();
        $post = $dataBuku->update($validate);

        if($post){
            return response()->json([
                        'status' => true,
                        'message' => 'Data Berhasil Diupdate',
                        'data' => $post
                    ],200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data Gagal Diupdate'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Buku::find($id);

        if(empty($data)){
            return response()->json([
                'status' => false,
                'message' => 'Data Tidak Ditemukan'
            ]);
        }

        $post = $data->delete();

        if($post){
            return response()->json([
                'status' => true,
                'message' => 'Data Berhasil Dihapus'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data Gagal Dihapus'
            ]);
        }
    }
}
