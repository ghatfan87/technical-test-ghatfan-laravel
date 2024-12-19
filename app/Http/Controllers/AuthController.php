<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\password;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(Request $request)
    {

        try{
            $request->validate([
                'name' => "required|string|max:255",
                'email' => "required|email|unique:users,email",
                'password' => "required|string|min:8"
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            $TambahData = User::where('id', $user->id)->first();
                if ($TambahData) {
                    return ApiFormatter::createAPI(200, 'Login Success', [
                        'user' => $user,
                        'token' => $token
                    ]);
                } else {
                    return ApiFormatter::createAPI(400, 'Failed');
                }
            } catch (Exception $error) {
                return ApiFormatter::createAPI(500, 'Internal Server Error', $error->getMessage());
            }
        }


    /**
     * Show the form for creating a new resource.
     */
        public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => "required|email",
                'password' => "required|string|min:8"
            ]);

            if (!Auth::attempt($request->only('email', 'password'))) {
                return ApiFormatter::createAPI(401, 'Email or password is incorrect');
            }

            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('auth_token')->plainTextToken;

            return ApiFormatter::createAPI(200, 'Login Success', [
                'user' => $user,
                'token' => $token
            ]);

        } catch (Exception $error) {
            return ApiFormatter::createAPI(500, 'Internal Server Error', $error->getMessage());
        }
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
