<!DOCTYPE html>
<html lang="en">
<head>
    <title>Email Template</title>
    <style>
    </style>
</head>
<body>
<header>
    <h1>Welcome to Our Service!</h1>
</header>

<main>
    {{ $body }}
</main>

<footer>
    <p>&copy; {{ date('Y') }} Your Company.</p>
</footer>
</body>
</html>
