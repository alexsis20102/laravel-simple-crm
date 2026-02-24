import axios from 'axios';
import { initTable } from './table.js';

document.addEventListener('DOMContentLoaded', () => {
    initSideMenu();
});

export function initSideMenu() {

    const menu = document.getElementById('sideMenu');
    const content = document.getElementById('content');

    if (!menu || !content) return;

    menu.addEventListener('click', async (e) => {
        const link = e.target.closest('.nav-link');
        if (!link) return;

        e.preventDefault();

      
        menu.querySelectorAll('.nav-link').forEach(el =>
            el.classList.remove('active')
        );
        link.classList.add('active');

        
        const url = link.dataset.url;

        try {
            content.innerHTML = `
                <div class="text-muted">Loading...</div>
            `;

            const response = await axios.get(url);

            content.innerHTML = response.data;

            initTable();

        } catch (error) {
            content.innerHTML = `
                <div class="text-danger">Error loading content</div>
            `;
        }
    });
}