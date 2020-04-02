<?php
    //pagina principal de cliente

    //revisar rol de usuario
    include("../includes/rol_check.php");
    $enlace = GetLink();
    if ($enlace !== "cliente.php")
    {
        header("location: ../index.php");
        die();
    }

    $title = "Venta de boletos";
    $extraHeaders = '<link rel="stylesheet" type="text/css" href="../styles/style.css">';
    include("../includes/header.php");
    include("../includes/head.php");
    include("../includes/usuario_actual.php");
?>

<div>
    <a href="cliente/comprar_boleto.php" class="title boton centrado">Comprar un boleto</a>
    <a href="../index.php" class="title boton centrado">Volver al inicio</a>
</div>

<?php include("../includes/footer.php"); ?>