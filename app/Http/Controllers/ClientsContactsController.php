<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contacts;
use App\Enums\ContactType;
use Illuminate\Validation\Rules\Enum;

class ClientsContactsController extends Controller
{
    public function index(Request $request)
    {
        
        $validated = $request->validate([
            'page'      => 'nullable|integer|min:1',
            'per_page'  => 'nullable|integer|min:5|max:100',
            'search'    => 'nullable|string|max:255',
            'sort'      => 'nullable|string|in:id,first_name,last_name,email,phone,type,created_at,updated_at',
            'direction' => 'nullable|string|in:asc,desc',
        ]);

        // -------- Default Settings --------
        $perPage   = $validated['per_page']  ?? 10;
        $sort      = $validated['sort']      ?? 'id';
        $direction = $validated['direction'] ?? 'desc';
        $search    = $validated['search']    ?? null;

        // -------- Query --------
        $query = contacts::query()
            ->with(['user:id,name'])
            ->with(['client:id,first_name,last_name'])
            ->select('id', 'client_id', 'user_id', 'first_name', 'last_name', 'phone', 'email', 'type', 'created_at', 'updated_at');

        // -------- Search --------
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })

                    
                    ->orWhereHas('client', function ($q) use ($search) {
                        $q->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
                  ;
            });
        }

        // -------- Sorting --------
       
        $query->orderBy($sort, $direction);
       

        // -------- Pagination --------
        $contacts = $query->paginate($perPage)->withQueryString();

        // -------- Answer --------

        return response()->json([
            'success' => true,
            'data' => $contacts->map(fn ($contact) => [
                'id' => $contact->id,
                'first_name' => $contact->first_name,
                'last_name' => $contact->last_name,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'type' => $contact->type->label(),
                'created_by' => $contact->user->name ?? '—',
                'client_by' => $contact->client->first_name.' '.$contact->client->last_name,
                'created_at' => $contact->created_at?->format('Y.m.d H:i'),
            ]),
            'meta' => [
                'current_page' => $contacts->currentPage(),
                'last_page' => $contacts->lastPage(),
                'total' => $contacts->total(),
            ],
        ]);


       
    }

    public function showPage()
    {
        return view('static.dashboard.pages.contacts');
    }

    public function create()
    {

        $clients = \App\Models\Clients::select('id', 'first_name', 'last_name')->get();

        return view('static.dashboard.contacts.create-form', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['nullable', 'email', 'max:255'],
            'phone'      => ['nullable', 'string', 'max:30'],
            'client_id' => ['required', 'exists:clients,id'],
            'type' => ['required', new Enum(ContactType::class)],
        ]);

        Contacts::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Client created',
        ]);
    }

    public function destroy(\App\Models\Contacts $Contact)
    {
        $Contact->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contact deleted',
        ]);
    }

    public function edit(\App\Models\Contacts $Contact)
    {
        return view('static.dashboard.contacts.edit-form', [
            'contact' => $Contact,
        ]);
    }

    public function update(Request $request, \App\Models\Contacts $Contact)
    {
        $validated = $request->validate([
            'first_name' => ['required','string','max:100'],
            'last_name'  => ['required','string','max:100'],
            'email'      => ['nullable','email','max:255'],
            'type'     => ['required', new Enum(ContactType::class)],
            'phone'      => ['nullable', 'string', 'max:30'],
        ]);

        $Contact->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Contact updated',
        ]);
    }

}
