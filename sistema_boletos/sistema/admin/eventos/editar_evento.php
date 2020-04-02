<?php
//archivo para editar los datos de un evento en la base de datos

//revisar rol de usuario
include("../../../includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "admin.php")
{
    header("location: ../../../index.php");
    die();
}

//si no se ingreso desde la pagina de editar un evento
if (isset($_POST['editar_evento']))
{
    include("../../../database/db.php");
    $nombre_evento = $_POST['nombre_evento'];
    $fecha_evento = $_POST['fecha_evento'];
    $ubicacion_1 = $_POST['ubicacion_1'];
    $ubicacion_2 = $_POST['ubicacion_2'];
    $ubicacion_3 = $_POST['ubicacion_3'];
    $ubicacion_4 = $_POST['ubicacion_4'];
    $id = $_POST["id_evento"];

    $sql = "UPDATE eventos
    set nombre = '$nombre_evento', fecha = '$fecha_evento', cantidad_1 = '$ubicacion_1', cantidad_2 = '$ubicacion_2', cantidad_3 = '$ubicacion_3', cantidad_4 = '$ubicacion_4'
    WHERE id = '$id'";
    
    if(!mysqli_query($conn, $sql)) //si falla
    {
        die("Fallo algo: " . $conn->connect_error);
    }
    $_SESSION["MENSAJE"] = "Evento editado satisfactoriamente.";
    $_SESSION["STYLE"] = "correcto";
}

header("Location: ../../admin.php");
die();

?>