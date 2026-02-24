import Sortable from 'sortablejs';
import * as bootstrap from 'bootstrap';
import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.css";

export function initTable(root = document) {

    const tables = root.querySelectorAll('.js-table');

    tables.forEach(table => {
        new TableEngine(table);
    });
   
}



class TableEngine {

    constructor(table) {
        this.table = table;
        this.tbody = table.querySelector('.js-table-body');
        this.pagination = table.closest('.card')?.querySelector('.js-pagination');

        this.endpoint = table.dataset.endpoint;
        this.editpoint = table.dataset.editpoint;
        this.delitpoint = table.dataset.delitpoint;
        this.createpoint = table.dataset.createpoint;
        this.viewpoint = table.dataset.viewpoint;
        this.createBtn = table.closest('.card')?.querySelector('.js-create');
       
        this.perPage = table.dataset.perPage ?? 10;
        this.sort = table.dataset.defaultSort ?? 'id';
        this.direction = table.dataset.defaultDirection ?? 'desc';
        this.defaultcontaner = table.dataset.defaultcontaner ?? 'content';
        

        this.searchInput = table.closest('.card')?.querySelector('.js-table-search');

        this.page = 1;

        this.init();
        this.load();
    }

    init() {
        this.initCreate();
        this.initSearch();
        this.initSorting();
        this.initActions();
    }

    /* ---------- LOAD ---------- */

    async load() {
        const response = await axios.get(this.endpoint, {
            params: {
                page: this.page,
                per_page: this.perPage,
                sort: this.sort,
                direction: this.direction,
                search: this.searchInput?.value || null
            }
        });

        this.renderRow(response.data.data);
        this.renderPagination(response.data.meta);
    }

    /* ---------- Create ---------- */

    initCreate() {

        if (!this.createBtn || !this.createpoint) return;

        this.createBtn.addEventListener('click', async () => {
            try {
                const modalBody = document.getElementById('addModalBody');
                modalBody.innerHTML = `<div class="text-muted text-center">Loading...</div>`;

                const response = await axios.get(this.createpoint);

                modalBody.innerHTML = response.data;

                this.FormButton();
                this.FormAddButton();
                this.initClientSelect();

                const modalEl = document.getElementById('addModal');
                const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.show();

            } catch (error) {
                alert('Failed to load create form');
            }
        });
    }

    /* ---------- RENDER ---------- */



    renderRow(rows) {
            this.tbody.innerHTML = rows.map(row => {
            let html = '<tr>';

            this.columns().forEach(col => {
                html += `<td>${row[col] ?? ''}</td>`;
            });

            html += '<td class="text-end">';
            html += this.renderActions(row);
            html += '</td>';

            html += '</tr>';

            return html;
        }).join('');
    }    


     renderActions(row) {

        let html = '<div class="btn-group btn-group-sm">';

        if (this.viewpoint) {
            html += `
                <button 
                    data-url="${this.viewpoint.replace('{id}', row.id)}"
                    class="btn btn-outline-success js-show-info"
                >👁</button>
            `;
        }

        if (this.editpoint) {
            html += `
                <button 
                    class="btn btn-outline-primary js-edit" 
                    data-id="${row.id}"
                >✏️</button>
            `;
        }

        if (this.delitpoint) {
            html += `
                <button 
                    class="btn btn-outline-danger js-delete" 
                    data-id="${row.id}"
                >🗑</button>
            `;
        }

        html += '</div>';

        return html;
    } 
    

    renderPagination(meta) {
        if (!this.pagination) return;

        let html = `<ul class="pagination pagination-sm mb-0">`;

        for (let i = 1; i <= meta.last_page; i++) {
            html += `
                <li class="page-item ${i === meta.current_page ? 'active' : ''}">
                    <a class="page-link" data-page="${i}">${i}</a>
                </li>
            `;
        }

        html += `</ul>`;
        this.pagination.innerHTML = html;

        this.pagination.querySelectorAll('[data-page]').forEach(link => {
            link.addEventListener('click', e => {
                this.page = +e.target.dataset.page;
                this.load();
            });
        });
    }

    /* ---------- HELPERS ---------- */

    columns() {
        return [...this.table.querySelectorAll('th')]
            .map(th => th.dataset.field)
            .filter(Boolean);
    }

    /* ---------- SEARCH ---------- */

