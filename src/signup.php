<?php
require 'vars.php';

if (!session_id()) {
  session_start();
}

if (isset($_SESSION['username'])) {
  header("Refresh: 0; url=index.php");
}

// Si se ha enviado el formulario y establecido los campos
if (isset($_POST['signup'])) {
  if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['name']) && isset($_POST['surname'])) {
    $username = $_POST['username'];
    $password1 = $_POST['password'];
    $password2 = $_POST['password2'];
    $nombre = $_POST['name'];
    $apellidos = $_POST['surname'];

    try {
      if (is_string($username) && strlen($username) > 25) {
        throw new Exception('Error: Bad or malformed request');
      }
      if ($password1 != $password2) {
        throw new Exception('Error: Passwords don`t match');
      }
      if (is_string($nombre) && strlen($nombre) > 45) {
        throw new Exception('Error: Bad or malformed request');
      }
      if (is_string($apellidos) && strlen($apellidos) > 45) {
        throw new Exception('Error: Bad or malformed request');
      }

      /**
       * Setup the connection to the database This is usually called a database handle (dbh)
       */
      $dbh = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $password);

      /**
       * Use PDO::ERRMODE_EXCEPTION, to capture errors and write them to
       * a log file for later inspection instead of printing them to the screen.
       */
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      /**
       * Before executing, prepare statements by binding parameters.
       * Bind validated user input (in this case, the value of $id) to the
       * SQL statement before sending it to the database server.
       *
       * This fixes the SQL injection vulnerability.
       */
      $q = "select * from users_pec3 where username = :username";
      // Prepare the SQL query string.
      $sth = $dbh->prepare($q);
      // Bind parameters to statement variables.
      $sth->bindParam(':username', $username);
      // Execute statement.
      $sth->execute();
      // Fetch result.
      $result = $sth->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        $_SESSION['error-msg'] = 'Error: User already exits';
      } else {
        $password1 = password_hash($password1, PASSWORD_BCRYPT);
        $q = "INSERT INTO users_pec3 (username, password, nombre, apellidos) VALUES (:username, :password, :nombre, :apellidos)";
        // Prepare the SQL query string.
        $sth = $dbh->prepare($q);
        // Bind parameters to statement variables.
        $sth->bindParam(':username', $username);
        $sth->bindParam(':password', $password1);
        $sth->bindParam(':nombre', $nombre);
        $sth->bindParam(':apellidos', $apellidos);
        // Execute statement.
        $sth->execute();
        $_SESSION['username'] = $username;
      }
      //Close the connection to the database.
      $dbh = null;
    } catch (PDOException $e) {
      http_response_code(500);
      $_SESSION['error-msg'] = 'Error: Failed to connect with database';
    } catch (Exception $e) {
      $_SESSION['error-msg'] = $e->getMessage();
    }
  } else {
    http_response_code(400);
    $_SESSION['error'] = 'Error: Bad or malformed request';
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="shortcut icon" href="libro-de-cocina.png" type="image/png">
  <title>Alta de usuarios</title>
</head>

<body>
  <header class="contenido">
    <?php
    require 'common.php';
    require 'vars.php';
    show_nav_menu();
    ?>
  </header>
  <main class="contenido">
    <div id="login-content">
      <?php
      if (!(isset($_SESSION['username']))) {
        echo '<h1>Alta de usuarios</h1>
      <form method="post" action="" name="signup-form">
        <div class="form-element">
          <label for="name">Nombre</label>
          <input type="text" name="name" maxlength="45" required />
        </div>
        <div class="form-element">
          <label for="surname">Apellidos</label>
          <input type="text" name="surname" maxlength="45" required />
        </div>
        <div class="form-element">
          <label for="username">Usuario</label>
          <input type="text" name="username" maxlength="25" required />
        </div>
        <div class="form-element">
          <label for="password">Contraseña</label>
          <input type="password" name="password" required />
        </div>
        <div class="form-element">
          <label for="password2">Repetir contraseña</label>
          <input type="password" name="password2" required />
        </div>
        <input type="submit" name="signup" value="Sign Up" />
      </form>';
        if (isset($_SESSION['error-msg'])) {
          echo '<p class="error-message">' . $_SESSION['error-msg'] . '</p>';
          unset($_SESSION['error-msg']);
        }
      } else {
        echo '<h1> Bienvenido, ' . $_SESSION['username'] . '</h1>';
      }
      ?>
    </div>

  </main>

  <footer class="contenido">
    <p>
      © 2024 Robert Buj. <a href="https://www.flaticon.es/iconos-gratis/receta" target="_blank" rel="noopener noreferrer" title="receta iconos">Receta iconos creados por justicon - Flaticon</a>.
    </p>
  </footer>
</body>

</html>