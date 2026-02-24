<form id="clientAddForm" data-action="{{ route('dashboard.clients.store') }}">
    @csrf

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