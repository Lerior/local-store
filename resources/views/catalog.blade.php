<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    @vite(['resources/css/navbar.css'])
</head>

<body>
    <header id="header">
        <nav id="nav-bar" class="background">
            <h1 class="titulo">Catalogo online</h1>
        </nav>
    </header>
    <main class="main_section">
        <div class="search-section">
            <input type="search" class="search-bar" name="search" id="searchBar">
            <button type="button" class="search-btn">Buscar</button>
        </div>
        <div class="container">
            <div class="product-card">
                <img src="{{ asset('storage/products/number1/front/chamarraNegra.webp') }}" alt="Chamarra negra">
                <h3 id="pTitle"  class="product-title" name="product">Chamarra Negra</h3>
                <p id="pPrice" class="product-price" name="price">$500.00</p>
            </div>
        </div>
    </main>
</body>

</html>