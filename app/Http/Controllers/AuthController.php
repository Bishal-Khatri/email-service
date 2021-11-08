<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\SetResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use SetResponse;
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('apptoken')->plainTextToken;

        $response = $this->prepareResponse(true, 'user created.', compact('user', 'token'),[]);

        return response()->json($response);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user OR !Hash::check($request->password, $user->password)){
            return response()->json($this->prepareResponse(true, 'bad credentials.', [],[]), 401);
        }

        $token = $user->createToken('apptoken')->plainTextToken;

        $response = $this->prepareResponse(false, 'login success.', compact('user', 'token'),[]);

        return response()->json($response);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        $response = $this->prepareResponse(false, 'logout success.', [],[]);

        return response()->json($response);
    }
}
