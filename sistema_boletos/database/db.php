<?php
//archivo para hacer conexion con el servidor

//variable que almacena la petición de acceso a la base de datos
$conn = new mysqli("localhost", "root", "", "sistema_boletos");
if($conn->connect_error)
{
    die("Conexión fallida: " . $conn->connect_error);
}

?>