<?php
//archivo para eliminar un evento de la base de datos

//revisar rol de usuario
include("../../../includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "admin.php")
{
    header("location: ../../../index.php");
    die();
}

//si no existe id de evento
if (isset($_GET["id"]))
{
    include("../../../database/db.php");
    $id = $_GET["id"]; //id de evento
    $sql = "DELETE FROM boletos WHERE evento_id = '$id'";
    if (!mysqli_query($conn, $sql))
    {
        die("Fallo la consulta.");
    }

    $sql = "DELETE FROM eventos WHERE id = '$id'";
    if (!mysqli_query($conn, $sql))
    {
        die("Fallo la consulta.");
    }
    $_SESSION["MENSAJE"] = "Evento y boletos para ese evento eliminados satisfactoriamente.";
}

header("Location: ../../admin.php");
die();

?>