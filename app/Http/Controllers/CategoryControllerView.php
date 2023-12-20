<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryControllerView extends Controller
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
            return redirect('/categories')->withErrors($validator)->withInput();
        }

        $category = new Category;
        $category->name = $request->input('name');
        $category->description = $request->input('description');

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Customize the storage path and create a unique filename
            $folder = 'upload/category_images';
            $filename = 'id_' . $category->id . '_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Store the image in the "public" disk, which corresponds to the "public" directory
            $imagePath = $image->storeAs($folder, $filename, 'public');

            // Save the public URL in the database
            $category->image = 'storage/' . $imagePath;
        }

        $category->save();

        return redirect('/categories')->with('success', 'Category added successfully');
    }
    public function getAllCategories()
    {
        $categories = Category::all();
        return view('pages.categories', ['categories' => $categories]);
    }
    public function deleteCategoryById(Request $request, $id)
    {
        try {
            $category = Category::find($id);

            // Check if the category exists
            if ($category->products()->exists()) {
                return redirect('/categories')->with('errorRelation', 'Category has related products and cannot be deleted.');
            }

            // Delete the associated image from storage
            if (!empty($category->image) && Storage::disk('public')->exists(str_replace('storage/', '', $category->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $category->image));
            }

            // Delete the category
            $category->delete();

            return redirect('/categories')->with('successDelete', 'Category deleted successfully');

        } catch (ModelNotFoundException $exception) {
            return redirect('/categories')->with('error', 'Category not found');
        } catch (\Exception $exception) {
            return redirect('/categories')->with('error', 'Error deleting information: ' . $exception->getMessage());
        }
    }

    public function getCategoryById($id)
    {
        $category = Category::findOrFail($id);
    
        return view('pages.editcategory', compact('category'));
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
            return back()->with(['category' => $category])->withErrors($validator)->withInput();
        }

        $category->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            // Add other fields as 
        ]);
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
        return redirect('/categories')->with('successDelete', 'Category updated successfully');

    } catch (\Exception $err) {
        return view('pages.editcategory', ['category' => $category])->with('error', 'Error updating category: ' . $err->getMessage());
    }
}
}

