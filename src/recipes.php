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
  <title>Recetas</title>
</head>

<body>
  <?php
  require 'vars.php';
  require 'common.php';

  function navegacion($conn, $page, $numero_recetas, $filtro, $arguments)
  {
    $instruction = "select count(*) as total from recetas_pec3";
    if ($filtro != "") {
      $instruction = $instruction . $filtro;
    }
    $res = $conn->query($instruction);
    if ($res->num_rows == 0) {
      die("No se ha podido realizar la consulta.");
    }
    $fila = $res->fetch_assoc();
    $total = $fila['total'];

    echo '<nav id="nav-recetas"><ul>';
    for ($i = 1; $i * $numero_recetas <= $total; $i++) {
      if ($i == $page) {
        echo '<li>' . $i . '</li>';
      } else {
        echo '<li><a href="?page=' . $i . $arguments . '">' . $i . '</a></li>';
      }
    }
    echo '</ul></nav>';
  }

  function show_formulario_filtro($conn, $category, $difficulty, $order, $dir)
  {
    echo '<div id="filter"><h2>Filtro</h2><form action="recipes.php" method="get">
            <div class="field"><label for="category">Categoría:</label>
            <select name="category" id="category">
              <option value="">-- todas --</option>';
    //categoría
    $instruction = "select * from categorias_pec3 order by nombre_categoria";
    $res = $conn->query($instruction);
    if ($res->num_rows == 0) {
      die("No se ha podido realizar la consulta.");
    }
    $fila = $res->fetch_assoc();
    while ($fila != null) {
      $id_categoria = $fila['id_categoria'];
      if ($id_categoria == $category) {
        echo '<option value="' . $id_categoria . '" selected>' . $fila['nombre_categoria'] . '</option>';
      } else {
        echo '<option value="' . $id_categoria . '">' . $fila['nombre_categoria'] . '</option>';
      }
      $fila = $res->fetch_assoc();
    }
    echo '</select></div>
            <div class="field"><label for="difficulty">Nivel de dificultad:</label>
            <select name="difficulty" id="difficulty">
              <option value="">-- todas --</option>';
    //nivel dificultad
    $instruction = "select * from nivel_dificultad_pec3 order by id_nivel_dificultad";
    $res = $conn->query($instruction);
    if ($res->num_rows == 0) {
      die("No se ha podido realizar la consulta.");
    }
    $fila = $res->fetch_assoc();
    while ($fila != null) {
      $id_nivel_dificultad = $fila['id_nivel_dificultad'];
      if ($id_nivel_dificultad == $difficulty) {
        echo '<option value="' . $id_nivel_dificultad . '" selected>' . $fila['nombre_nivel_dificultad'] . '</option>';
      } else {
        echo '<option value="' . $id_nivel_dificultad . '">' . $fila['nombre_nivel_dificultad'] . '</option>';
      }
      $fila = $res->fetch_assoc();
    }
    echo '</select></div>
            <div class="field"><label for="order">Ordenar por:</label>
            <select name="order" id="order">';
    //categoría
    if ("fecha_publicacion" == $order) {
      echo '<option value="fecha_publicacion" selected>Fecha publicación</option>';
    } else {
      echo '<option value="fecha_publicacion">Fecha publicación</option>';
    }
    if ("tiempo_preparacion" == $order) {
      echo '<option value="tiempo_preparacion" selected>Tiempo preparación</option>';
    } else {
      echo '<option value="tiempo_preparacion">Tiempo preparación</option>';
    }
    if ("nombre_receta" == $order) {
      echo '<option value="nombre_receta" selected>Título</option>';
    } else {
      echo '<option value="nombre_receta">Título</option>';
    }
    echo '</select>';

    if ($dir == "asc") {
      echo '<input type="radio" id="dir1" name="dir" value="asc" checked>';
    } else {
      echo '<input type="radio" id="dir1" name="dir" value="asc">';
    }
    echo '<label for="dir1">Ascendente</label>';
    if ($dir == "desc") {
      echo '<input type="radio" id="dir2" name="dir"  value="desc" checked>';
    } else {
      echo '<input type="radio" id="dir2" name="dir"  value="desc">';
    }
    echo '<label for="dir2">Descendiente</label>
            </div>
            <input type="submit" value="Aplicar">
            </form></div>';
  }

  //variables
  if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
  } else {
    $page = 1;
  }
  if (isset($_GET['category']) && is_numeric($_GET['category'])) {
    $category = $_GET['category'];
  } else {
    $category = 0;
  }
  if (isset($_GET['difficulty']) && is_numeric($_GET['difficulty'])) {
    $difficulty = $_GET['difficulty'];
  } else {
    $difficulty = 0;
  }
  if (isset($_GET['order']) && is_string($_GET['order'])) {
    switch ($_GET['order']) {
      case "fecha_publicacion":
      case "tiempo_preparacion":
      case "nombre_receta":
        $order = $_GET['order'];
        break;
      default:
        $order = "fecha_publicacion";
    }
  } else {
    $order = "fecha_publicacion";
  }
  if (isset($_GET['dir']) && is_string($_GET['dir'])) {
    switch ($_GET['dir']) {
      case "desc":
      case "asc":
        $dir = $_GET['dir'];
        break;
      default:
        $dir = "desc";
    }
  } else {
    $dir = "desc";
  }
  $numero_recetas = 5;

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

  show_formulario_filtro($conn, $category, $difficulty, $order, $dir);
  echo '<div id="lista_recetas">';

  //consulta recetas
  //el texto de receta siempre empieza con <p>, por ello se utiliza SUBSTRING(texto_receta, 4, 30) en lugar de SUBSTRING(texto_receta, 1, 30)
  $offset = $numero_recetas * ($page - 1);
  $instruction = "select UNIX_TIMESTAMP(fecha_publicacion) as dt, SUBSTRING(texto_receta, 4, 30) as resumen_receta, id_receta, imagen_receta, tiempo_preparacion, nombre_receta, id_categoria, id_nivel_dificultad from recetas_pec3";
  $filtro = "";
  if ($category != 0) {
    $filtro = " where id_categoria='" . $category . "'";
    if ($difficulty != 0) {
      $filtro = $filtro . " and id_nivel_dificultad='" . $difficulty . "'";
    }
  } else {
    if ($difficulty != 0) {
      $filtro = " where id_nivel_dificultad='" . $difficulty . "'";
    }
  }
  $filtro = $filtro . " order by " . $order . " " . $dir;
  $instruction = $instruction . $filtro;
  $instruction = $instruction . " limit " . $numero_recetas . " offset " . $offset;
  $recetas = $conn->query($instruction);
  if ($recetas->num_rows == 0) {
    die("No hay recetas.");
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

  //navegación
  $arguments = "";
  if ($category) {
    $arguments = $arguments . "&category=" . $category;
  }
  if ($difficulty) {
    $arguments = $arguments . "&difficulty=" . $difficulty;
  }
  $arguments = $arguments . "&order=" . $order;
  $arguments = $arguments . "&dir=" . $dir;
  navegacion($conn, $page, $numero_recetas, $filtro, $arguments);

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