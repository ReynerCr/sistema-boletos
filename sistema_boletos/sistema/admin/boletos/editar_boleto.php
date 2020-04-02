<?php
//pagina donde se edita un boleto

//revisar rol de usuario
include("../../../includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "admin.php")
{
    header("location: ../../../index.php");
    die();
}

//si no existe un id de boleto ni un id de evento seleccionado en la lista entonces se redirige
if (!isset($_GET["id_boleto"]) || !isset($_GET["id_evento"]))
{
    header("location: ../../../admin.php");
    die();
}

$title = "Editar boleto";
$extraHeaders = '<link rel="stylesheet" type="text/css" href="../../../styles/style.css">
                 <link rel="stylesheet" type="text/css" href="../../../styles/editar_boleto.css">';
include("../../../includes/header.php");
include("../../../includes/head.php");
include("../../../database/db.php");
?>

<!-- Para que sea mucho mas comodo (y para que funcione), es necesario
    activar JavaScript; asi el usuario se ahorra el tener que recibir errores en cuanto a la
    disponibilidad de un boleto para la ubicacion que se seleccione -->
<noscript>
    <h1 class="centered mensaje error">
        Para editar un boleto es <strong>necesario</strong> tener activado JavaScript.
    </h1>    
</noscript>

<div class="bloque-contenido">
    <h3 class="title"><?= $title ?></h3>

    <?php
    $id_boleto = $_GET["id_boleto"];
    //buscar boleto que se edita
    $boletos = mysqli_query($conn, "SELECT * FROM boletos WHERE boletos.id = '$id_boleto'");
    if(!$boletos) //si falla
    {
        die("Fallo algo con la base de datos." . $conn->connect_error);
    }
    //si no existe el boleto a editar entonces se devuelve
    if (mysqli_num_rows($boletos) != 1)
    {
        header("location: ../../admin.php");
        die();
    }
    $filaB = mysqli_fetch_array($boletos);

    $id_evento = $_GET["id_evento"];
    $sql = "SELECT * FROM eventos";
    $eventos = mysqli_query($conn, $sql);
    if(!$eventos) //si falla
    {
        die("Fallo algo con la base de datos." . $conn->connect_error);
    }
    //si existen evento
    if (mysqli_num_rows($eventos) > 0)
    {
    ?>
        <form class="vertical" action="actualizar_boleto.php" method="post">
            <input type="hidden" name="id_boleto" id="id_boleto" value="<?= $id_boleto ?>">
            <label for="id_evento">Evento</label>
            <select name="id_evento" id="id_evento" required>
                <option value="" disabled selected ?>Nombre - Fecha</option>
                <?php
                    //mostrar todos los eventos con nombre y fecha, seleccionar el evento obtenido por GET
                    while ($filaF = mysqli_fetch_array($eventos))
                    {
                        if($filaF[0] == $id_evento)
                        {
                            $filaE = $filaF;
                            ?>
                            <option selected id="id_inicial" value="<?= $filaE[0] ?>"> <?= $filaE[1] . " - " . $filaE[2] ?> </option>
                        <?php
                        }
                        else
                        {
                        ?>
                            <option value="<?= $filaF[0] ?>"> <?= $filaF[1] . " - " . $filaF[2] ?> </option>
                        <?php
                        }
                    }//while
                    //si no existe el evento obtenido por GET entonces se redirige
                    if (!isset($filaE))
                    {
                        header("location: ../../admin.php");
                        die();
                    }
                ?>
            </select>
            <button type="button" id="evaluar" disabled>Revisar disponibilidad de cupos</button>
            
            <div id="desplegable">
                <label for="ubicacion">Ubicacion</label>
                <select name="ubicacion" id="ubicacion" required>
                    <option disabled selected>Seleccione</option>
                    <?php
                    $ubicaciones = mysqli_query($conn, "SELECT * FROM ubicaciones");
                    if(!$ubicaciones)
                    {
                        die("Fallo algo con la base de datos." . $conn->connect_error);
                    }
                    //mostrar las ubicaciones disponibles para el evento obtenido por GET
                    while($filaU = mysqli_fetch_array($ubicaciones))
                    {
                    ?>
                        <option <?= ($filaE[2 + $filaU[0]] > 0 ? '':'disabled') ?> value="<?=  $filaU[0] ?>"> <?= ($filaE[2 + $filaU[0]] > 0 ? $filaU[1]:'Agotados') ?> </option>
                    <?php
                    }
                    ?>
                </select>

                <label for="serial">Serial</label>
                <input type="number" placeholder="Serial" id="serial" name="serial" required min = 1>
                
                <!-- el boton de enviar se activa con JavaScript -->
                <input type="submit" class="enviar" id="actualizar_boleto" name="actualizar_boleto" value="Enviar" disabled>
            </div> <!-- #desplegable -->
        </form>
        <?php
        include("../../../includes/mensaje.php");
    }//if existe al menos 1 evento
    //si no existen eventos
    else
    { ?>
        <p class="centrado">Lo sentimos, no hay eventos disponibles.</p>
      <?php
    }//if no existen eventos
    ?>
</div> <!-- editar boleto -->

<div class="bloque-contenido">
    <div class="centrado">
        <a href="../../admin.php">Volver</a>
    </div>
</div>

<script type="application/javascript" src="seleccion.js"></script>

<?php include("../../../includes/footer.php") ?>