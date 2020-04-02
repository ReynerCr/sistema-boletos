<?php
//archivo para registrar un evento en la base de datos

//revisar rol de usuario
include("../../../includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "admin.php")
{
    header("location: ../../../index.php");
    die();
}

//si no se ingreso desde la pagina de registrar evento
if (isset($_POST['registrar_evento']))
{
    include("../../../database/db.php");
    $nombre_evento = $_POST['nombre_evento'];
    $fecha_evento = $_POST['fecha_evento'];
    $ubicacion_1 = $_POST['ubicacion_1'];
    $ubicacion_2 = $_POST['ubicacion_2'];
    $ubicacion_3 = $_POST['ubicacion_3'];
    $ubicacion_4 = $_POST['ubicacion_4'];

    $sql = "INSERT INTO eventos(nombre, fecha, cantidad_1, cantidad_2, cantidad_3, cantidad_4)
    VALUES('$nombre_evento', '$fecha_evento', '$ubicacion_1', '$ubicacion_2', '$ubicacion_3', '$ubicacion_4')";
    
    if(!mysqli_query($conn, $sql)) //si falla
    {
        die("Fallo algo: " . $conn->connect_error);
    }
    $_SESSION["MENSAJE"] = "Evento registrado satisfactoriamente.";
    $_SESSION["STYLE"] = "correcto";
}

header("Location: ../../admin.php");
die();

?>