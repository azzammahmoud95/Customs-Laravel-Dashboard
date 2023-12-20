<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleControllerView extends Controller
{
    //
    public function addRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:roles,name',
        ]);
    
        if ($validator->fails()) {
            return redirect('/roles')->withErrors($validator)->withInput();
        }
    
        $role = new Role;
        $role->name = $request->input('name');
        $role->save();
    
        return redirect('/roles')->with('success', 'role added successfully');
    }
    

    public function getAllRoles()
    {
        $roles = Role::all();
        return view('pages.roles', ['roles' => $roles]);
    }
    public function deleteRoleById(Request $request, $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
    
            return redirect('/roles')->with('successDelete', 'Role deleted successfully');
        } catch (ModelNotFoundException $exception) {
            return redirect('/roles')->with('error', 'Role not found');
        } catch (\Exception $exception) {
            return redirect('/roles')->with('error', 'Error deleting role: ' . $exception->getMessage());
        }   
    }
    public function getRoleById($id)
    {
        $role = Role::findOrFail($id);
    
        // Show the edit form view
        return view('pages.editrole', compact('role'));
    }


    public function updateRoleById(Request $request, $id)
{
    try {
        $role = Role::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()->with(['role' => $role])->withErrors($validator)->withInput();
        }

        $role->update([
            'name' => $request->input('name'),
        ]);

        return redirect('/roles')->with('successDelete', 'Role updated successfully');

    } catch (\Exception $err) {
        return view('pages.editrole', ['role' => $role])->with('error', 'Error updating role: ' . $err->getMessage());
    }
}
}
