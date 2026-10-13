// resources/js/catalog.js
document.addEventListener('DOMContentLoaded', () => {
    const searchBar = document.getElementById('searchBar');
    const searchBtn = document.getElementById('searchBtn');
    const container = document.getElementById('productsContainer');
    const bannerHome = document.getElementById('nav-bar');

    //Load products lists
    function loadProducts(searchTerm = '') {
        container.replaceChildren();
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

                const products = paginatedData.data;

                if (!products || products.length === 0) {
                    const noProduct = document.createElement('p');
                    noProduct.textContent = 'No se encontraron productos';
                    container.appendChild(noProduct);
                    return;
                }

                products.forEach(product => {
                    const shortText = product.name.length > 35 ? product.name.substring(0, 35) + "..." : product.name;
                    const imagePath = (product.images && product.images.length > 0)
                        ? `/storage/${product.images[0].path}/medium.webp`
                        : '/images/default-product.webp';

                    const productCard = document.createElement('div');
                    productCard.classList.add('product-card');
                    productCard.id = `cardProduct${product.id}`;

                    const image = document.createElement('img');
                    image.src = `${imagePath}`;
                    image.alt = `${product.name}`

                    const productTitle = document.createElement('p');
                    productTitle.classList.add('product-title');
                    productTitle.textContent = `${shortText}`;

                    const productPrice = document.createElement('p');
                    productPrice.classList.add('product-price');
                    productPrice.textContent = `$${parseFloat(product.price).toFixed(2)}`;

                    productCard.appendChild(image);
                    productCard.appendChild(productTitle);
                    productCard.appendChild(productPrice);
                    container.appendChild(productCard);

                    //Redirection event
                    productCard.addEventListener('click', () => {
                        window.location.href = `/product/${product.id}`;
                    });
                });
            })
            .catch(err => console.error('Error cargando productos:', err));
    }

    // Load products when open the page
    loadProducts();

    // Search event
    if (searchBtn) {
        searchBtn.addEventListener('click', () => {
            const cleanValue = searchBar.value.trim();
            if (!(cleanValue === "")) {
                loadProducts(searchBar.value);
            }
        });
    }

    //Enter -> search event
    if (searchBar) {
        searchBar.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                const cleanValue = searchBar.value.trim();
                if (!(cleanValue === "")) {
                    loadProducts(searchBar.value);
                }
            }
        });
    }
    //Load products when clic banner
    if (bannerHome) {
        bannerHome.addEventListener('click', () => {
            loadProducts();
        });
    }



});