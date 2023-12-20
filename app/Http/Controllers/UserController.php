<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'exists:roles,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->input('role_id', 1), // Default to 1 if not provided
            ]);
            return response()->json(['user' => $user, 'success' => true], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Registration failed'], 500);
        }
    }
    public function login(Request $request)
    {
        // Check if the user is already authenticated
        if (Auth::check()) {
            return response()->json(['error' => 'User is already authenticated'], 400);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('access_token')->plainTextToken;

                return response()->json(['user' => $user, 'access_token' => $token, 'success' => true]);
            } else {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Login failed'], 500);
        }
    }

    public function getAllUsers()
    {
        try {
            $users = User::with('role')->get();

            return response()->json(['users' => $users]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve users'], 500);
        }
    }
    public function getUserById($id)
    {
        try {
            $user = User::with('role')->find($id);

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            return response()->json(['user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve user'], 500);
        }
    }

    public function editUser(Request $request, $id)
{
    try {
        // Retrieve the user based on the token or any other custom authentication mechanism
        $user = User::findOrFail($id);

        // If the user is not found, return a 404 response
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $inputs = $request->except('_method');

        $validator = Validator::make($inputs, [
            'name'     => 'nullable|string',
            'email'    => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role_id'  => 'exists:roles,id',
            'bio'      => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Update user details
        $user->update($inputs);

        return response()->json(['user' => $user, 'success' => true], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to update user details'], 500);
    }
}

public function deleteUser($id)
{
    try {
        $user = User::findOrFail($id);

        // If the user is not found, return a 404 response
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Delete the user
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to delete user'], 500);
    }
}

}
