<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Producto</title>
</head>
@vite(['resources/css/productDetails.css', 'resources/js/productDetails.js'])
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<header id="header">
    <nav id="nav-bar" class="header-title">
        <h1 class="titleBar">Catalogo online</h1>
    </nav>
</header>
<main>
    <div class="container">
        <div class="imagesContainer">
            <div class="cardLargeImage">
                <img class="large-image-blur" src="" alt="" id="largeImageBlur" aria-hidden="true">
                <img class="large-image" src="" alt="" id="largeImage">
            </div>
        </div>
        <div class="section-description">
            <label class="price" for="" id="price"></label>
            <label class="generalText productTitle" for="" id="title"></label>
            <div class="imagesThumbnails" id="imagesThumbnails"></div>
            <label class="generalText stock" for="stock">Disponibles:
                <label class="generalText stock" for="" id="stock"></label>
            </label>
            <label class="generalText descriptionAbout" for="desciprion">A cerca del artículo:</label>
            <label class="generalText description" for="" id="description"></label>
        </div>
    </div>
</main>