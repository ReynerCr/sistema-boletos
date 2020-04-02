<?php
//archivo para hacer el inicio de sesion revisando la base de datos

//revisar rol de usuario
include("../includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "")
{
    header("location: ../sistema/" . $enlace);
    die();
}

//si se accedio desde la pagina de inicio sesion
if (isset($_POST['iniciar_sesion']))
{
    include("db.php");
    
    //arreglar caracteres para la sentencia SQL
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']); 
    $password = mysqli_real_escape_string($conn, $_POST['password']); 

    //buscar datos de usuario
    $sql = "SELECT id, nombres, apellidos, rol_id, password FROM usuarios WHERE nombre_usuario ='$usuario'";
    $resultado = mysqli_query($conn, $sql);
    if (!$resultado)
    {
        die("Fallo la consulta.");
    }
    //si se consigue el usuario
    elseif (mysqli_num_rows($resultado) == 1)
    {
        $fila = mysqli_fetch_array($resultado);
        $passwordHash = $fila[4];
        //verificar si las contrasenyas son las mismas por el cifrado de la que esta en la base de datos
        $correcta = password_verify($password, $passwordHash);
        if ($correcta)
        {
            //guardar datos de usuario en SESSION
            $_SESSION['id_usuario'] = $fila[0];
            $_SESSION['nombres'] = $fila[1];
            $_SESSION['apellidos'] = $fila[2];
            $_SESSION['rol'] = $fila[3];
            
            //redirigir a la pagina correspondiente al tipo de usuario
            $enlace = GetLink();
            header("location: ../sistema/" . $enlace);
            die();
        }
        //si las contrasenyas no coinciden
        else
        {
            $_SESSION["MENSAJE"] = "Usuario o contraseña no válidos";
            $_SESSION["STYLE"] = "error";
            header("location: ../inicio_sesion.php");
            die();
        }
    }
    //si existen mas de 1 usuario
    else
    {
        $_SESSION["MENSAJE"] = "Usuario o contraseña no válidos";
        $_SESSION["STYLE"] = "error";
        header("location: ../inicio_sesion.php");
        die();
    }
}
//si no se ingreso desde pagina de inicio de sesion
else
{
    header("location: ../index.php");
    die();
}

?>