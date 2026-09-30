// resources/js/catalog.js

document.addEventListener('DOMContentLoaded', () => {
    const searchBar = document.getElementById('searchBar');
    const searchBtn = document.getElementById('searchBtn');
    const container = document.getElementById('productsContainer');
    const bannerHome = document.getElementById('nav-bar');

    function loadProducts(searchTerm = '') {
        const url = new URL('/products', window.location.origin);
        if (searchTerm) {
            url.searchParams.append('search', searchTerm);
        }

        fetch(url, {
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(res => res.json())
            .then(paginatedData => {
                container.innerHTML = '';

                // Laravel paginate devuelve los registros dentro de .data
                const products = paginatedData.data;

                if (!products || products.length === 0) {
                    container.innerHTML = '<p>No se encontraron productos.</p>';
                    return;
                }

                products.forEach(product => {
                    // Ajusta la propiedad de la imagen según la estructura de tu modelo de imágenes
                    const imagePath = (product.images && product.images.length > 0)
                        ? `/storage/${product.images[0].path}/medium.webp`
                        : '/images/default-product.webp';

                    const cardHTML = `
                    <div class="product-card">
                        <img src="${imagePath}" alt="${product.name}">
                        <p class="product-title">${product.name}</p>
                        <p class="product-price">$${parseFloat(product.price).toFixed(2)}</p>
                    </div>
                `;
                    container.insertAdjacentHTML('beforeend', cardHTML);
                });
            })
            .catch(err => console.error('Error cargando productos:', err));
    }

    // Cargar productos al iniciar la página
    loadProducts();

    // Evento de búsqueda
    if (searchBtn) {
        searchBtn.addEventListener('click', () => {
            loadProducts(searchBar.value);
        });
    }

    if (searchBar) {
        searchBar.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                loadProducts(searchBar.value);
            }
        });
    }

    if (bannerHome) {
        bannerHome.addEventListener('click', () => {
            loadProducts();
        });
    }
});