@php
    use App\Enums\ClientStatus;
@endphp

<form id="clientEditForm"
      data-action="{{ route('dashboard.clients.update', $client->id) }}"
>
    @csrf
    @method('PUT')

    

    <div class="mb-3">
        <label class="form-label">First name</label>
        <input type="text"
               name="first_name"
               class="form-control bg-dark text-light border-secondary"
               value="{{ $client->first_name }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Last name</label>
        <input type="text"
               name="last_name"
               class="form-control bg-dark text-light border-secondary"
               value="{{ $client->last_name }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email"
               name="email"
               class="form-control bg-dark text-light border-secondary"
               value="{{ $client->email }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text"
               name="phone"
               class="form-control bg-dark text-light border-secondary"
               value="{{ $client->phone }}">
    </div>

    <div class="mb-3">
    <label class="form-label">Status</label>

    <select name="status"
                class="form-select bg-dark text-light border-secondary">
            @foreach (ClientStatus::cases() as $status)
                <option value="{{ $status->value }}"
                    @selected($client->status === $status)>
                    {{ $status->label() }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary btn-sm">
            Save
        </button>
    </div>
</form>