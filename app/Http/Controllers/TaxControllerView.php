<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tax;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaxControllerView extends Controller
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
            return redirect('/taxes')->withErrors($validator)->withInput();
        }

        $tax = new Tax;
        $tax->name = $request->input('name');
        $tax->rate = $request->input('rate');

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Customize the storage path and create a unique filename
            $folder = 'upload/tax_images';
            $filename = 'id_' . $tax->id . '_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Store the image in the "public" disk, which corresponds to the "public" directory
            $imagePath = $image->storeAs($folder, $filename, 'public');

            // Save the public URL in the database
            $tax->image = 'storage/' . $imagePath;
        }

        $tax->save();

        return redirect('/taxes')->with('success', 'tax added successfully');
    }
    public function getAllTaxes()
    {
        $taxes = Tax::all();
        return view('pages.taxes', ['taxes' => $taxes]);
    }
    public function deleteTaxById(Request $request, $id)
    {
        try {
            $tax = Tax::findOrFail($id);

            // Check if the tax has associated products
            // if ($tax->hasProducts()) {
            //     return redirect('/taxes')->with('error', 'Tax has associated products and cannot be deleted.');
            // }

            // Delete the associated image from storage
            if (!empty($tax->image) && Storage::disk('public')->exists(str_replace('storage/', '', $tax->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $tax->image));
            }

            $tax->delete();

            return redirect('/taxes')->with('successDelete', 'Tax deleted successfully');
        } catch (ModelNotFoundException $exception) {
            return redirect('/taxes')->with('error', 'Tax not found');
        } catch (\Exception $exception) {
            return redirect('/taxes')->with('error', 'Error deleting tax: ' . $exception->getMessage());
        }
    }
    public function getTaxById($id)
    {
        $tax = Tax::findOrFail($id);
    
        return view('pages.edittax', compact('tax'));
    }
    public function updateTaxById(Request $request, $id)
    {
        try {
            $tax = Tax::findOrFail($id);
    
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'rate' => 'required|numeric',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Example image validation rules
            ]);
    
            if ($validator->fails()) {
                return back()->with(['category' => $tax])->withErrors($validator)->withInput();
            }
    
            $tax->update([
                'name' => $request->input('name'),
                'rate' => $request->input('rate'),
                // Add other fields as 
            ]);
            if ($request->hasFile('image')) {
                // Delete the existing image
                if (!empty($tax->image) && Storage::disk('public')->exists(str_replace('storage/', '',$tax->image))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $tax->image));
                }
    
                // Customize the storage path and create a unique filename
                $folder = 'upload/tax_images';
                $filename = 'id_' . $tax->id . '_' . time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
    
                // Store the new image in the specified folder with the customized filename
                $imagePath = $request->file('image')->storeAs($folder, $filename, 'public');
    
                $tax->image = 'storage/' . $imagePath;
                $tax->save();
            }
            return redirect('/taxes')->with('successDelete', 'Tax updated successfully');
    
        } catch (\Exception $err) {
            return view('pages.edittax', ['tax' => $tax])->with('error', 'Error updating Tax: ' . $err->getMessage());
        }
    }
}
