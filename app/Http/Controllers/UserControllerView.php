<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserControllerView extends Controller
{
    //
    public function login(Request $request)
    {
        // Check if the user is already authenticated
        // if (Auth::check()) {
        //     return redirect('/')->with('error', 'User is already authenticated');
        // }

        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                Rule::exists('users', 'email'), // Check if the email exists in the 'users' table
            ],
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect('/login')->withErrors($validator)->withInput();
        }

        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                // You can customize the redirect URL or add more logic here
                $token = $user->createToken('access_token')->plainTextToken;

                $cookie = cookie('access_token', $token, 60 * 24 * 30);
                return redirect('/')->withCookie($cookie)->with('success', 'Login successful');
            } else {
                return redirect('/login')->withErrors('error', 'Invalid credentials')->withInput();
            }
        } catch (\Exception $e) {
            return redirect('/login')->with('error', $e->getMessage());
        }
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect('/register')->withErrors($validator)->withInput();
        }
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->input('role_id', 1), // Default to 1 if not provided
            ]);
            return redirect('/')->with('success', 'Registration successful');
        } catch (\Exception $e) {
            return redirect('/register')->with('error', $e->getMessage());
        }

    }
}
