<?php
    //Configuración de la base de datos
    $host = "localhost";
    $database = "login_proyecto";
    $user = "root";
    $password = "";
    
    //Crear la conexión
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
        
        //Configurar el modo de error de PDO a excepción
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        die("¡Error! No se pudo conectar a la base de datos: " . $e->getMessage());
        // Si la conexión falla, "morir" y mostrar el error.
    }
?>