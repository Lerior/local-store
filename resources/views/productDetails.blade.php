<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Administracion</title>
</head>
@vite(['resources/css/productDetails.css', 'resources/js/productDetails.js'])
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<main>
    <div class="container">
        <label for="" id="title"></label>
        <div class="imagesContainer">
            <img src="" alt="" id="largeImage">
            <div class="imagesMini" id="imagesThumbnails">
                <label class="thumbnail" for="" id="imagesT1"></label>
                <label class="thumbnail" for="" id="imagesT2"></label>
                <label class="thumbnail" for="" id="imagesT3"></label>
            </div>
        </div>
        <label for="" id="price"></label>
        <label for="" id="stock"></label>
        <label for="" id="description"></label>
    </div>
</main>