<?php
//archivo que actualiza los detalles de un boleto

//revisar rol de usuario
include("../../../includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "admin.php")
{
    header("location: ../../../index.php");
    die();
}

//si no se ingreso desde actualizar boleto
if (!isset($_POST['actualizar_boleto']))
{
    header("Location: ../../admin.php");
    die();
}

include("../../../database/db.php");
$serial = $_POST['serial'];
$evento_id = $_POST['id_evento'];
$ubicacion_id = $_POST['ubicacion'];
$boleto_id = $_POST['id_boleto'];

/* Busqueda de id en tabla boletos donde serial y evento_id sean iguales
    para evitar que existan boletos repetidos */
$sql = "SELECT ubicacion_id FROM boletos
WHERE evento_id = '$evento_id' AND serial = '$serial' AND NOT id = '$boleto_id'";
$resultado = mysqli_query($conn, $sql);
if(!$resultado) //si falla
{
    die("Fallo algo: " . $conn->connect_error);
}
if (mysqli_num_rows($resultado) > 0) //serial para el mismo evento NO es unico
{
    $_SESSION['MENSAJE'] = "El serial del boleto actualizado ya existe.";
    $_SESSION["STYLE"] = "error";
    header("location: editar_boleto.php?id_boleto=" . $boleto_id . "&id_evento=" . $evento_id);
    die();
}

/* Si llega hasta aqui significa que no hay serial repetido para el evento
por lo que se procede a acomodar ubicaciones disponibles */

//SE ACTUALIZA EL EVENTO AL QUE ANTES SE HABIA ASIGNADO EL BOLETO PARA SUMAR 1 EN CANTIDAD DE LA UBICACION
//obtener info del boleto antes de editar
$sql = "SELECT ubicacion_id, evento_id FROM boletos
WHERE id = '$boleto_id'";
$resultado = mysqli_query($conn, $sql);
if(!$resultado) //si falla
{
    die("Fallo algo: " . $conn->connect_error);
}
$fila = mysqli_fetch_array($resultado);
$ubicacion = "cantidad_" . $fila[0];
$evento_id_viejo = $fila[1];

//nueva consulta para obtener cantidad de la ubicacion del boleto antes de editar
$sql = "SELECT $ubicacion FROM eventos
WHERE id = '$evento_id_viejo'";
$resultado = mysqli_query($conn, $sql);
if (!$resultado) //si falla
{
    die("Fallo algo SI: " . $conn->connect_error);
}
$fila = mysqli_fetch_array($resultado);
$cantidad = $fila[0] + 1;

//aqui actualizo el nuevo valor de cantidad
$sql = "UPDATE eventos
set $ubicacion = '$cantidad'
WHERE id = '$evento_id_viejo'";
if (!mysqli_query($conn, $sql)) //si falla
{
    die("Fallo algo NO: " . $conn->connect_error);
}

//AHORA SI TOCA EL NUEVO EVENTO
$ubicacion = "cantidad_" . $ubicacion_id;
$sql = "SELECT $ubicacion FROM eventos
WHERE id = '$evento_id'";
$resultado = mysqli_query($conn, $sql);
if (!$resultado) //si falla
{
    die("Fallo algo SI: " . $conn->connect_error);
}
$fila = mysqli_fetch_array($resultado);
$cantidad = $fila[0] - 1;

//consulta para actualizar
$sql = "UPDATE eventos
set $ubicacion = '$cantidad'
WHERE id = '$evento_id'";
if (!mysqli_query($conn, $sql)) //si falla
{
    die("Fallo algo NO: " . $conn->connect_error);
}

//se procede a actualizar el boleto en la base de datos
$sql = "UPDATE boletos
    set serial = '$serial', evento_id = '$evento_id', ubicacion_id = '$ubicacion_id'
    WHERE id = '$boleto_id'";
if(!mysqli_query($conn, $sql)) //si falla
{
    die("Fallo algo: " . $conn->connect_error);
}

$_SESSION['MENSAJE'] = "Boleto actualizado satisfactoriamente.";
$_SESSION["STYLE"] = "correcto";
header("Location: ../../admin.php");
die();