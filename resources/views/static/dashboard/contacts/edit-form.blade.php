@php
    use App\Enums\ContactType;
@endphp

<form id="clientEditForm"
      data-action="{{ route('dashboard.contacts.update', $contact->id) }}"
>
    @csrf
    @method('PUT')

    

    <div class="mb-3">
        <label class="form-label">First name</label>
        <input type="text"
               name="first_name"
               class="form-control bg-dark text-light border-secondary"
               value="{{ $contact->first_name }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Last name</label>
        <input type="text"
               name="last_name"
               class="form-control bg-dark text-light border-secondary"
               value="{{ $contact->last_name }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email"
               name="email"
               class="form-control bg-dark text-light border-secondary"
               value="{{ $contact->email }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text"
               name="phone"
               class="form-control bg-dark text-light border-secondary"
               value="{{ $contact->phone }}">
    </div>

    <div class="mb-3">
    <label class="form-label">Status</label>

    <select name="type"
                class="form-select bg-dark text-light border-secondary">
            @foreach (ContactType::cases() as $type)
                <option value="{{ $type->value }}"
                    @selected($contact->type === $type)>
                    {{ $type->label() }}
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