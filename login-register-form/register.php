<?php

session_start();
include 'conexion.php'; // Ahora esto nos da la variable $pdo
    
//Validar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido']; // Usamos 'apellido' (singular)
    $telefono = $_POST['telefono'];
    $contrasena_original = $_POST['contrasena']; // Guardamos la contraseña original

    $errors = [];

    // --- VALIDACIONES ---

    //Validar que los campos no estén vacíos
    if (empty($nombre) || empty($apellido) || empty($telefono) || empty($contrasena_original)) {
        $errors[] = "Todos los campos son obligatorios.";
    }

    //Validar nombre y apellidos (Solo letras y espacios)
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $nombre)) {
        $errors[] = "El nombre solo puede contener letras.";
    }
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $apellido)) { // <--- CORREGIDO a $apellido
        $errors[] = "Los apellidos solo pueden contener letras.";
    }   

    //Validar teléfono (10 dígitos)
    if (!preg_match("/^[0-9]{10}$/", $telefono)) {
        $errors[] = "El teléfono debe tener 10 dígitos numéricos.";
    }

    //Validar Contraseña ORIGINAL
    if (strlen($contrasena_original) < 8) { // <--- CORREGIDO a $contrasena_original
        $errors[] = "La contraseña debe tener al menos 8 caracteres.";
    }

    if (empty($errors)) { 
        // --- PREPARED STATEMENT ---
        $sql_check = "SELECT id FROM usuarios WHERE telefono = ?";
        $stmt_check = $pdo->prepare($sql_check); // <--- Esto ya funciona
        $stmt_check->execute([$telefono]);

        if ($stmt_check->rowCount() > 0) {
            $errors[] = "Este número de teléfono ya está registrado.";
        }
    }

    // --- VALIDACIONES FINALES ---

    if (empty($errors)) {
        //No hubo errores
        
        // Hashear la contraseña UNA SOLA VEZ, antes de guardar.
        $contrasena_hash = password_hash($contrasena_original, PASSWORD_DEFAULT);

        // En register.php
        try {

            $sql_insert = "INSERT INTO usuarios (nombre, apellidos, telefono, password) 
                        VALUES (?, ?, ?, ?)";

            $stmt_insert = $pdo->prepare($sql_insert);
            $stmt_insert->execute([$nombre, $apellido, $telefono, $contrasena_hash]);

            // ¡ESTA ES LA LÓGICA CORRECTA!
            // NO iniciamos sesión, solo mandamos al login
            header('Location: index.php?status=registered');
            exit; 

        } catch (PDOException $e) {
            $errors[] = "Error al registrar el usuario: " . $e->getMessage();
        }
    } 
    
    if (!empty($errors)) {
        $_SESSION['register_errors'] = $errors;
        header('Location: index.php?form=signup');
        exit;
    }

} else {
    header('Location: index.php');
    exit;
}
?>