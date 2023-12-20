<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InformationControllerView extends Controller
{
    //
    public function addInformation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',       
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/informations')->withErrors($validator)->withInput();
        }

        $information = new Information;
        $information->name = $request->input('name');
        $information->description = $request->input('description');
        $information->save();

        return redirect('/informations')->with('success', 'Information added successfully');
    }
    public function getAllInformations()
    {
        $informations = Information::all();
        return view('pages.informations', ['informations' => $informations]);
    }
    public function deleteInformationById(Request $request, $id)
    {
        try {
            $information = Information::findOrFail($id);
            $information->delete();
    
            return redirect('/informations')->with('successDelete', 'Information deleted successfully');
        } catch (ModelNotFoundException $exception) {
            return redirect('/informations')->with('error', 'Information not found');
        } catch (\Exception $exception) {
            return redirect('/informations')->with('error', 'Error deleting information: ' . $exception->getMessage());
        }   
    }
    public function getInformationById($id)
    {
        // Fetch the information by ID
        $information = Information::findOrFail($id);
    
        // Show the edit form view
        return view('pages.editinformation', compact('information'));
    }


    public function updateInformationById(Request $request, $id)
{
    try {
        $information = Information::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required|min:2',
        ]);

        if ($validator->fails()) {
            return back()->with(['information' => $information])->withErrors($validator)->withInput();
        }

        $information->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            // Add other fields as needed
        ]);

        return redirect('/informations')->with('successDelete', 'Information updated successfully');

    } catch (\Exception $err) {
        return view('pages.editinformation', ['information' => $information])->with('error', 'Error updating information: ' . $err->getMessage());
    }
}
    
}
