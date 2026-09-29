<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    @vite(['resources/css/catalog.css', 'resources/js/catalog.js'])
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
    <header id="header">
        <nav id="nav-bar" class="header-title">
            <h1 class="titulo">Catalogo online</h1>
        </nav>
    </header>
    <main class="main_section">
        <div class="search-section">
            <input type="search" class="search-bar" name="search" id="searchBar">
            <button type="button" class="search-btn">
                <span class="material-icons">search</span>
            </button>
        </div>
        <div class="container" id="productsContainer">

        </div>
    </main>
</body>

</html>