<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.user-pages.login.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'userid' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('userid', 'password');
        // return env('EXTERNAL_API_URL');
                
        $response = Http::post(env('EXTERNAL_API_URL') . '/login.php',$request->toArray());

        // $response = Http::get('https://api.example.com/data');

        if ($response->successful()) {
            // Permintaan berhasil
            $data = $response->json();
            // dd($data);
            $this->createSession($data);
            return view('dashboard.index');
            // dd($data); // Debug data
        } elseif ($response->failed()) {
            // Permintaan gagal
            $status = $response->status();
            dd("Request failed with status: $status");
        } else {
            // Tambahan jika ada kondisi lain
            dd('Unexpected response');
        }

        if($data->success)
        {
            return response()->json([
            'access_token' => $token->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->expires_at)->toDateTimeString(),
            'user' => $user->load(['mother.children', 'role', 'staff'])
        ]);
        }
        // if (!Auth::attempt($credentials)) {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }
        // return $credentials;
        // $user = $request->user();
        // $token = $user->createToken('Personal Access Token');
        // $tokenResult = $token->token;
        // $tokenResult->expires_at = Carbon::now()->addWeeks(1);
        // $tokenResult->save();

        // return response()->json([
        //     'access_token' => $token->accessToken,
        //     'token_type' => 'Bearer',
        //     'expires_at' => Carbon::parse($tokenResult->expires_at)->toDateTimeString(),
        //     'user' => $user->load(['mother.children', 'role', 'staff'])
        // ]);
    }

    public function createSession($data)
    {
        $_SESSION['usr'] = $data['userid'];
        $_SESSION['usrsecure'] = $data['usersecure'];
        $_SESSION['usrgroup'] = $data['usergroup'];
        $_SESSION['usrname'] = $data['username'];
        $_SESSION['usrmail'] = $data['useremail'];
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
