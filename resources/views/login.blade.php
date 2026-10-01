<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>
@vite(['resources/css/login.css'])

<nav class="background_auth">
    <h1 class="title_auth">Inicio de sesión</h1>
</nav>

<main class="auth-container">
    <form action="{{ route('login.perform') }}" method="POST" class="auth-form">
        @csrf

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
            @error('password')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn-submit">Iniciar Sesión</button>
    </form>
</main>