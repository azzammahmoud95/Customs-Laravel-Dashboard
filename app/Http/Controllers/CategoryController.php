<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function addCategory(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'description' => 'nullable',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $category = new Category;
    $category->name = $request->input('name');
    $category->description = $request->input('description');

    // Handle image file separately if it's a file upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
    
        // Customize the storage path and create a unique filename
        $folder = 'upload/category_images';
        $filename = 'id_' . $category->id . '_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    
        // Store the image in the specified folder with the customized filename
        $imagePath = $image->storeAs($folder, $filename, 'public');
    
        $category->image = 'storage/' . $imagePath;
    }

    $category->save();

    return response()->json(['message' => 'Category added successfully', 'data' => $category], 201);
}


    public function getAllCategories()
    {
        $categories = Category::all();
        if ($categories->isEmpty()) {
            return response()->json([
                'message' => 'No category found.',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }
    public function getCategoryById(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            return response()->json([
                'success' => true,
                'category' => $category,
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'error' => 'Category not found',
            ], 404); // 404 status code indicates resource not found
        }
    }

 public function deleteCategoryById(Request $request, $id)
{
    try {
        $category = Category::find($id);

        // Check if the category exists
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        }

        // Delete the associated image from storage
        if (!empty($category->image) && Storage::disk('public')->exists(str_replace('storage/', '', $category->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $category->image));
        }

        // Delete the category
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category and associated image deleted successfully',
        ]);
    } catch (\Exception $err) {
        return response()->json([
            'success' => false,
            'message' => 'Error deleting category: ' . $err->getMessage(),
        ], 500);
    }
}

    

    public function updateCategoryById(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'description' => 'nullable',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
    
            $category->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]);
    
            // Handle image file separately if it's a file upload
            if ($request->hasFile('image')) {
                // Delete the existing image
                if (!empty($category->image) && Storage::disk('public')->exists(str_replace('storage/', '',$category->image))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $category->image));
                }
    
                // Customize the storage path and create a unique filename
                $folder = 'upload/category_images';
                $filename = 'id_' . $category->id . '_' . time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
    
                // Store the new image in the specified folder with the customized filename
                $imagePath = $request->file('image')->storeAs($folder, $filename, 'public');
    
                $category->image = 'storage/' . $imagePath;
                $category->save();
            }
    
            return response()->json([
                'category' => $category,
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating category: ' . $err->getMessage(),
            ], 500);
        }
    }
}
