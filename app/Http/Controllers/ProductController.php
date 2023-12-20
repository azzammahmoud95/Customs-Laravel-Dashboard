<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //
    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'HScode' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'note' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'tax_ids' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }


        $product = new Product;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->HScode = $request->input('HScode');
        $product->note = $request->input('note');
        $product->category_id = $request->input('category_id');

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $folder = 'upload/product_images';
            $filename = 'id_' . $product->id . '_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Store the image in the specified folder with the customized filename
            $imagePath = $image->storeAs($folder, $filename, 'public');
            $product->image = 'storage/' . $imagePath;
        }
        $product->save();

        if ($request->filled('tax_ids')) {
            // Ensure tax_ids is an array
            $tax_ids = is_array($request->tax_ids) ? $request->tax_ids : [$request->tax_ids];
            $product->taxes()->attach($tax_ids);
        }


        return response()->json(['message' => 'Product added successfully', 'data' => $product], 201);
    }



    public function getAllProducts()
    {
        $products = Product::with('category', 'taxes')->get();

        return response()->json([
            'success' => true,
            'data' => $products]);
    }
    public function getProductById($id)
    {
        $product = Product::with('category', 'taxes')->find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json(['product' => $product]);
    }

    public function updateProductById(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'HScode' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'note' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'tax_ids' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Handle image file separately if it's a file upload
        if ($request->hasFile('image')) {
            // Delete the existing image
            if (!empty($product->image) && Storage::disk('public')->exists(str_replace('storage/', '', $product->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $product->image));
            }

            // Customize the storage path and create a unique filename
            $folder = 'upload/product_images';
            $filename = 'id_' . $product->id . '_' . time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();

            // Store the new image in the specified folder with the customized filename
            $imagePath = $request->file('image')->storeAs($folder, $filename, 'public');

            $product->image = 'storage/' . $imagePath;
        }

        $product->name = $request->input('name');
        $product->HScode = $request->input('HScode');
        $product->description = $request->input('description');
        $product->note = $request->input('note');

        // Check if category_id exists in the request before assigning it
        if ($request->filled('category_id')) {
            $product->category_id = $request->input('category_id');
        }

        $product->save();

        if ($request->filled('tax_ids')) {
            $tax_ids = is_array($request->input('tax_ids')) ? $request->input('tax_ids') : json_decode($request->input('tax_ids'));

            // Sync the provided tax IDs without detaching
            $product->taxes()->syncWithoutDetaching($tax_ids);

            // Detach any other tax associations that are not in the provided list
            $product->taxes()->sync($tax_ids);
        }

        return response()->json(['success' => true, 'data' => $product]);
    }


    public function deleteProductById($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Delete the image file if it exists
        if (!empty($product->image) && Storage::disk('public')->exists(str_replace('storage/', '', $product->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $product->image));
        }

        // Detach relationships (e.g., taxes) before deleting the product
        $product->taxes()->detach();

        // Delete the product
        $product->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted successfully']);
    }

}
