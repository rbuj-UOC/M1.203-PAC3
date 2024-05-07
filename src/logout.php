<?php
if (!session_id()) {
    session_start();
}
if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
}
if (isset($_SESSION['nombre'])) {
    unset($_SESSION['nombre']);
}
header("Refresh:0; url=index.php");
