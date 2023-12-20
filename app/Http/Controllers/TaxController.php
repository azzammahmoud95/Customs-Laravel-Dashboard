<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaxController extends Controller
{
    //
    public function addTax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'rate' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Example image validation rules
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        $tax = new Tax;
        $tax->name = $request->input('name');
        $tax->rate = $request->input('rate');
    
        // Handle image file separately if it's a file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
    
            // Customize the storage path and create a unique filename
            $folder = 'upload/tax_images';
            $filename = 'id_' . $tax->id . '_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    
            // Store the image in the specified folder with the customized filename
            $imagePath = $image->storeAs($folder, $filename, 'public');
    
            // Save the public URL in the database
            $tax->image = 'storage/' . $imagePath;
        } else {
            $tax->image = $request->input('image'); // If 'image' is a URL or file path
        }
    
        $tax->save();
    
        return response()->json(['message' => 'Tax added successfully', 'data' => $tax], 201);
    }
    public function getAllTaxes()
    {
        $taxes = Tax::all();
        if ($taxes->isEmpty()) {
            return response()->json([
                'message' => 'No tax found.',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $taxes,
        ]);
    }
    public function getTaxById(Request $request, $id)
    {
        try {
            $tax = Tax::findOrFail($id);

            return response()->json([
                'success' => true,
                'tax' => $tax,
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'error' => 'Tax not found',
            ], 404); // 404 status code indicates resource not found
        }
    }

    public function deleteTax(Request $request, $id)
{
    try {
        $tax = Tax::findOrFail($id);

        // Delete the image file if it exists (adjust the storage path as needed)
        if (!empty($tax->image) && Storage::disk('public')->exists(str_replace('storage/', '', $tax->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $tax->image));
        }

        $tax->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tax deleted successfully',
        ]);
    } catch (ModelNotFoundException $exception) {
        return response()->json([
            'error' => 'Tax not found',
        ], 404); // 404 status code indicates resource not found
    } catch (\Exception $exception) {
        return response()->json([
            'error' => 'Error deleting tax: ' . $exception->getMessage(),
        ], 500); // 500 status code indicates internal server error
    }
}

public function updateTax(Request $request, $id)
{
    try {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'rate' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $tax = Tax::findOrFail($id);
        $tax->name = $request->input('name');
        $tax->rate = $request->input('rate');

        // Handle image file separately if it's a file upload
        if ($request->hasFile('image')) {
            // Delete the existing image file if it exists
            if (!empty($tax->image) && Storage::disk('public')->exists(str_replace('storage/', '', $tax->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $tax->image));
            }

            // Store the new image file with a unique filename
            $image = $request->file('image');
            $folder = 'upload/tax_images';
            $filename = 'id_' . $tax->id . '_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs($folder, $filename, 'public');
    
            // Save the public URL in the database
            $tax->image = 'storage/' . $imagePath;
        }

        $tax->save();

        return response()->json(['message' => 'Tax updated successfully', 'data' => $tax], 200);
    } catch (ModelNotFoundException $exception) {
        return response()->json(['error' => 'Tax not found'], 404);
    } catch (\Exception $exception) {
        return response()->json(['error' => 'Error updating tax: ' . $exception->getMessage()], 500);
    }
}
}
