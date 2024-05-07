<?php
require 'vars.php';

if (!session_id()) {
  session_start();
}

if (!(isset($_SESSION['username']))) {
  header("Refresh: 0; url=index.php");
}

// Si se ha enviado el formulario y establecido los campos
if (isset($_POST['update'])) {
  if (isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['name']) && isset($_POST['surname'])) {
    $username = $_SESSION['username'];
    $password1 = $_POST['password'];
    $password2 = $_POST['password2'];
    $nombre = $_POST['name'];
    $apellidos = $_POST['surname'];
    if (($password1 != "") && ($password1 != $password2)) {
      $_SESSION['error-msg'] = 'Error: Passwords don`t match';
      goto end;
    }
    try {
      $dbh = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $password);

      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $q = "select * from users_pec3 where username = :username";
      $sth = $dbh->prepare($q);
      $sth->bindParam(':username', $username);
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);

      $_SESSION['status-msg'] = "";

      if ($password1 != "") {
        $password1 = password_hash($password1, PASSWORD_BCRYPT);
        $q = "UPDATE users_pec3 SET password = :password WHERE username = :username";
        $sth = $dbh->prepare($q);
        $sth->bindParam(':username', $username);
        $sth->bindParam(':password', $password1);
        $sth->execute();
        $_SESSION['status-msg'] = $_SESSION['status-msg'] . 'Password updated. ';
      }

      if ($nombre != $result['nombre']) {
        if (is_string($nombre) && strlen($nombre) > 45) {
          throw new Exception('Error: Bad or malformed request');
        }
        $q = "UPDATE users_pec3 SET nombre = :nombre WHERE username = :username";
        $sth = $dbh->prepare($q);
        $sth->bindParam(':username', $username);
        $sth->bindParam(':nombre', $nombre);
        $sth->execute();
        $_SESSION['status-msg'] = 'User name updated. ';
      }

      if ($apellidos != $result['apellidos']) {
        if (is_string($apellidos) && strlen($apellidos) > 45) {
          throw new Exception('Error: Bad or malformed request');
        }
        $q = "UPDATE users_pec3 SET apellidos = :apellidos WHERE username = :username";
        $sth = $dbh->prepare($q);
        $sth->bindParam(':username', $username);
        $sth->bindParam(':apellidos', $apellidos);
        $_SESSION['status-msg'] = $_SESSION['status-msg'] . 'User surname updated. ';
        $sth->execute();
      }

      //Close the connection to the database.
      $dbh = null;
    } catch (PDOException $e) {
      http_response_code(500);
      $_SESSION['error-msg'] = 'Error: Failed to connect with database';
    } catch (Exception $e) {
      $_SESSION['error-msg'] = $e->getMessage();
    }
    end:
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
  <title>Edición del usuario</title>
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
      if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        try {
          $dbh = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $password);

          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $q = "select * from users_pec3 where username = :username";
          $sth = $dbh->prepare($q);
          $sth->bindParam(':username', $username);
          $sth->execute();
          $result = $sth->fetch(PDO::FETCH_ASSOC);

          //Close the connection to the database.
          $dbh = null;
        } catch (PDOException $e) {
          http_response_code(500);
          $_SESSION['error-msg'] = 'Error: Failed to connect with database';
        }
        echo '<h1>Edición del usuario</h1>
      <form method="post" action="" name="update-form">
        <div class="form-element">
          <label for="name">Nombre</label>
          <input type="text" name="name" maxlength="45" value="' . $result['nombre'] . '" />
        </div>
        <div class="form-element">
          <label for="surname">Apellidos</label>
          <input type="text" name="surname" maxlength="45" value="' . $result['apellidos'] . '" />
        </div>
        <div class="form-element">
          <label for="password">Nueva contraseña</label>
          <input type="password" name="password" />
        </div>
        <div class="form-element">
          <label for="password2">Repetir nueva contraseña</label>
          <input type="password" name="password2" />
        </div>
        <input type="submit" name="update" value="Update" />
      </form>';
        if (isset($_SESSION['error-msg'])) {
          echo '<p class="error-message">' . $_SESSION['error-msg'] . '</p>';
          unset($_SESSION['error-msg']);
        }
        if (isset($_SESSION['status-msg'])) {
          echo '<p class="status-message">' . $_SESSION['status-msg'] . '</p>';
          unset($_SESSION['status-msg']);
        }
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