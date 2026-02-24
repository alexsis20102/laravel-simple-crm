<div class="card bg-dark text-light border-secondary">
    <div class="card-header border-secondary">
        <h5 class="mb-0">Client #{{ $client->id }}</h5>
    </div>

    <div class="card-body">

        <div class="mb-2">
            <strong>Name:</strong>
            {{ $client->first_name }} {{ $client->last_name }}
        </div>

        <div class="mb-2">
            <strong>Email:</strong>
            {{ $client->email }}
        </div>

        <div class="mb-2">
            <strong>Phone:</strong>
            {{ $client->phone ?? '—' }}
        </div>

        <div class="mb-2">
            <strong>Status:</strong>
            {{ $client->status->label() }}
        </div>

        <div class="mb-2">
            <strong>Created by:</strong>
            {{ $client->user->name ?? '—' }}
        </div>

        <div class="mb-2">
            <strong>Created:</strong>
            {{ $client->created_at?->format('d.m.Y H:i') }}
        </div>

    </div>
</div>

<div class="card bg-dark text-light border-secondary mt-3">
    <div class="card-header border-secondary">
        <h6 class="mb-0">Contacts</h6>
    </div>

    <div class="card-body p-0">
        <table class="table table-dark table-sm mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Phone</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @forelse($client->contacts as $contact)
                    <tr>
                        <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                        <td>{{ $contact->type->label() }}</td>
                        <td>{{ $contact->phone ?? '—' }}</td>
                        <td>{{ $contact->email ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            No contacts
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>