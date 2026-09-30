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
    const resultsList = document.getElementById('resultsList');

    let debouncerTime;

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.trim();

        clearTimeout(debouncerTime);

        if (query.length < 3) {
            hideResults();
            return;
        }

        debouncerTime = setTimeout(() => {
            fetchResults(query);
        }, 150);
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
                searchInput.value = item.name;
                hideResults();
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

    function fillEditProductInputs(){

    }
});