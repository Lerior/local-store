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
    const editForm =  document.getElementById('formEdit');

    let debouncerTime;

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.trim();

        clearTimeout(debouncerTime);

        if (query.length < 2) {
            hideResults();
            return;
        }

        debouncerTime = setTimeout(() => {
            fetchResults(query);
        }, 50);
    });

    async function fetchResults(query) {
        try {

            const response = await fetch(`http://localhost:8000/products?search=${query}`);
            const result = await response.json();
            renderResults(result);

        } catch (error) {
            console.error('Error al consultar la API:', error);
            hideResults();
        }
    }



    function renderResults(result) {
        resultsList.innerHTML = '';

        const items = result.data;

        if (!items || items.length === 0) {
            hideResults();
            return;
        }

        items.forEach(item => {
            const li = document.createElement('li');
            li.textContent = item.name;
            li.addEventListener('click', () => {
                hideResults();
                editForm.action = `/products/${item.id}`;
                idInput.value = item.id;
                nameInput.value = item.name;
                priceInput.value = item.price;
                descriptionInput.value = item.description;
                stockInput.value = item.stock;
                cleanImg();
                for (let index = 0; index < item.images.length; index++) {
                    const img = document.createElement('img');
                    img.id = `imageE${index+1}`;
                    img.src = `/storage/${item.images[index].path}medium.webp`;
                    document.getElementById(`container-image${index+1}`).appendChild(img);
                }
            });

            resultsList.appendChild(li);
        });

        resultsList.style.display = 'block';
    }

    function hideResults() {
        resultsList.innerHTML = '';
        resultsList.style.display = 'none';
    }

    document.addEventListener('click', (e) => {
        if (!e.target.closest('.autocomplete-container')) {
            hideResults();
        }
    });

    function cleanImg(){
        imageEdit1.innerHTML='';
        imageEdit2.innerHTML='';
        imageEdit3.innerHTML='';
    }

    function cleanForm(){
        editForm.reset();
        cleanImg();
    }
});