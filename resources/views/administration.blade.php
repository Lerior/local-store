<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion</title>
</head>
@vite(['resources/css/administration.css', 'resources/js/administration.js'])
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">


<nav class="navmenu">
    <div class="div-menu">
        <button class="btn add-btn" id="add-btn">
            <span class="material-icons">add</span>
        </button>
        <button class="btn edit-btn" id="edit-btn">
            <span class="material-icons">edit</span>
        </button>
    </div>
    <form action="{{ route('logout') }}" method="POST" class="form-btn">
        @csrf
        <button class="btn logout-btn" type="submit">
            <span class="material-icons">logout</span>
        </button>
    </form>
</nav>

<main class="admin-container">
    <div class="add-container" id="add-container">
        <label for="add-container">Agregar Producto</label>
        <form method="POST" action="/products" enctype="multipart/form-data" class="add-form">
            @csrf
            <div class="form-group">
                <label for="name">Nombre del Producto:</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Precio:</label>
                <input type="number" min="0" step="0.01" inputmode="numeric" name="price" id="price" required>
                @error('price')
                    <span class="error-number">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Descripcion:</label>
                <textarea name="description" id="description" cols="30" rows="2"></textarea>
                @error('description')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="stock">En existencia:</label>
                <input type="number" name="stock" id="stock" min="0" step="1" required>
                @error('stock')
                    <span class="error-number">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group file-style">
                <label for="image_1">Imagen frontal:</label>
                <input type="file" id="image_1" name="images[1]" accept="image/png,image/jpeg,image/webp" required>
                @error('images.1')
                    <span class="error-file">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group file-style">
                <label for="image_2">Imagen lateral:</label>
                <input type="file" id="image_2" name="images[2]" accept="image/png,image/jpeg,image/webp">
                @error('images.2')
                    <span class="error-file">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group file-style">
                <label for="image_3">Imagen trasera:</label>
                <input type="file" id="image_3" name="images[3]" accept="image/png,image/jpeg,image/webp">
                @error('images.3')
                    <span class="error-file">{{ $message }}</span>
                @enderror
            </div>

            @error('images')
                <span class="error-file">{{ $message }}</span>
            @enderror

            <button type="submit" class="btn-submit">Agregar</button>
        </form>
    </div>

    <!-- Second menu (EDIT)  -->
    <div class="edit-container hidden" id="edit-container">
        <label for="edit-container">Editar/Eliminar Producto</label>
        <form method="POST" id="formEdit" action="/products" enctype="multipart/form-data" class="edit-form">
            @csrf
            @method('PATCH')
            <label class="search-label" for="search-edit">Buscar Producto: </label>
            <div class="search-section">
                <div class="input-wrapper autocomplete-container">
                    <input type="search" name="search-edit" id="search-edit" class="search-input"
                        placeholder="Ingresa nombre del producto..." autocomplete="off">
                    <ul id="resultsList" class="results-list"></ul>
                </div>
            </div>
            @csrf
            <div class="form-group">
                <label for="name-edit">ID del Producto:</label>
                <input type="text" name="id" id="id-edit" disabled autofocus>
                @error('id-edit')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="name-edit">Nombre del Producto:</label>
                <input type="text" name="name" id="name-edit" value="{{ old('name-edit') }}" autofocus>
                @error('name-edit')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price-edit">Precio:</label>
                <input type="number" min="0" step="0.01" inputmode="numeric" name="price" id="price-edit">
                @error('price-edit')
                    <span class="error-number">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description-edit">Descripcion:</label>
                <textarea name="description" id="description-edit" cols="30" rows="2"></textarea>
                @error('description-edit')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="stock-edit">En existencia:</label>
                <input type="number" name="stock" id="stock-edit" min="0" step="1">
                @error('stock-edit')
                    <span class="error-number">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group file-style-edit">
                <label for="image_1">Imagen frontal:</label>
                <label class="labelImage" id="container-image1"></label>
                <input type="file" id="edit-image_1" name="images[1]" accept="image/png,image/jpeg,image/webp">
                @error('images.1')
                    <span class="error-file">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group file-style-edit">
                <label for="image_2">Imagen lateral:</label>
                <label class="labelImage" id="container-image2"></label>
                <input type="file" id="edit-image_2" name="images[2]" accept="image/png,image/jpeg,image/webp">
                @error('images.2')
                    <span class="error-file">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group file-style-edit">
                <label for="image_3">Imagen trasera:</label>
                <label class="labelImage" id="container-image3"></label>
                <input type="file" id="edit-image_3" name="images[3]" accept="image/png,image/jpeg,image/webp">
                @error('images.3')
                    <span class="error-file">{{ $message }}</span>
                @enderror
            </div>

            @error('images')
                <span class="error-file">{{ $message }}</span>
            @enderror

            <button type="submit" onclick="cleanUpForm()" class="btn btn-save">Guardar Cambios</button>
            <button type="button" class="btn btn-delete">Eliminar</button>
        </form>
    </div>
</main>