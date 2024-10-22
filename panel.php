<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 w-11/12 max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c-3.313 0-6-2.686-6-6s2.687-6 6-6 6 2.686 6 6-2.687 6-6 6zm0 0c3.313 0 6 2.686 6 6v2H6v-2c0-3.314 2.687-6 6-6z" />
            </svg>
            Bienvenido al panel de administración
        </h2>
        <div class="flex justify-center space-x-4">
            <a href="controllers/paciente_controller.php?action=list" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 5.121a3 3 0 014.243 0L12 8.586l2.636-2.465a3 3 0 014.243 0l1.414 1.414a3 3 0 010 4.243L12 17.657l-6.364-6.364a3 3 0 010-4.243l1.414-1.414z" />
                </svg>
                Ver pacientes
            </a>
            <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded transition duration-200 flex items-center">
               
                Cerrar sesión
            </a>
        </div>
    </div>
</body>
</html>
