import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    const openCategoryModalBtn = document.getElementById('btn-open-category-modal');
    const closeCategoryModalBtn = document.getElementById('btn-close-category-modal');
    const categoryModal = document.getElementById('new-category-modal');

    if (openCategoryModalBtn && closeCategoryModalBtn && categoryModal) {
        openCategoryModalBtn.addEventListener('click', function () {
            categoryModal.classList.remove('hidden');
        });

        closeCategoryModalBtn.addEventListener('click', function () {
            categoryModal.classList.add('hidden');
        });
    }

    const confirmForms = document.querySelectorAll('.form-confirm');
    confirmForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const message = form.getAttribute('data-message') || 'Are you sure?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
});
