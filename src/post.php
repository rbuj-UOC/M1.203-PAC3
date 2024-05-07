<?php
if (!session_id()) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="shortcut icon" href="libro-de-cocina.png" type="image/png">
  <title>Receta</title>
</head>

<body>
  <?php
  require 'vars.php';
  require 'common.php';

  echo '<header class="contenido">';
  show_nav_menu();
  echo '</header>';

  echo '<main class="contenido">';

  //realizar la conexión
  $conn = new mysqli($host, $user, $password, $dbname);
  if ($conn->connect_error) {
    die("No se ha podido realizar la conexión. ERROR: " . $conn->connect_error);
  }
  $conn->set_charset("utf8");

  //consulta
  if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_receta = $_GET['id'];
  } else {
    $id_receta = 1;
  }

  $instruction = "select imagen_receta, UNIX_TIMESTAMP(fecha_publicacion) as dt, tiempo_preparacion, nombre_receta, texto_receta, id_categoria, id_nivel_dificultad from recetas_pec3 where id_receta='" . $id_receta . "'";
  $res = $conn->query($instruction);
  if ($res->num_rows != 1) {
    die("No se ha podido realizar la consulta.");
  }
  $fila = $res->fetch_assoc();
  $imagen_receta = $fila['imagen_receta'];
  $dt = $fila['dt'];
  $tiempo_preparacion = $fila['tiempo_preparacion'];
  $nombre_receta = $fila['nombre_receta'];
  $texto_receta = $fila['texto_receta'];
  $id_categoria = $fila['id_categoria'];
  $id_nivel_dificultad = $fila['id_nivel_dificultad'];
  $nombre_categoria = get_categoria($conn, $id_categoria);
  $nombre_nivel_dificultad = get_nivel_dificultad($conn, $id_nivel_dificultad);

  //lista_ingredientes
  $lista_ingredientes = array();
  $instruction = "select t1.nombre_ingrediente as ingrediente from ingredientes_pec3 as t1 inner join ingredientes_receta_pec3 t2 on (t1.id_ingrediente = t2.id_ingrediente) where t2.id_receta='" . $id_receta . "'  order by ingrediente asc";
  $res = $conn->query($instruction);
  if ($res->num_rows == 0) {
    die("No se ha podido realizar la consulta.");
  }
  $fila = $res->fetch_assoc();
  while ($fila != null) {
    array_push($lista_ingredientes, $fila['ingrediente']);
    $fila = $res->fetch_assoc();
  }

  date_default_timezone_set('Europe/Madrid');

  //html
  echo '<div id="post"><h1>' . $nombre_receta . '</h1>
  <img src=".' . $imagen_receta . '" alt="imagen de la receta" width="400px">
  <div class="receta_contenido">
  <div class="fecha_receta">Fecha publicación: ' . date('d\/m\/Y', $dt) . '</div>
  <div>Categoría: ' . $nombre_categoria . '</div>
  <div>Dificultad: ' . $nombre_nivel_dificultad . '</div>
  <div>Tiempo de preparación: ' . $tiempo_preparacion . ' min.</div>
  <h2>Ingredientes</h2>
  <ul>';
  foreach ($lista_ingredientes as $ingrediente) {
    echo '<li>' . $ingrediente . '</li>';
  }
  echo '</ul>
<h2>Instrucciones</h2>
' . $texto_receta . '
</div></div>';

  echo '</main>';
  //cerrar conexión mysql
  $conn->close();
  ?>

  <footer class="contenido">
    <p>
      © 2024 Robert Buj. <a href="https://www.flaticon.es/iconos-gratis/receta" target="_blank" rel="noopener noreferrer" title="receta iconos">Receta iconos creados por justicon - Flaticon</a>.
    </p>
  </footer>

</body>

</html>