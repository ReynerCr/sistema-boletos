<?php
//archivo para eliminar un boleto

//revisar rol de usuario
include("../../../includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "admin.php")
{
    header("location: ../../../index.php");
    die();
}

//si no existe un id en GET
if (isset($_GET["id"]))
{
    include("../../../database/db.php");
    $id = $_GET["id"];
    $sql = "DELETE FROM boletos WHERE id = '$id'";
    if (!mysqli_query($conn, $sql))
    {
        die("Fallo la consulta.");
    }

    $_SESSION["MENSAJE"] = "Boleto eliminado satisfactoriamente";
}
header("Location: ../../admin.php");
die();

?>