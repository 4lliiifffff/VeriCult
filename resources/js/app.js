import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Automatically map table headers to data-label attributes for responsive tables
const initResponsiveTables = () => {
    document.querySelectorAll('table.responsive-table').forEach(table => {
        const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
        table.querySelectorAll('tbody tr').forEach(tr => {
            tr.querySelectorAll('td').forEach((td, index) => {
                if (headers[index] && !td.hasAttribute('data-label')) {
                    td.setAttribute('data-label', headers[index]);
                }
            });
        });
    });
};

document.addEventListener('DOMContentLoaded', () => {
    initResponsiveTables();
    
    // Watch for dynamic DOM changes (Alpine, Livewire, AJAX pagination/search)
    const observer = new MutationObserver(() => {
        initResponsiveTables();
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});
