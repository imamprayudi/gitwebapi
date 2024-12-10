<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;


class PoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->session()->get('usr') == null)
        {
            return redirect('/');
        }
        
        $getSupplier = Http::get(env('EXTERNAL_API_URL') . '/jpo.php',
        [
            'method' => 'getSupplierGroup',
            'usr' => $request->session()->get('usr')
        ]);

        // dd($getSupplier);
         $Suppliers=[];
         if ($getSupplier->successful()) {
            // Mengambil data JSON jika berhasil
            $Suppliers = $getSupplier->json();
            // dd($Suppliers);  // Debug respons
        } else {
            // Jika gagal, tampilkan error atau status
            dd('Request failed with status: ' . $getSupplier->status());
        }
        
        return view('pages.orders.po', compact('Suppliers'));
    }

    public function getFilterBy(Request $request)
    {
        $getFilterBy = Http::get(env('EXTERNAL_API_URL') . '/jpo.php',
        [
            'method' => 'getFilterBy',
            'usr' => $request->session()->get('usr')
        ]);
       
        // dd($getFilterBy);
         $FilterBy=[];
         if ($getFilterBy->successful()) {
            // Mengambil data JSON jika berhasil
            $FilterBy = $getFilterBy->json();
            // dd($FilterBy);  // Debug respons
        } else {
            // Jika gagal, tampilkan error atau status
            dd('Request failed with status: ' . $getFilterBy->status());
        }

        return $FilterBy;
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
        //
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
