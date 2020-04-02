<?php
//pagina compartida por registrar y editar un evento

//revisar rol de usuario
include("../../../includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "admin.php")
{
    header("location: ../../../index.php");
    die();
}

//si no existe la variable que indica que tipo de funcion va a realizar la pagina
if (isset($_GET["func"])) {
    $func = $_GET["func"];
    if ($func != 1 && ($func != 2 || !isset($_GET["id"]) )) //no puede ser un valor distinto
    {
        header("location: ../../admin.php");
        die();
    }
}
else
{
    header("location: ../../admin.php");
    die();
}

$title = ($func == 1 ? "Registrar":"Editar") . " evento";
$extraHeaders = '<link rel="stylesheet" type="text/css" href="../../../styles/style.css">';
include("../../../includes/header.php");
include("../../../includes/head.php");
include("../../../database/db.php");

?>

<div class="bloque-contenido">
    <h3 class="title"><?= ($func == 1 ? 'Registrar':'Editar') ?> evento</h3>

    <form class="vertical" action="<?= ($func == 1 ? 'registrar':'editar')?>_evento.php" method="post">

        <?php
            //esto es para editar
            if ($func == 2)
            {
                $id = $_GET["id"];
                $resultado = mysqli_query($conn, "SELECT * FROM eventos WHERE eventos.id = '$id'");
                if(!$resultado) //si falla
                {
                    die("Fallo algo con la base de datos." . $conn->connect_error);
                }
                $fila = mysqli_fetch_array($resultado);
                //si no existe el evento a editar entonces se devuelve
                if (mysqli_num_rows($resultado) != 1)
                {
                    header("location: ../../admin.php");
                    die();
                }
                ?>
                <input type="hidden" id="id_evento" name="id_evento" value="<?= $id ?>">
                <?php
            } ?>

        <label for="nombre_evento">Nombre del evento</label>
        <input type="text" placeholder="Nombre evento" id="nombre_evento" name="nombre_evento" required value="<?= ($func == 1 ? '':$fila[1]) ?>">

        <label for="fecha_evento">Fecha del evento</label>
        <input type="date" id="fecha_evento" name="fecha_evento" required value="<?= ($func == 1 ? '':$fila[2]) ?>">
        
        <label for="ubicacion_1">Altos</label>
        <input type="number" placeholder="Cantidad" id="ubicacion_1" name="ubicacion_1" required min = 0 value="<?= ($func == 1 ? '':$fila[3]) ?>">

        <label for="ubicacion_2">Medios</label>
        <input type="number" placeholder="Cantidad" id="ubicacion_2" name="ubicacion_2" required min = 0 value="<?= ($func == 1 ? '':$fila[4]) ?>">

        <label for="ubicacion_3">VIP</label>
        <input type="number" placeholder="Cantidad" id="ubicacion_3" name="ubicacion_3" required min = 0 value="<?= ($func == 1 ? '':$fila[5]) ?>">

        <label for="ubicacion_4">Platino</label>
        <input type="number" placeholder="Cantidad" id="ubicacion_4" name="ubicacion_4" required min = 0 value="<?= ($func == 1 ? '':$fila[6]) ?>">

        <input type="submit" class="enviar" id="<?= ($func == 1 ? 'registrar':'editar') ?>_evento" name="<?= ($func == 1 ? 'registrar':'editar') ?>_evento" value="Enviar">
    </form>
</div> <!-- editar/registrar evento -->

<div class="bloque-contenido">
    <div class="centrado">
        <a href="../../admin.php" class="centrado">Volver</a>
    </div>
</div>

<?php include("../../../includes/footer.php") ?>