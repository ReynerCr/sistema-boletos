<?php
//archivo para cerrar sesion, se borran las variables de SESSION 

if(session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['id_usuario']))
{
    session_unset();
    session_destroy();
}

header("location: ../index.php");
die();

?>