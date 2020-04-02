<?php
//archivo que imprime mensaje desde SESSION y pinta segun lo almacenado alli

if(session_status() != PHP_SESSION_ACTIVE)
{
    session_start();
}

if (isset($_SESSION["MENSAJE"]))
{
    if (!isset($_SESSION["STYLE"]))
    {
        $_SESSION["STYLE"] = "informacion";
    }
    ?>
    
    <div class="mensaje <?= $_SESSION["STYLE"] ?>">
        <span class="centrado"><p><?= $_SESSION["MENSAJE"] ?></p></span>
    </div>

    <?php
    //luego de imprimir el mensaje 1 vez se borra
    unset($_SESSION["MENSAJE"]);
    unset($_SESSION["STYLE"]);
}

?>