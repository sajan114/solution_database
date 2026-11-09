import './bootstrap';

const form = document.getElementById('tag-filter');

if (form) {
    const products = document.querySelectorAll('#product-list li');
    const checkboxes = form.querySelectorAll('input[name="tags[]"]');
    const counter = document.getElementById('product-count');
    const noProductsMessage = document.getElementById('no-products');
    const searchInput = document.getElementById('product-search');

    function filterProducts() {
        // Get selected tag ids
        const selectedTags = [];

        for (const box of checkboxes) {
            if (box.checked) {
                selectedTags.push(box.value);
            }
        }

        // Get search text
        const searchText = searchInput.value.toLowerCase().trim();

        let visibleCount = 0;

        // Check each product
        for (const product of products) {
            const productTags = product.dataset.tags.split(',');
            const productName = product.dataset.name;

            let showProduct = true;

            // Check selected tags
            for (const tagId of selectedTags) {
                if (!productTags.includes(tagId)) {
                    showProduct = false;
                }
            }

            // Check product name
            if (!productName.includes(searchText)) {
                showProduct = false;
            }

            product.hidden = !showProduct;

            if (showProduct) {
                visibleCount++;
            }
        }

        // Update product count
        counter.textContent =
            visibleCount + ' of ' + products.length + ' products';

        // Show message if no product matches
        noProductsMessage.hidden = visibleCount !== 0;
    }

    // Listen for tag changes
    for (const box of checkboxes) {
        box.addEventListener('change', filterProducts);
    }

    // Listen for search input
    searchInput.addEventListener('input', filterProducts);

    // Stop form from reloading the page
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        filterProducts();
    });

    // Run when page loads
    filterProducts();
}