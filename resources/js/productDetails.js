document.addEventListener('DOMContentLoaded', () => {

    const url = new URL(window.location.href);
    const id = url.pathname.split('/').pop();

    const title = document.getElementById('title');
    const imagesContainer = document.getElementById('imagesContainer');
    const largeImage = document.getElementById('largeImage');
    const largeImageBlur = document.getElementById('largeImageBlur');
    const imagesThumbnails = document.getElementById('imagesThumbnails');
    const price = document.getElementById('price');
    const stock = document.getElementById('stock');
    const description = document.getElementById('description');

    async function fetchProduct(id) {
        const shortUrl = `/products/${id}`
        try {

            const response = await fetch(shortUrl);

            if (!response.ok) {
                throw new Error('Error couldnt found product');
            }

            const product = await response.json();

            renderResult(product);
            
        } catch (error) {
            
            console.error('Error:', error);
        }

    }

    function renderResult(product){

        title.textContent = product.name;
        price.textContent = '$'+product.price;
        stock.textContent = product.stock;
        description.textContent = product.description;
        largeImage.src = `/storage/${product.images[0].path}large.webp`
        largeImageBlur.src = `/storage/${product.images[0].path}large.webp`
        for (let index = 0; index < product.images.length; index++) {
            const images = document.createElement('img');
            const card = document.createElement('div');
            card.classList.add('card');
            card.id = `cardImage${index+1}`;
            images.id = `imagesT${index+1}`;
            images.src = `/storage/${product.images[index].path}thumbnail.webp`;

            imagesThumbnails.appendChild(card);
            document.getElementById(`cardImage${index+1}`).appendChild(images);
        }

    }

    fetchProduct(id);

});