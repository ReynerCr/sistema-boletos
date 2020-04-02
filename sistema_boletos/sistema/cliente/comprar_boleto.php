<?php
//pagina donde se registra un boleto para cliente

//revisar rol de usuario
include("../../includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "cliente.php")
{
    header("location: ../../index.php");
    die();
}

$title = "Comprar boleto";
$extraHeaders = '<link rel="stylesheet" type="text/css" href="../../styles/style.css">';
include("../../includes/header.php");
include("../../includes/head.php");
include("../../database/db.php");
?>

<!-- Para que sea mucho mas comodo (y para que funcione), es necesario
    activar JavaScript; asi el usuario se ahorra el tener que recibir errores en cuanto a la
    disponibilidad de un boleto para la ubicacion que se seleccione -->
<noscript>
    <h1 class="centered mensaje error">
        Para comprar un boleto es <strong>necesario</strong> tener activado JavaScript.
    </h1>    
</noscript>

<div class="bloque-contenido">
    <h3 class="title"><?= $title ?></h3>

    <?php
    //si en GET existe un id_evento que sera seleccionado en la lista y deshabilitado
    if (isset($_GET["id_evento"]))
    {
        $id_evento = $_GET["id_evento"];
        $sql = "SELECT * FROM eventos WHERE id = '$id_evento'";
    }
    //si no, se seleccionan todos para que el usuario escoja un evento y compruebe
    else
    {
        $sql = "SELECT id, nombre, fecha FROM eventos";
    }
    
    $eventos = mysqli_query($conn, $sql);
    if(!$eventos) //si falla
    {
        die("Fallo algo con la base de datos." . $conn->connect_error);
    }
    //si existen eventos registrados
    if (mysqli_num_rows($eventos) > 0)
    {
    ?>
        <form class="vertical" action="registrar_boleto.php" method="post">
            <label for="id_evento">Evento</label>
            <select <?= (isset($_GET["id_evento"]) ? 'disabled':'') ?> name="id_evento" id="id_evento" required>
                <option value="" disabled selected ?>Nombre - Fecha</option>
                
                <?php
                if (!isset($_GET["id_evento"]))
                {
                    while ($filaE = mysqli_fetch_array($eventos))
                    {
                    ?>
                        <option value="<?= $filaE[0] ?>"> <?= $filaE[1] . " - " . $filaE[2] ?> </option>
                    <?php
                    }
                }//if
                else //no quiero que danye filaE para no volver a hacer la consulta
                {
                    $filaE = mysqli_fetch_array($eventos);
                    ?>

                    <option value="<?= $filaE[0] ?>" disabled selected> <?= $filaE[1] . " - " . $filaE[2] ?> </option>
                    
                    <?php
                }//else
                ?>
            </select>
            <button type="button" id="evaluar" disabled> <?=(isset($_GET["id_evento"]) ? 'Revisar otro evento':'Revisar disponibilidad de cupos')?> </button>
            <br>
            
            <?php
                /* si existe id_evento en GET y es igual a la fila seleccionada hace visible
                   el recuadro para seleciconar los demas datos y enviar */
                if(isset($_GET["id_evento"]) && $_GET["id_evento"] == $filaE[0])
                {
                    ?>
                    <input type="hidden" id="id_evento" name="id_evento" value="<?= $filaE[0] ?>"/>
                    <label for="ubicacion">Ubicacion</label>
                    <select name="ubicacion" id="ubicacion" required>
                        <option disabled selected>Seleccione</option>
                        <?php
                        $ubicaciones = mysqli_query($conn, "SELECT * FROM ubicaciones");
                        if(!$ubicaciones) //si falla
                        {
                            die("Fallo algo con la base de datos." . $conn->connect_error);
                        }
                        //crear opciones para las ubicaciones disponibles segun lo que se obtenga de la base de datos
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
                    <input type="submit" class="enviar" id="registrar_boleto" name="registrar_boleto" value="Enviar" disabled>
                <?php
                }//if existe GET id_evento
            ?>
        </form>
        <?php
    }//if existe al menos 1 evento
    else
    { ?>
        <p class="centrado">Lo sentimos, no hay eventos disponibles.</p>
      <?php
    }//if no existen eventos
    
    include("../../includes/mensaje.php");
    ?>
</div> <!-- comprar boleto -->

<div class="bloque-contenido">
    <div class="centrado">
        <a href="../cliente.php">Volver</a>
    </div>
</div>

<!-- script NECESARIO -->
<script type="application/javascript" src="seleccion.js"></script>

<?php include("../../includes/footer.php") ?>