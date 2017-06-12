<!DOCTYPE html>
<html>
<head>
    <title>Activación de cuenta</title>
</head>
<body>
    <h1>Activar tu cuenta</h1>
    <p>Hola, {{ $username }}</p>

    <p>Confirmamos la creación de tu cuenta, pero debe ser activada antes de usarse.</p>
    <p>Haz clic en siguiente el link para activar tu cuenta.</p>

    <p><a href="{{ route('getActivate', $code) }}">Activar tu cuenta</a></p>

    <p>Admin.</p>
</body>
</html>