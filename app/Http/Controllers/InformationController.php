<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InformationController extends Controller
{
    //
    public function addInformation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $information = new Information;
        $information->name = $request->input('name');
        $information->description = $request->input('description');
        $information->save();

        return response()->json(['message' => 'Information added successfully', 'data' => $information], 201);
    }

    public function getAllInformations()
    {
        $informations = Information::all();
        if ($informations->isEmpty()) {
            return response()->json([
                'message' => 'No information found.',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $informations,
        ]);
    }
    public function getInformationById(Request $request, $id)
    {
        try {
            $information = Information::findOrFail($id);

            return response()->json([
                'success' => true,
                'information' => $information,
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'error' => 'Information not found',
            ], 404); // 404 status code indicates resource not found
        }
    }

    public function deleteInformationById(Request $request, $id)
    {
        $category = Information::find($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'category deleted successfully',
        ]);
    }

    public function updateInformationById(Request $request, $id)
    {
        try {
            $information = Information::findOrFail($id);
            $inputs = $request->except('_method');
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'description' => 'nullable',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
            $information->update($inputs);

            return response()->json([
                'information' => $information,
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'success' => true,
                'message' => 'Error updating information: ' . $err->getMessage(),
            ], 500); // 500 status code indicates internal server error
        }
    }
}
