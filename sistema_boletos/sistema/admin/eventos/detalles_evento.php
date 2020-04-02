<?php
//archivo que muestra en una tabla los detalles de un evento

//revisar rol de usuario
include("../../../includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "admin.php")
{
    header("location: ../../../index.php");
    die();
}

//si no existe la variable GET se redirige
if (!isset($_GET["id"]))
{
    header("location: ../../admin.php");
    die();
}

$title = "Detalles de evento";
$extraHeaders = '<link rel="stylesheet" type="text/css" href="../../../styles/style.css">';
include("../../../includes/header.php");

include("../../../database/db.php");
$id = $_GET["id"];
//pedir datos a la base de datos sobre el evento
$sql = "SELECT * FROM eventos WHERE eventos.id = '$id'";
$resultado = mysqli_query($conn, $sql);
if (!$resultado)
{
    die("Fallo la consulta.");
}
elseif (mysqli_num_rows($resultado) == 1)
{
    $fila = mysqli_fetch_array($resultado);
    include("../../../includes/head.php");
    ?>
    <div id="contenido">
        <h2 class="title">Detalles de evento</h2>
        <div class="bloque-contenido">
            <table class="centrado">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Altos</th>
                        <th>Medios</th>
                        <th>VIP</th>
                        <th>Platino</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
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
    </div>

    <div class="bloque-contenido">
        <div class="centrado">
            <a href="../../admin.php" class="left">volver</a>
            <a href="formulario_evento.php?func=2&id= <?= $id ?>">editar</a>
            <a href="eliminar_evento.php?id= <?= $id ?>" class="right">eliminar</a>
        </div>
    </div>

<?php
}//elseif se consiguio algo valido
else
{
    header("location: ../../admin.php");
    die();
}

include("../../../includes/footer.php");

?>