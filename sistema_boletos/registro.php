<?php 
//pagina par registrar un usuario

//revisar rol de usuario
include("includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "")
{
    header("location: sistema/" . $enlace);
    die();
}

$title = "Registro";
$extraHeaders = '<link rel="stylesheet" type="text/css" href="styles/style.css">';
include("includes/header.php");
include("includes/head.php");

?>

<div>
    <?php include("includes/mensaje.php"); ?>

    <h2 class="title">Registro</h2>
    <div class="bloque-contenido">
        
        <form class="vertical" action="database/registrar_usuario.php" method="POST">
            <label for="nombres">Nombres</label>
            <input type="text" name="nombres" placeholder="Ingrese nombres" required>

            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" placeholder="Ingrese apellidos" required>

            <div class="cedula">
                <p>Cédula</p>
                <select name="nacionalidad">
                    <option value="V">V.-</option>
                    <option value="E">E.-</option>
                </select>
                <input type="number" name="cedula" placeholder="Número de cédula" required  min="1">
            </div>

            <label for="direccion">Dirección</label>
            <textarea rows="3" cols="20" name="direccion" placeholder="Ingrese una dirección" required></textarea>

            <label for="sexo">Sexo</label>
            <select name="sexo">
                <option value="" disabled selected>Seleccione</option>
                <option value="f">Femenino</option>
                <option value="m">Masculino</option>
            </select>

            <label for="telefono">Teléfono de contacto</label>
            <input type="tel" name="telefono" placeholder="1234 5678910" pattern="[0-9]{11}" required>

            <label for="correo">Correo electrónico</label>
            <input type="email" name="correo" placeholder="correo@ejemplo.com" required>

            <label for="usuario">Nombre de usuario</label>
            <input type="text" name="usuario" placeholder="Nombre de usuario" required>

            <label for="password">Contraseña</label>
            <input type="password" name="password" placeholder="Ingrese su contraseña" required>

            <input type="submit" class="enviar" name="registrar_usuario" value="Enviar">
        </form>
        <span>¿Ya posees una cuenta? ¡Inicia sesión <a href="inicio_sesion.php">aquí</a>!</span>
    </div>
</div>

<?php include("includes/footer.php"); ?>