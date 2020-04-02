<?php declare(strict_types=1);
/* archivo que se incluye en practicamente cada archivo .php, y que tiene una funcion para
//revisar que rol tiene ese usuario para permitirle ver esa pagina o redirigirlo a otra */

if(session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

/* funcion que revisa la variable $_SESSION['rol] y dependiendo de su valor devuelve el tipo de usuario que es en forma de enlace a la pagina principal de ese tipo de usuario */
function GetLink() : string
{
    $enlace = "";
    if (isset($_SESSION["rol"]))
    {
        switch($_SESSION["rol"])
        {
            case 1:
                $enlace = "cliente.php";
            break;

            case 2:
                $enlace = "admin.php";
            break;
        }//switch(rol)
    }//if en SESSION exista la variable rol
    return $enlace;
}//GetLink()

?>