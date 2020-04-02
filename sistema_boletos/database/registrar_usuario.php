<?php
//archivo para registrar un usuario guardando su informacion en la base de datos

//revisar rol de usuario
include("../includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "")
{
    header("location: ../sistema/" . $enlace);
    die();
}

//si se accedio desde la pagina de registro
if (isset($_POST['registrar_usuario']))
{
    include("db.php");

    $usuario = $_POST['usuario'];
    //buscar datos de usuario para revisar que no se repita nombre de usuario que en teoria deberia ser unico
    $sql = "SELECT id FROM usuarios WHERE nombre_usuario ='$usuario'";
    $resultado = mysqli_query($conn, $sql);
    if (!$resultado) //si falla
    {
        die("Fallo algo: " . $conn->connect_error);
    }
    if (mysqli_num_rows($resultado) > 0)
    {
        $_SESSION["MENSAJE"] = "Lo sentimos, ese nombre de usuario no está disponible.";
        $_SESSION["STYLE"] = "error";
        header("location: ../registro.php");
        die();
    }

    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $nacionalidad = $_POST['nacionalidad'];
    $cedula = $_POST['cedula'];
    $direccion = $_POST['direccion'];
    $sexo = $_POST['sexo'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    //insertar nuevo elemento en la base de datos y en tala de datos usuarios
    $sql = "INSERT INTO usuarios(nombres, apellidos, nacionalidad, cedula, direccion, sexo, telefono, correo, nombre_usuario, password)
    VALUES('$nombres', '$apellidos', '$nacionalidad', '$cedula', '$direccion', '$sexo', '$telefono', '$correo', '$usuario', '$passwordHash')";
    
    if (!mysqli_query($conn, $sql)) //si falla
    {
        die("Fallo algo: " . $conn->connect_error);
    }
    $_SESSION["MENSAJE"] = "Usuario registrado correctamente.";
    $_SESSION["STYLE"] = "correcto";
    header("Location: ../inicio_sesion.php");
    die();
}
//si no
else
{
    header("location: ../index.php");
    die();
}

?>