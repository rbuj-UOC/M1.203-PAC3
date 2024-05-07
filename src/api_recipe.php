<?php
require "vars.php";

header("Content-Type:application/json");

if (isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] > 0)) {
  $id = $_GET['id'];

  try {
    //realizar la conexión
    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
      throw new Exception("No se ha podido realizar la conexión. ERROR: " . $conn->connect_error);
    }
    $conn->set_charset("utf8");

    $instruction = "select * from recetas_pec3 where id_receta='" . $id . "'";
    $res = $conn->query($instruction);
    if ($res == false) {
      throw new Exception("No se ha podido realizar la consulta.");
    }
    $fila = $res->fetch_assoc();

    if (empty($fila)) {
      response(200, "Recipe Not Found", null);
    } else {
      response(200, "Recipe Found", $fila);
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
