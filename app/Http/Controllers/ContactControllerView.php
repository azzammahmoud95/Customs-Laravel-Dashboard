<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContactControllerView extends Controller
{
    //
    public function addContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'company' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:40',
            'address' => 'required|max:255',
            'description' => 'required',
            'website' => 'required|url',
        ]);

        if ($validator->fails()) {
            return redirect('/contacts')->withErrors($validator)->withInput();
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

        return redirect('/contacts')->with('success', 'Contact added successfully');
    }
    public function getAllContact()
    {
        $contacts = Contact::all();
        return view('pages.contacts', ['contacts' => $contacts]);
    }
    public function deleteContactById(Request $request, $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
    
            return redirect('/contacts')->with('successDelete', 'Contact deleted successfully');
        } catch (ModelNotFoundException $exception) {
            return redirect('/contacts')->with('error', 'Contact not found');
        } catch (\Exception $exception) {
            return redirect('/contacts')->with('error', 'Error deleting contact: ' . $exception->getMessage());
        }   
    }
    public function getContactById($id)
    {
        // Fetch the information by ID
        $contact = Contact::findOrFail($id);
    
        // Show the edit form view
        return view('pages.editcontact', compact('contact'));
    }
    public function updateContactById(Request $request, $id)
{
    try {
        $contact = Contact::findOrFail($id);

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
            return back()->with(['contact' => $contact])->withErrors($validator)->withInput();
        }

        $contact->update([
            'name' => $request->input('name'),
            'company' => $request->input('company'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'description' => $request->input('description'),
            'website' => $request->input('website'),
        ]);

        return redirect('/contacts')->with('successDelete', 'Contact updated successfully');

    } catch (\Exception $err) {
        return view('pages.editcontact', ['contact' => $contact])->with('error', 'Error updating Contact: ' . $err->getMessage());
    }
}
}
