<form id="clientAddForm" data-action="{{ route('dashboard.contacts.store') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Client</label>

        <select id="clientSelect"
                name="client_id"
                class="form-select bg-dark text-light border-secondary">
            <option value="">Select client...</option>

            @foreach($clients as $client)
                <option value="{{ $client->id }}">
                    {{ $client->first_name }} {{ $client->last_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Contact type</label>
        <select name="type"
                class="form-select bg-dark text-light border-secondary">
            @foreach(\App\Enums\ContactType::cases() as $type)
                <option value="{{ $type->value }}">
                    {{ $type->label() }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">First name</label>
        <input type="text"
               name="first_name"
               class="form-control bg-dark text-light border-secondary"
               value="">
    </div>

    <div class="mb-3">
        <label class="form-label">Last name</label>
        <input type="text"
               name="last_name"
               class="form-control bg-dark text-light border-secondary"
               value="">
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email"
               name="email"
               class="form-control bg-dark text-light border-secondary"
               value="">
    </div>

    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text"
               name="phone"
               class="form-control bg-dark text-light border-secondary"
               value="">
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary btn-sm">
            Save
        </button>
    </div>
</form>