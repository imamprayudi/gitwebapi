<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
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
        // Mengambil data dari API
        // try {
            $getMonthlyPoc = Http::get(env('EXTERNAL_API_URL') . '/dashboard.php',
            [
                'method' => 'getMonthlyPoc',
                'usr' => $request->session()->get('usr'),
            ]);
        // } catch (ConnectionException $e) {
        //     Log::error($e->getMessage());
        // }
        
        // dd($getMonthlyPoc->json());
        // Cek apakah status HTTP 200 (berhasil)
        $monthlyPOC=null;
        if ($getMonthlyPoc->successful()) {
            // Mengambil data JSON jika berhasil
            $monthlyPOC = $getMonthlyPoc->json();
            // dd($monthlyPOC);  // Debug respons
        } else {
            // Jika gagal, tampilkan error atau status
            dd('Request failed with status: ' . $getMonthlyPoc->status());
        }

        return view('dashboard.index', compact('monthlyPOC'));
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
