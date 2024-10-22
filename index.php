<?php
session_start();
require 'config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documento = $_POST['documento'];
    $clave = $_POST['clave'];

    // Ejecutar la consulta para obtener el usuario por documento
    $stmt = $pdo->prepare('SELECT * FROM users WHERE documento = ?');
    $stmt->execute([$documento]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica si el usuario existe y si la contraseña es correcta (sin hashear)
    if ($user && $clave === $user['clave']) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: panel.php');
        exit;
    } else {
        $error = 'Documento o clave incorrectos';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 w-96">
        <h2 class="text-2xl font-bold text-center mb-6">Iniciar Sesión</h2>
        <?php if (!empty($error)) { echo '<p class="text-red-500 text-sm text-center mb-4">' . $error . '</p>'; } ?>
        <form method="POST">
            <div class="mb-4">
                <label for="documento" class="block text-sm font-medium text-gray-700">Documento:</label>
                <input type="text" name="documento" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            <div class="mb-4 relative">
                <label for="clave" class="block text-sm font-medium text-gray-700">Clave:</label>
                <input type="password" name="clave" id="clave" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer eye-icon" id="togglePassword" style="top: 50%; transform: translateY(-50%);">
                    <!-- Ícono de ojo minimalista -->
                    <svg class="h-5 w-5 text-gray-500" id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5c-7.5 0-10.5 7.5-10.5 7.5S4.5 19.5 12 19.5 22.5 12 22.5 12s-3-7.5-10.5-7.5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                    </svg>
                </span>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-md">Iniciar Sesión</button>
        </form>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('clave');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function () {
            // Alternar el tipo de input entre 'password' y 'text'
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            // Alternar el icono de ojo
            if (type === 'password') {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5c-7.5 0-10.5 7.5-10.5 7.5S4.5 19.5 12 19.5 22.5 12 22.5 12s-3-7.5-10.5-7.5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                `;
            } else {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3C6 3 2 12 2 12s4 9 10 9 10-9 10-9-4-9-10-9z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                `;
            }
        });
    </script>
</body>
</html>
