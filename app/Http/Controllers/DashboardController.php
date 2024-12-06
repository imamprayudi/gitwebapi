<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->session());
        // Mengirim request ke API dengan method getMonthlyPoc
        $getMonthlyPoc = Http::get(env('EXTERNAL_API_URL') . '/dashboard.php',
            [
                'method' => 'getMonthlyPoc',
                'usr' => $request->session()->get('usr'),
            ]);
        // $getMonthlyPoc = Http::get(env('EXTERNAL_API_URL') . '/dashboard.php',
        //     [
        //         'method' => 'getMonthlyPoc'
        //     ]
        // );
        // dd($getMonthlyPoc);
        // Cek apakah status HTTP 200 (berhasil)
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
