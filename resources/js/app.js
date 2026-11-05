import './bootstrap';

// Live tag filtering on the solution page: hides products that do not have
// every ticked tag, without reloading. The form still works without JS.
const form = document.getElementById('tag-filter');

if (form) {
    const items = Array.from(document.querySelectorAll('#product-list li'));
    const count = document.getElementById('product-count');
    const empty = document.getElementById('no-products');
    const checkboxes = Array.from(form.querySelectorAll('input[name="tags[]"]'));

    const applyFilter = () => {
        const selected = checkboxes.filter((c) => c.checked).map((c) => c.value);
        let visible = 0;

        items.forEach((item) => {
            const tags = item.dataset.tags ? item.dataset.tags.split(',') : [];
            const match = selected.every((id) => tags.includes(id));
            item.hidden = !match;
            if (match) visible++;
        });

        count.textContent = `${visible} of ${items.length} products`;
        empty.hidden = visible > 0;

        // Keep the URL shareable.
        const params = new URLSearchParams();
        selected.forEach((id) => params.append('tags[]', id));
        const query = params.toString();
        history.replaceState(null, '', location.pathname + (query ? `?${query}` : ''));
    };

    checkboxes.forEach((c) => c.addEventListener('change', applyFilter));
    form.addEventListener('submit', (e) => { e.preventDefault(); applyFilter(); });
    applyFilter();
}
