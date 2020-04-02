<?php
//pagina principal de administrador

//revisar rol de usuario
include("../includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "admin.php")
{
    header("location: ../index.php");
    die();
}

$title = "Administrador";
$extraHeaders = '<link rel="stylesheet" type="text/css" href="../styles/style.css">';
include("../includes/header.php");

include("../includes/head.php");
include("../includes/usuario_actual.php");
include("../includes/mensaje.php"); //mensaje de aviso cuando se borro algo
include("../database/db.php");

?>

<div>
    <h2 class="title">Administración</h2>
    <div class="bloque-contenido">
        <h3 class="title">Lista de registros de asistencia</h3>
        <?php

        //sentencia SQL para unir tablas y obtener los registros bien organizados
        $sql = "SELECT usuarios.nombres, usuarios.apellidos, usuarios.cedula, eventos.nombre, ubicaciones.ubicacion, boletos.id, eventos.id
        FROM boletos
        join eventos
        ON boletos.evento_id = eventos.id
        join ubicaciones
        ON boletos.ubicacion_id = ubicaciones.id
        join usuarios
        ON boletos.usuario_id = usuarios.id";
        $resultado = mysqli_query($conn, $sql);
        if (!$resultado)
        {
            die("Fallo algo con la DB.");
        }
        //si existen registros de asistencia
        if (mysqli_num_rows($resultado) > 0) 
        {
        ?>
        <table class="centrado">
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Cédula</th>
                    <th>Nombre del evento</th>
                    <th>Ubicación</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                while ($fila = mysqli_fetch_array($resultado)) { ?>
                    <tr>
                        <td><?= $fila[0] ?></td>
                        <td><?= $fila[1] ?></td>
                        <td><?= $fila[2] ?></td>
                        <td><?= $fila[3] ?></td>
                        <td><?= $fila[4] ?></td>
                        <td>
                            <a href="admin/boletos/detalles_boleto.php?id=<?= $fila[5] ?>">
                                detalles
                            </a>
                            <a href="admin/boletos/editar_boleto.php?id_boleto=<?= $fila[5] . "&id_evento=" . $fila[6] ?>">
                                editar
                            </a>
                            <a href="admin/boletos/eliminar_boleto.php?id=<?= $fila[5] ?>">
                                eliminar
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        }
        //si no existen registros de asistencia
        else
        { ?>
            <p class="centrado">Aún no hay registros.</p>
        <?php
        }?>
    </div> <!-- lista de registros de asistencia -->

    <div class="bloque-contenido">
        <h3 class="title">Lista de registros de eventos</h3>
        
        <?php
        //seleccionar los eventos registrados
        $sql = "SELECT * FROM eventos";
        $resultado = mysqli_query($conn, $sql);
        if (!$resultado)
        {
            die("Fallo algo con la DB.");
        }
        //si existen registros de eventos
        if (mysqli_num_rows($resultado) > 0)
        {
        ?>
        <table class="centrado">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                while ($fila = mysqli_fetch_array($resultado)) { ?>
                    <tr>
                        <td><?= $fila[1] ?></td>
                        <td><?= $fila[2] ?></td>
                        <td>
                            <a href="admin/eventos/detalles_evento.php?id=<?= $fila[0] ?>">
                                detalles
                            </a>
                            <a href="admin/eventos/formulario_evento.php?func=2&id=<?= $fila[0] ?>">
                                editar
                            </a>
                            <a href="admin/eventos/eliminar_evento.php?id=<?= $fila[0] ?>">
                                eliminar
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        }
        //si no existen registros de eventos        
        else
        { ?>
            <p class="centrado">Aún no hay registros.</p>
        <?php
        }?>
    </div> <!-- lista de registros de eventos -->
    
    <a href="admin/eventos/formulario_evento.php?func=1" class="title boton centrado">Registrar un evento</a>
    <a href="admin/lista_usuarios.php" class="title boton centrado">Ver lista de usuarios</a>
    <a href="../index.php" class="title boton centrado">Volver al inicio</a>
</div>

<?php include("../includes/footer.php"); ?>