document.addEventListener('DOMContentLoaded', () => {
    /* Form-change */
    const addDiv = document.getElementById('add-container');
    const editDiv = document.getElementById('edit-container');
    const btnAdd = document.getElementById('add-btn');
    const btnEdit = document.getElementById('edit-btn');

    btnAdd.addEventListener('click', () => {
        addDiv.classList.remove('hidden');
        editDiv.classList.add('hidden');
    });

    btnEdit.addEventListener('click', () => {
        addDiv.classList.add('hidden');
        editDiv.classList.remove('hidden');
    });

    /* SearchInput-Lists */
    const searchInput = document.getElementById('search-edit');
    const idInput = document.getElementById('id-edit');
    const nameInput = document.getElementById('name-edit');
    const priceInput = document.getElementById('price-edit');
    const descriptionInput = document.getElementById('description-edit');
    const stockInput = document.getElementById('stock-edit');
    const imageEdit1 = document.getElementById('container-image1');
    const imageEdit2 = document.getElementById('container-image2');
    const imageEdit3 = document.getElementById('container-image3');
    const resultsList = document.getElementById('resultsList');
    const editForm = document.getElementById('formEdit');

    let debouncerTime;
    //Listener for search-bar
    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.trim();

        clearTimeout(debouncerTime);

        if (query.length < 2) {
            hideResults();
            return;
        }

        debouncerTime = setTimeout(() => {
            fetchResults(query);
        }, 300);
    });
    //Call to the BD and fetch data
    async function fetchResults(query) {
        try {

            const url = new URL('/products', window.location.origin);
            url.searchParams.append('search', query);

            const response = await fetch(url);
            const result = await response.json();
            renderResults(result);

        } catch (error) {
            console.error('Error al consultar la API:', error);
            hideResults();
        }
    }


    //Render the data obtained via fetch
    function renderResults(result) {
        resultsList.innerHTML = '';

        const items = result.data;

        if (!items || items.length === 0) {
            hideResults();
            return;
        }

        items.forEach(item => {
            const li = document.createElement('li');
            const minImage = document.createElement('img');
            const shortText = item.name.length > 15 ? item.name.substring(0, 15) + "..." : item.name;
            li.textContent = shortText;
            minImage.src = `/storage/${item.images[0].path}thumbnail.webp`;
            li.addEventListener('click', () => {
                hideResults();
                editForm.action = `/products/${item.id}`;
                idInput.value = item.id;
                nameInput.value = item.name;
                priceInput.value = item.price;
                descriptionInput.value = item.description;
                stockInput.value = item.stock;
                cleanUpImg();
                for (let index = 0; index < item.images.length; index++) {
                    const img = document.createElement('img');
                    img.id = `imageE${index + 1}`;
                    img.src = `/storage/${item.images[index].path}medium.webp`;
                    document.getElementById(`container-image${index + 1}`).appendChild(img);
                }
            });

            resultsList.appendChild(li);
            li.appendChild(minImage);
        });

        resultsList.style.display = 'block';
    }
    //Hide lists of search results to edit
    function hideResults() {
        resultsList.innerHTML = '';
        resultsList.style.display = 'none';
    }

    document.addEventListener('click', (e) => {
        if (!e.target.closest('.autocomplete-container')) {
            hideResults();
        }
    });

    //Cleanup images of the lists
    function cleanUpImg() {
        imageEdit1.innerHTML = '';
        imageEdit2.innerHTML = '';
        imageEdit3.innerHTML = '';
    }


    function cleanUpForm() {
        editForm.reset();
        cleanUpImg();
    }

    //Delete
    const token = document.querySelector('meta[name="csrf-token"]').content;

    async function deleteProduct() {
        const id = idInput.value;
        console.log(id);
        try {
            const response = await fetch(`/products/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                console.error('Error al eliminar', response.status);
                return;
            }

            const result = await response.json();

            console.log('Producto eliminado');
            console.log(result);
            cleanUpForm();
        } catch (error) {
            console.error('Error en la peticion:', error);
        }

    }
    const btnDelete = document.getElementById('delete-btn');

    btnDelete.addEventListener('click', () => {
        deleteProduct();
    });

});