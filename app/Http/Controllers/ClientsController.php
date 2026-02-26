<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\clients;
use Illuminate\Http\Request;
use App\Enums\ClientStatus;
use Illuminate\Validation\Rules\Enum;

class ClientsController extends Controller
{

    public function index(Request $request)
    {
        // -------- Parameter validation --------
        $validated = $request->validate([
            'page'      => 'nullable|integer|min:1',
            'per_page'  => 'nullable|integer|min:5|max:100',
            'search'    => 'nullable|string|max:255',
            'sort'      => 'nullable|string|in:id,user_id,first_name,last_name,email,phone,status,created_at',
            'direction' => 'nullable|string|in:asc,desc',
        ]);

        // -------- Default Settings --------
        $perPage   = $validated['per_page']  ?? 10;
        $sort      = $validated['sort']      ?? 'id';
        $direction = $validated['direction'] ?? 'desc';
        $search    = $validated['search']    ?? null;

        // -------- Query --------
        $query = clients::query()
            ->with(['user:id,name'])
            ->select('id', 'user_id', 'first_name', 'last_name', 'email', 'phone', 'status', 'created_at');

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
                  ;
            });
        }

        // -------- Sorting --------
       
        $query->orderBy($sort, $direction);
        

        // -------- Pagination --------
        $users = $query->paginate($perPage)->withQueryString();

        // -------- Answer --------

        return response()->json([
            'success' => true,
            'data' => $users->map(fn ($client) => [
                'id' => $client->id,
                'first_name' => $client->first_name,
                'last_name' => $client->last_name,
                'email' => $client->email,
                'phone' => $client->phone,
                'status' => $client->status->label(),
                'created_by' => $client->user->name ?? '—',
                'created_at' => $client->created_at?->format('Y.m.d H:i'),
            ]),
            'meta' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'total' => $users->total(),
            ],
        ]);


       
    }

    public function edit(\App\Models\clients $client)
    {
        return view('static.dashboard.clients.edit-form', [
            'client' => $client,
        ]);
    }

    public function create()
    {
        return view('static.dashboard.clients.create-form');
    }

    public function update(Request $request, \App\Models\clients $client)
    {
        $validated = $request->validate([
            'first_name' => ['required','string','max:100'],
            'last_name'  => ['required','string','max:100'],
            'email'      => ['required','email','max:255'],
            'status'     => ['required', new Enum(ClientStatus::class)],
            'phone'      => ['nullable', 'string', 'max:30'],
        ]);

        $client->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Client updated',
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:255'],
            'phone'      => ['nullable', 'string', 'max:30'],
        ]);

        clients::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Client created',
        ]);
    }


    public function destroy(\App\Models\clients $client)
    {
        $client->delete();

        return response()->json([
            'success' => true,
            'message' => 'Client deleted',
        ]);
    }

    public function show(\App\Models\clients $client)
    {
        $client->load([
            'user:id,name',
            'contacts.user:id,name'
        ]);

        return view('static.dashboard.clients.show', [
            'client' => $client
        ]);
    }

}
