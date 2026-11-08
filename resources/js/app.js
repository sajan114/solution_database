import './bootstrap';

const form = document.getElementById('tag-filter');

if (form) {
    const products = document.querySelectorAll('#product-list li');
    const checkboxes = form.querySelectorAll('input[name="tags[]"]');
    const counter = document.getElementById('product-count');
    const noProductsMessage = document.getElementById('no-products');

    function filterProducts() {
        // 1. Collect the ids of the ticked checkboxes
        const selectedTags = [];
        for (const box of checkboxes) {
            if (box.checked) {
                selectedTags.push(box.value);
            }
        }

        // 2. Show or hide each product, and count the visible ones
        let visibleCount = 0;

        for (const product of products) {
            const productTags = product.dataset.tags.split(',');
            let showProduct = true;

            for (const tagId of selectedTags) {
                if (!productTags.includes(tagId)) {
                    showProduct = false;
                }
            }

            product.hidden = !showProduct;

            if (showProduct) {
                visibleCount = visibleCount + 1;
            }
        }

        // 3. Update the counter text
        counter.textContent = visibleCount + ' of ' + products.length + ' products';

        // 4. Show the message only when nothing matches
        if (visibleCount === 0) {
            noProductsMessage.hidden = false;
        } else {
            noProductsMessage.hidden = true;
        }
    }

    // Run the filter whenever a checkbox changes
    for (const box of checkboxes) {
        box.addEventListener('change', filterProducts);
    }

    // Stop the form from reloading the page
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        filterProducts();
    });

    // Run once when the page loads
    filterProducts();
}
