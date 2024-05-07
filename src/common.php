<?php

function get_categoria($conn, $id_categoria)
{
    $instruction = "select nombre_categoria from categorias_pec3 where id_categoria='" . $id_categoria . "'";
    $res = $conn->query($instruction);
    if ($res->num_rows != 1) {
        die("No se ha podido realizar la consulta.");
    }
    $fila = $res->fetch_assoc();
    return $fila['nombre_categoria'];
}

function get_nivel_dificultad($conn, $id_nivel_dificultad)
{
    $instruction = "select nombre_nivel_dificultad from nivel_dificultad_pec3 where id_nivel_dificultad='" . $id_nivel_dificultad . "'";
    $res = $conn->query($instruction);
    if ($res->num_rows != 1) {
        die("No se ha podido realizar la consulta.");
    }
    $fila = $res->fetch_assoc();
    return $fila['nombre_nivel_dificultad'];
}

function show_nav_menu()
{
    $activePage = basename($_SERVER['PHP_SELF'], ".php");
    echo '<ul>';
    $currentPage = "index";
    if ($activePage == $currentPage) {
        echo '<li><a class="active" href="' . $currentPage . '.php">Home</a></li>';
    } else {
        echo '<li><a href="' . $currentPage . '.php">Home</a></li>';
    }
    $currentPage = "activity_2";
    if ($activePage == $currentPage) {
        echo '<li><a class="active" href="' . $currentPage . '.php">Act_2</a></li>';
    } else {
        echo '<li><a href="' . $currentPage . '.php">Act_2</a></li>';
    }
    $currentPage = "recipes";
    if ($activePage == $currentPage) {
        echo '<li><a class="active" href="' . $currentPage . '.php">Recetas</a></li>';
    } else {
        echo '<li><a href="' . $currentPage . '.php">Recetas</a></li>';
    }
    echo '<li><a href="api/recipes/1" target="_blank">API_recetas</a></li>';
    echo '<li><a href="api/recipe/1" target="_blank">API_receta</a></li>';
    if (isset($_SESSION['username'])) {
        $currentPage = "logout";
        if ($activePage == $currentPage) {
            echo '<li style="float:right"><a class="active" href="' . $currentPage . '.php">Logout</a></li>';
        } else {
            echo '<li style="float:right"><a href="' . $currentPage . '.php">Logout</a></li>';
        }
        $currentPage = "edit";
        if (isset($_SESSION['nombre'])) {
            if ($activePage == $currentPage) {
                echo '<li style="float:right"><a class="active" href="' . $currentPage . '.php">¡Hola ' . $_SESSION['nombre'] . '!</a></li>';
            } else {
                echo '<li style="float:right"><a href="' . $currentPage . '.php">¡Hola ' . $_SESSION['nombre'] . '!</a></li>';
            }
        } else {
            if ($activePage == $currentPage) {
                echo '<li style="float:right"><a class="active" href="' . $currentPage . '.php">Perfil de usuario</a></li>';
            } else {
                echo '<li style="float:right"><a href="' . $currentPage . '.php">Perfil de usuario</a></li>';
            }
        }
    } else {
        $currentPage = "login";
        if ($activePage == $currentPage) {
            echo '<li style="float:right"><a class="active" href="' . $currentPage . '.php">Login</a></li>';
        } else {
            echo '<li style="float:right"><a href="' . $currentPage . '.php">Login</a></li>';
        }
        $currentPage = "signup";
        if ($activePage == $currentPage) {
            echo '<li style="float:right"><a class="active" href="' . $currentPage . '.php">Sign up</a></li>';
        } else {
            echo '<li style="float:right"><a href="' . $currentPage . '.php">Sign up</a></li>';
        }
    }
    echo '</ul>';
}
