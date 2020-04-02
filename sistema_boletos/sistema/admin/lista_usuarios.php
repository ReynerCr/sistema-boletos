<?php
//pagina donde se muestran los detalles de los usuarios registrados

include("../../includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "admin.php")
{
    header("location: ../../index.php");
    die();
}

$title = "Lista de usuarios";
$extraHeaders = '<link rel="stylesheet" type="text/css" href="../../styles/style.css">';
include("../../includes/header.php");
include("../../includes/head.php");
include("../../database/db.php");

?>

<div>
    <div class="bloque-contenido">
        <h3 class="title">Lista de usuarios registrados</h3>
        <?php
        $sql = "SELECT nombres, apellidos, nacionalidad, cedula, direccion, sexo, telefono, correo FROM usuarios";
        $resultado = mysqli_query($conn, $sql);
        if (!$resultado)
        {
            die("Fallo algo con la DB.");
        }
        //si existe al menos un usuario registrado
        if (mysqli_num_rows($resultado) > 0)
        {
        ?>
        <table class="centrado">
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Nacionalidad</th>
                    <th>Cédula</th>
                    <th>Dirección</th>
                    <th>Sexo</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                while ($fila = mysqli_fetch_array($resultado)) { 
                ?>
                    <tr>
                        <td><?= $fila[0] ?></td>
                        <td><?= $fila[1] ?></td>
                        <td><?= $fila[2] ?></td>
                        <td><?= $fila[3] ?></td>
                        <td><?= $fila[4] ?></td>
                        <td><?= ($fila[5] == 'm' ? "Masculino":"Femenino") ?></td>
                        <td><?= $fila[6] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        }
        //si no
        else
        { ?>
            <p class="centrado">Aún no hay registros.</p>
        <?php
        }?>
    </div> <!-- lista de usuarios registrados -->
    
    <div class="bloque-contenido">
        <div class="centrado">
            <a href="../admin.php" class="centrado">Volver</a>
        </div>
    </div>
</div>

<?php include("../../includes/footer.php"); ?>