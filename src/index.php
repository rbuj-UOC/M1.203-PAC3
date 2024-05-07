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
  <title>Página principal</title>
</head>

<body>
  <?php
  require 'vars.php';
  require 'common.php';

  date_default_timezone_set('Europe/Madrid');

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

  echo '<div id="lista_recetas">';

  //consulta
  //el texto de receta siempre empieza con <p>, por ello se utiliza SUBSTRING(texto_receta, 4, 30) en lugar de SUBSTRING(texto_receta, 1, 30)
  $instruction = "select UNIX_TIMESTAMP(fecha_publicacion) as dt, SUBSTRING(texto_receta, 4, 30) as resumen_receta, id_receta, imagen_receta, tiempo_preparacion, nombre_receta, id_categoria, id_nivel_dificultad from recetas_pec3 order by fecha_publicacion desc limit 5";
  $recetas = $conn->query($instruction);
  if ($recetas->num_rows == 0) {
    die("No se ha podido realizar la consulta.");
  }
  $receta = $recetas->fetch_assoc();
  while ($receta != null) {
    $id_receta = $receta['id_receta'];
    $imagen_receta = $receta['imagen_receta'];
    $dt = $receta['dt'];
    $tiempo_preparacion = $receta['tiempo_preparacion'];
    $nombre_receta = $receta['nombre_receta'];
    $resumen_receta = $receta['resumen_receta'];
    $id_categoria = $receta['id_categoria'];
    $id_nivel_dificultad = $receta['id_nivel_dificultad'];
    $nombre_categoria = get_categoria($conn, $id_categoria);
    $nombre_nivel_dificultad = get_nivel_dificultad($conn, $id_nivel_dificultad);

    //html
    echo '<div class="receta_ficha">
            <h2><a href="post.php?id=' . $id_receta . '">' . $nombre_receta . '</a></h2>
            <img src=".' . $imagen_receta . '" alt="imagen de la receta">
  <div class="fecha_receta">Fecha publicación: ' . date('d\/m\/Y', $dt) . '</div>
  <div>Categoría: ' . $nombre_categoria . '</div>
  <div>Dificultad: ' . $nombre_nivel_dificultad . '</div>
  <div>Tiempo de preparación: ' . $tiempo_preparacion . ' min.</div>
  ' . strip_tags($resumen_receta) . '...
</div>';

    //siguiente receta
    $receta = $recetas->fetch_assoc();
  }

  echo '</div>'; // lista_recetas
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