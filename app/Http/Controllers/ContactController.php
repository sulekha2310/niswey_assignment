<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index()
    {
        $all_list = Contact::orderBy('id', 'desc')->paginate(10);
        return view('contacts.index', compact('all_list'));
    }
    
    public function create()
    {
        return view('contacts.create');
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50|unique:contacts,phone',
        ]);
        
        
        Contact::create($data);
        
        return redirect()->route('contacts.index')->with('success','Contact created');
    }
    
    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }
    
    
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }
    
    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50|unique:contacts,phone,'.$contact->id,
        ]);
        
        $contact->update($data);
        return redirect()->route('contacts.index')->with('success','Contact updated');
    }
    
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully');
    }

    // Show upload form
    public function importForm()
    {
        return view('contacts.import');
    }

    public function importXml(Request $request)
    {
        // Step 1: basic validation (file must exist)
        $request->validate([
            'xml_file' => 'required|file', // remove mimes:xml
        ]);

        // Step 2: check extension manually
        $extension = $request->file('xml_file')->getClientOriginalExtension();
        if (strtolower($extension) !== 'xml') {
            return back()->withErrors(['xml_file' => 'The file must have .xml extension']);
        }

        // Step 3: proceed with loading XML and importing contacts
        try {
            $xml = simplexml_load_file($request->file('xml_file')->getRealPath());
        } catch (\Exception $e) {
            return back()->withErrors(['xml_file' => 'Invalid XML file.']);
        }

        $imported = 0;
        $skipped = 0;

        foreach ($xml->contact as $c) {
            $name = trim((string) $c->name);
            $phone = trim((string) $c->phone);

            if (!$name || !$phone) {
                $skipped++;
                continue;
            }

            $contact = Contact::firstOrNew(['phone' => $phone]);
            $contact->name = $name;
            $contact->save();

            $imported++;
        }

        // return redirect()->route('contacts.index')->with('success', "$imported unique contacts imported, $skipped skipped.");
        return redirect()->route('contacts.index')->with('success', "$imported unique contacts imported");
    }

}
