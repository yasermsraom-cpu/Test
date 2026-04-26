// =====================================
// SAMAK - main.js (basic interactivity)
// =====================================

// Confirm before deleting
document.addEventListener('click', function (e) {
    const link = e.target.closest('.confirm-delete');
    if (link) {
        if (!confirm('Are you sure you want to delete this item?')) {
            e.preventDefault();
        }
    }
});

// Live search filter (Browse page) - filters product cards by name
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('keyup', function () {
        const term = this.value.toLowerCase().trim();
        document.querySelectorAll('.product-card').forEach(card => {
            const name = card.dataset.name.toLowerCase();
            card.style.display = name.includes(term) ? '' : 'none';
        });
    });
}

// Category & price-sort filters
const catFilter   = document.getElementById('categoryFilter');
const priceFilter = document.getElementById('priceFilter');

function applyFilters() {
    const cat = catFilter ? catFilter.value : 'all';
    document.querySelectorAll('.product-card').forEach(card => {
        const cardCat = card.dataset.category;
        card.style.display = (cat === 'all' || cardCat === cat) ? '' : 'none';
    });

    if (priceFilter && priceFilter.value !== 'none') {
        const grid = document.querySelector('.products-grid');
        if (!grid) return;
        const cards = Array.from(grid.children);
        cards.sort((a, b) => {
            const pa = parseFloat(a.dataset.price);
            const pb = parseFloat(b.dataset.price);
            return priceFilter.value === 'low' ? pa - pb : pb - pa;
        });
        cards.forEach(c => grid.appendChild(c));
    }
}
if (catFilter)   catFilter.addEventListener('change', applyFilters);
if (priceFilter) priceFilter.addEventListener('change', applyFilters);

// Auto-hide alerts after 4 seconds
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(el => el.style.display = 'none');
}, 4000);

// Image preview when admin chooses a file
const imgInput = document.getElementById('imageInput');
const imgPreview = document.getElementById('imagePreview');
if (imgInput && imgPreview) {
    imgInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            imgPreview.src = URL.createObjectURL(file);
            imgPreview.style.display = 'block';
        }
    });
}
