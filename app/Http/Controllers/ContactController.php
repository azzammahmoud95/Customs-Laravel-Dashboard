<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContactController extends Controller
{
    //
    public function addContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'company' => 'nullable|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:40',
            'address' => 'nullable|max:255',
            'description' => 'nullable',
            'website' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $contact = new Contact;
        $contact->name = $request->input('name');
        $contact->company = $request->input('company');
        $contact->email = $request->input('email');
        $contact->phone = $request->input('phone');
        $contact->address = $request->input('address');
        $contact->description = $request->input('description');
        $contact->website = $request->input('website');
        $contact->save();

        return response()->json(['message' => 'Contact added successfully', 'data' => $contact], 201);
    }

    public function getAllContact()
    {
        $contacts = Contact::all();
        if ($contacts->isEmpty()) {
            return response()->json([
                'message' => 'No contact found.',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $contacts,
        ]);
    }
    public function getContactById(Request $request, $id)
    {
        try {
            $contact = Contact::findOrFail($id);

            return response()->json([
                'success' => true,
                'contact' => $contact,
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'error' => 'Contact not found',
            ], 404); // 404 status code indicates resource not found
        }
    }

    public function deleteContactById(Request $request, $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Contact deleted successfully',
            ]);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'error' => 'Contact not found',
            ], 404); // 404 status code indicates resource not found
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Error deleting contact: ' . $exception->getMessage(),
            ], 500); // 500 status code indicates internal server error
        }
    }

    public function updateContactById(Request $request, $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $inputs = $request->except('_method');
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'company' => 'nullable|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|max:40',
                'address' => 'nullable|max:255',
                'description' => 'nullable',
                'website' => 'nullable|url',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
            $contact->update($inputs);

            return response()->json([
                'success'=> true,
                'contact' => $contact,
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'success' => true,
                'message' => 'Error updating contact: ' . $err->getMessage(),
            ], 500); // 500 status code indicates internal server error
        }
    }
}
