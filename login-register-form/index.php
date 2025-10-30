<?php session_start(); ?>


<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- ===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="style.css" />
    <title>Formulario de Inicio de sesión y Registro</title>
  </head>
  <body>
    <div class="container">
      <div class="forms">
        <div class="form login">
          <span class="title">Inicio de Sesión</span>

          <form action="login.php" method="POST">
            <div class="input-field">
              <input type="tel" name="telefono" placeholder="Ingrese su numero telefónico" required />
              <i class="uil uil-phone"></i>
            </div>
            <div class="input-field">
              <input type="password" name="contrasena" class="password" placeholder="Ingrese su contraseña" required />
              <i class="uil uil-lock icon"></i>
              <i class="uil uil-eye-slash showHidePw"></i>
            </div>

            <div class="checkbox-text">
              <div class="checkbox-content">
                <input type="checkbox" id="logCheck" />
                <label for="logCheck" class="text">Recuerdame</label>
              </div>

              <a href="#" class="text">¿Olvidaste tu contraseña?</a>
            </div>

            <div class="input-field button">
              <input type="submit" value="Iniciar Sesión" />
            </div>
          </form>

          <div class="login-signup">
            <span class="text"
              >¿No eres miembro?
              <a href="#" class="text signup-link">Regístrate ahora</a>
            </span>
          </div>
        </div>


      
        <!-- Registration Form -->
        <div class="form signup">
          <span class="title">Registro</span>

          <?php
          // --- ¡PEGA ESTE CÓDIGO AQUÍ! ---
          if (isset($_SESSION['register_errors']) && !empty($_SESSION['register_errors'])) {
              echo '<div style="color: red; margin-bottom: 15px; font-size: 14px; padding: 10px; border: 1px solid red; border-radius: 5px; background: #ffebeb;">';
              foreach ($_SESSION['register_errors'] as $error) {
                  echo htmlspecialchars($error) . '<br>'; // Muestra cada error
              }
              echo '</div>';
              
              // Limpia los errores para que no se muestren de nuevo
              unset($_SESSION['register_errors']);
          }
          ?>

          <form action="register.php" method="POST">
            <div class="input-field">
              <input type="text" name="nombre" placeholder="Ingrese su nombre" required />
              <i class="uil uil-user"></i>
            </div>
            <div class="input-field">
              <input type="text" name="apellido" placeholder="Ingrese su apellido" required />
              <i class="uil uil-user"></i>
            </div>
            <div class="input-field">
              <input type="tel" name="telefono" class="phone" placeholder="Ingrese un numero de telefono" required />
              <i class="uil uil-phone icon"></i>
            </div>
            <!-- <div class="input-field">
              <input type="password" class="password" placeholder="Cree una contraseña" required />
              <i class="uil uil-lock icon"></i>
            </div> -->
            <div class="input-field">
              <input type="password" name="contrasena" class="password" placeholder="Ingrese una contraseña" required />
              <i class="uil uil-lock icon"></i>
              <i class="uil uil-eye-slash showHidePw"></i>
            </div>

            <div class="checkbox-text">
              <div class="checkbox-content">
                <input type="checkbox" id="termCon" />
                <label for="termCon" class="text">Acepto todos los términos y condiciones</label>
              </div>
            </div>

            <div class="input-field button">
              <input type="submit" value="Regístrate" />
            </div>
          </form>

          <div class="login-signup">
            <span class="text"
              >¿Ya eres miembro?
              <a href="index.php" class="text login-link">Iniciar Sesión</a>
            </span>
          </div>
        </div>
      </div>
    </div>

    <script src="script.js"></script>
  </body>
</html>
