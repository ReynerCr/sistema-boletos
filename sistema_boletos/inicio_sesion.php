<?php
//pagina para iniciar sesion

//revisar rol de usuario
include("includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "")
{
    header("location: sistema/" . $enlace);
    die();
}

$title = "Inicio de sesión";
$extraHeaders = '<link rel="stylesheet" type="text/css" href="styles/style.css">';
include("includes/header.php");
include("includes/head.php");

?>

<div>
    <h1 class="title">Inicio de sesión</h1>
    <div class="bloque-contenido">
        <form class="vertical" action="database/iniciar_sesion.php" method="POST">
            <label for="usuario">Nombre de usuario</label>
            <input type="text" name="usuario" placeholder="Ingrese nombre de usuario" required>

            <label for="password">Contraseña</label>
            <input type="password" name="password" placeholder="Ingrese su contraseña">
            
            <input type="submit" class="enviar" name="iniciar_sesion" value="Enviar">
        </form>
        <span>¿No posees una cuenta? ¡Registrate <a href="registro.php">aquí</a>!</span>
    </div>

    <?php include("includes/mensaje.php"); ?>
</div>

<?php include("includes/footer.php"); ?>