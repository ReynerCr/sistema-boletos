<?php

include("../../../includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "admin.php")
{
    header("location: ../../../index.php");
    die();
}

if (!(isset($_GET["id"])))
{
    header("location: ../../admin.php");
    die();
}

$title = "Detalles de registro de asistencia";
$extraHeaders = '<link rel="stylesheet" type="text/css" href="../../../styles/style.css">';
include("../../../includes/header.php");

include("../../../database/db.php");
$id = $_GET["id"];
$sql = "SELECT usuarios.nombres, usuarios.apellidos, usuarios.cedula, eventos.nombre, ubicaciones.ubicacion, boletos.serial, boletos.timestamp, eventos.id FROM boletos
INNER JOIN eventos
ON boletos.evento_id = eventos.id
INNER JOIN ubicaciones
ON boletos.ubicacion_id = ubicaciones.id
INNER JOIN usuarios
ON boletos.usuario_id = usuarios.id
WHERE boletos.id = '$id'";

$resultado = mysqli_query($conn, $sql);
if (!$resultado)
{
    die("Fallo la consulta.");
}
elseif (mysqli_num_rows($resultado) == 1) {
    $fila = mysqli_fetch_array($resultado);
    include("../../../includes/head.php");
    ?>
    <div id="contenido">
        <h2 class="title">Detalles de registro de asistencia</h2>
        <div class="bloque-contenido">
            <table class="centrado">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Cédula</th>
                        <th>Nombre del evento</th>
                        <th>Ubicación</th>
                        <th>Serial</th>
                        <th>Fecha y hora de registro</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $fila[0] ?></td>
                        <td><?php echo $fila[1] ?></td>
                        <td><?php echo $fila[2] ?></td>
                        <td><?php echo $fila[3] ?></td>
                        <td><?php echo $fila[4] ?></td>
                        <td><?php echo $fila[5] ?></td>
                        <td><?php echo $fila[6] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> <!-- #contenido -->

    <div class="bloque-contenido">
        <div class="centrado">
            <a href="../../admin.php" class="left">volver</a>
            <a href="editar_boleto.php?id_boleto=<?= $id . "&id_evento=" . $fila[7] ?>">editar</a>
            <a href="eliminar_boleto.php?id= <?= $id ?>" class="right">eliminar</a>
        </div>
    </div>

<?php
}//if se consiguio algo valido
else
{
    header("location: ../../admin.php");
    die();
}

include("../../../includes/footer.php");
?>