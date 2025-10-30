<?php

session_start();
require 'conexion.php';

// Validar que se envíe por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $telefono = $_POST['telefono'];
    $contrasena = $_POST['contrasena'];
    $error = null;

    // Validar campos vacíos
    if (empty($telefono) || empty($contrasena)) {
        $error = "El teléfono y la contraseña son obligatorios.";
    } else {
        // Buscar al usuario en la BD
        // Se usa un Prepared Statement para evitar Inyección SQL
        $sql = "SELECT id, nombre, password FROM usuarios WHERE telefono = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$telefono]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe y si el hash de la contraseña coincide
        if ($user && password_verify($contrasena, $user['password'])) {

            // Guardar datos en la sesión para mantenerlo logueado
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nombre'] = $user['nombre'];
            
            // Redirigir al dashboard
            header('Location: ../index.html');
            exit;

        } else {
            // Datos incorrectos
            $error = "Teléfono o contraseña incorrectos.";
        }
    }

    // Si hubo cualquier error, guardarlo en la sesión y regresar al login
    if ($error) {
        $_SESSION['login_error'] = $error;
        header('Location: index.php');
        exit;
    }

} else {
    // Si alguien entra directo a este archivo, lo sacamos
    header('Location: index.php');
    exit;
}
?>