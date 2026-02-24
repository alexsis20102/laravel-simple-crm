<div class="card bg-dark text-light border-secondary">

            <!-- Header -->
            <div class="card-header bg-dark border-secondary d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Clients</h6>

                <div class="d-flex gap-2 align-items-center">
                    <input type="text"
                    class="form-control form-control-sm bg-dark text-light border-secondary js-table-search"
                    placeholder="Search..."
                    id="searchInput" style="width: 200px">

                    <button class="btn btn-success btn-sm js-create">
                        + Add client
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0 js-table" 
                    data-endpoint="/api/dashboard/clients"
                    data-editpoint="/dashboard/clients/{id}/edit"
                    data-delitpoint="/api/dashboard/clients/{id}"
                    data-createpoint="/dashboard/clients/create"
                    data-viewpoint="/dashboard/clients/client/{id}"
                    data-defaultcontaner="content"
                    data-per-page="10"
                    data-default-sort="id"
                    data-default-direction="desc" 
                    id="dataTable">
                    <thead>
                    <tr id="tableHead">
                        <th data-field="id">ID
                            <span class="sort-indicator"></span>
                        </th>
                        <th data-field="created_by">User add
                            <span class="sort-indicator"></span>
                        </th>
                        <th data-field="first_name">First name
                            <span class="sort-indicator"></span>
                        </th>
                        <th data-field="last_name">Last name
                            <span class="sort-indicator"></span>
                        </th>
                        <th data-field="email">Email
                            <span class="sort-indicator"></span>
                        </th>
                        <th data-field="phone">Phone
                            <span class="sort-indicator"></span>
                        </th>
                        <th data-field="status">Status
                            <span class="sort-indicator"></span>
                        </th>
                        <th data-field="created_at">Created
                            <span class="sort-indicator"></span>
                        </th>
                        <th class="text-end" data-actions>Actions</th>
                    </tr>
                    </thead>
                    <tbody class="js-table-body" id="tableBody">
                    
                    </tbody>
                </table>
            </div>

            <div class="js-pagination"></div>
        </div>