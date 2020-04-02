<?php 
//pagina inicial

session_start();
$title = "Venta de boletos";
$extraHeaders = '<link rel="stylesheet" type="text/css" href="styles/style.css">';
include("includes/header.php");
include("includes/head.php");

?>

<div>
    <?php
        //si un usuario ya inicio sesion
        if(!isset($_SESSION["id_usuario"]))
        {?>
            <div class="bloque-contenido">
                <p>Para poder comprar un boleto primero <a href="inicio_sesion.php">inicia sesión</a> o <a href="registro.php">regístrate</a>, ¡es gratis!</p>
            </div>
        <?php
        }
        //si no
        else
        {?>
            <div class="bloque-contenido centrado">
                <p>Bienvenido <?php echo $_SESSION['nombres'] . " " . $_SESSION['apellidos']; ?>.</p>
                <div>
                    <?php 
                        //se revisa rol para saber a donde va a redirigir
                        include("includes/rol_check.php");
                        $enlace = GetLink();
                    ?>
                    <a href="sistema/<?= $enlace ?>" class="left">Acceder al sistema</a>
                    <a href="database/cerrar_sesion.php" class="right">Cerrar sesión</a>
                </div>
            </div>
        <?php
        }
    ?>
</div>

<?php include("includes/footer.php"); ?>