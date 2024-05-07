<?php
require "vars.php";

header("Content-Type:application/json");

if (isset($_GET['page']) && is_numeric($_GET['page']) && ($_GET['page'] > 0)) {
  $page = $_GET['page'];
  $numero_recetas = 10;
  $offset = $numero_recetas * ($page - 1);

  try {
    //realizar la conexión
    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
      throw new Exception("No se ha podido realizar la conexión. ERROR: " . $conn->connect_error);
    }
    $conn->set_charset("utf8");

    $instruction = "select * from recetas_pec3";
    $instruction = $instruction . " limit " . $numero_recetas . " offset " . $offset;
    $res = $conn->query($instruction);
    $files = $res->fetch_all(MYSQLI_ASSOC);

    if (empty($files)) {
      response(200, "Recipes Not Found", null);
    } else {
      response(200, "Recipes Found", $files);
    }
    $conn->close();
  } catch (Exception $e) {
    response(500, $e->getMessage(), null);
  }
} else {
  response(400, "Invalid Request", null);
}

function response($status, $status_message, $data)
{
  header("HTTP/1.1 " . $status);

  $response['status'] = $status;
  $response['status_message'] = $status_message;
  $response['data'] = $data;

  $json_response = json_encode($response);
  echo $json_response;
}
