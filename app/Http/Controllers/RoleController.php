<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    //
   
    
    public function addRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:roles,name',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        $role = new Role;
        $role->name = $request->input('name');
        $role->save();
    
        return response()->json(['message' => 'Role added successfully', 'data' => $role], 201);
    }
    

    public function getAllRoles()
    {
        $roles = Role::all();
        if ($roles->isEmpty()) {
            return response()->json([
                'message' => 'No role found.',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $roles,
        ]);
    }
    public function getRoleById(Request $request, $id)
    {
        try {
            $role = Role::findOrFail($id);

            return response()->json([
                'success' => true,
                'role' => $role,
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'error' => 'Role not found',
            ], 404); // 404 status code indicates resource not found
        }
    }

    public function deleteRoleById(Request $request, $id)
    {
        $category = Role::find($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'category deleted successfully',
        ]);
    }

    public function updateRoleById(Request $request, $id)
    {
        try {
            $role = Role::findOrFail($id);
            $inputs = $request->except('_method');
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255|unique:roles,name',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
            $role->update($inputs);

            return response()->json([
                'role' => $role,
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'success' => true,
                'message' => 'Error updating role: ' . $err->getMessage(),
            ], 500); // 500 status code indicates internal server error
        }
    }
}
