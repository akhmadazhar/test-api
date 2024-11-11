<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = new Client();
        $url = "http://127.0.0.1:8000/api/buku";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        // print_r($data);

        return view('buku.index',['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $judul = $request->judul;
        $pengarang = $request->pengarang;
        $tanggal_terbit = $request->tanggal_terbit;

        $parameter = [
            'judul' => $judul,
            'pengarang' => $pengarang,
            'tanggal_terbit' => $tanggal_terbit,
        ];


        $client = new Client();
        $url = "http://127.0.0.1:8000/api/buku";
        $response = $client->request('POST', $url,[
            'headers' =>
            [ 'Accept' => 'application/json',
                'Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);
        $statusCode = $response->getStatusCode();
echo "Status code: $statusCode"; // Print the status code

if ($statusCode != 200) {
    // Handle errors (e.g., 404, 500, etc.)
    echo "The API returned an error page, status code: $statusCode";
    return;
}
$headers = $response->getHeaders();
echo "Content-Type: " . $headers['Content-Type'][0];
        $content = $response->getBody()->getContents();
        if (strpos($content, '<html') !== false) {
    echo "The response is HTML, not JSON.";
    return;
}
        $contentArray = json_decode($content, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    // JSON decoding failed
    echo 'JSON decode error: ' . json_last_error_msg();
    return;
}

        if($contentArray['status']!=true){
            echo 'Ada Masalah';
        } else {
             echo 'SUKSES';
        }
        // if ($contentArray['status'] != true) {
        //     $error = $contentArray['data'];
        //     print_r($error);
        //     return redirect()->to('buku')->withErrors($error);
        // } else {
        //     return redirect()->to('buku')->with('success', 'Berhasil Menambahkan Data');
        // }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