    initSearch() {
        if (!this.searchInput) return;

        let timeout;
        this.searchInput.addEventListener('input', () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                this.page = 1;
                this.load();
            }, 300);
        });
    }

    /* ---------- SORT ---------- */

    initSorting() {
        this.table.querySelectorAll('th[data-field]').forEach(th => {

            th.addEventListener('click', () => {
                const field = th.dataset.field;

                if (this.sort === field) {
                    this.direction = this.direction === 'asc' ? 'desc' : 'asc';
                } else {
                    this.sort = field;
                    this.direction = 'asc';
                }

                this.updateSortIndicators();
                this.load();
            });
        });

        this.updateSortIndicators();
    }

    updateSortIndicators() {
        this.table.querySelectorAll('th').forEach(th => {
            const indicator = th.querySelector('.sort-indicator');
            if (!indicator) return;

            indicator.innerHTML = '';
            th.classList.remove('sorted');
        });

        const active = this.table.querySelector(
            `th[data-field="${this.sort}"]`
        );

        if (!active) return;

        const indicator = active.querySelector('.sort-indicator');
        active.classList.add('sorted');

        indicator.innerHTML = this.direction === 'asc'
            ? ' ▲'
            : ' ▼';
    }


    initActions() {
            this.tbody.addEventListener('click', async (e) => {

                const editBtn = e.target.closest('.js-edit');
                const deleteBtn = e.target.closest('.js-delete');
                const showBtn = e.target.closest('.js-show-info');

                

                /* ---------- EDIT ---------- */
                if (editBtn) {
                    const id = editBtn.dataset.id;

                    if (!this.editpoint) return;

                    try {
                        const modalBody = document.getElementById('editModalBody');
                        modalBody.innerHTML = `<div class="text-muted text-center">Loading...</div>`;

                        const response = await axios.get(
                            this.editpoint.replace('{id}', id)
                        );

                        modalBody.innerHTML = response.data;


                        this.FormButton();
                        this.FormAddButton();
                        this.initClientSelect();

                        const modalEl = document.getElementById('editModal');
                        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                        modal.show();

                    } catch (error) {
                        alert('Failed to load edit form');
                    }
                }

                /* ---------- DELETE ---------- */
                if (deleteBtn) {
                    const id = deleteBtn.dataset.id;

                    if (!this.delitpoint) return;

                    if (!confirm('Delete this record?')) return;

                    try {
                        await axios.delete(
                            this.delitpoint.replace('{id}', id)
                        );

                        
                        this.load();

                    } catch (error) {
                        alert('Failed to delete record');
                    }
                }

                /* ---------- SHOW ---------- */
                if (showBtn) {
                    const url = showBtn.dataset.url;
                    const content = document.getElementById(this.defaultcontaner);

                    if (!url || !content) return;

                    try {
                       content.innerHTML = `
                            <div class="text-muted">Loading...</div>
                        `;

                        const response = await axios.get(url);

                        content.innerHTML = response.data;


                    } catch (error) {
                        alert('No loading data');
                    }
                }

            });
        }

    FormButton()
    {
        const form = document.getElementById('clientEditForm');

        if (!form || form.dataset.bound === '1') return;
        form.dataset.bound = '1';

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const action = form.dataset.action;
            const formData = new FormData(form);

            try {
                await axios.post(action, formData, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });

                const modalEl = document.getElementById('editModal');
                const modal = bootstrap.Modal.getInstance(modalEl);

                const modalBody = document.getElementById('editModalBody');
                modalBody.innerHTML = `<div class="text-muted text-center">Loading...</div>`;

                modal.hide();

                this.reload();

            } catch (error) {
                if (error.response?.status === 422) {
                    this.showFormErrors(form, error.response.data.errors);
                } else {
                    alert('Save failed');
                }
            }
        });
    }

    FormAddButton()
    {
        const form = document.getElementById('clientAddForm');

        if (!form || form.dataset.bound === '1') return;
        form.dataset.bound = '1';

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const action = form.dataset.action;
            const formData = new FormData(form);

            try {
                await axios.post(action, formData, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });

                const modalEl = document.getElementById('addModal');
                const modal = bootstrap.Modal.getInstance(modalEl);

                const modalBody = document.getElementById('addModalBody');
                modalBody.innerHTML = `<div class="text-muted text-center">Loading...</div>`;

                modal.hide();

                this.reload();

            } catch (error) {
                if (error.response?.status === 422) {
                    this.showFormErrors(form, error.response.data.errors);
                } else {
                    alert('Save failed');
                }
            }
        });
    }

    initClientSelect()
    {
        const el = document.getElementById('clientSelect');
        if (!el) return;

        if (el.tomselect) return;

        new TomSelect(el, {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    }

    showFormErrors(form, errors) {
            
            form.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });

            form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

            Object.keys(errors).forEach(field => {
                const input = form.querySelector(`[name="${field}"]`);
                if (!input) return;

                input.classList.add('is-invalid');

                const div = document.createElement('div');
                div.className = 'invalid-feedback';
                div.innerText = errors[field][0];

                input.closest('.mb-3').appendChild(div);
            });
        }

    reload(resetPage = false) {
        if (resetPage) {
            this.page = 1;
        }

        this.load();
    }

}