<?php

//revisar rol de usuario
include("../../includes/rol_check.php");
$enlace = GetLink();
if ($enlace !== "cliente.php")
{
    header("location: ../../index.php");
    die();
}

//si no se accedio desde registrar boleto entonces se redirige
if (!isset($_POST['registrar_boleto']))
{
    header("location: ../cliente.php");
    die();
}

include("../../database/db.php");

$usuario_id = $_SESSION["id_usuario"];
$evento_id = $_POST["id_evento"];
$ubicacion = $_POST["ubicacion"];
$serial = $_POST["serial"];

/* Busqueda de id en tabla boletos donde serial y evento_id sean iguales
    para evitar que existan boletos repetidos */
$sql = "SELECT id FROM boletos
WHERE evento_id = '$evento_id' AND serial = '$serial'";
$resultado = mysqli_query($conn, $sql);
if(!$resultado) //si falla
{
    die("Fallo algo: " . $conn->connect_error);
}
if (mysqli_num_rows($resultado) > 0) //serial para el mismo evento NO es unico
{
    $_SESSION["MENSAJE"] = "El serial del boleto registrado ya existe.";
    $_SESSION["STYLE"] = "error";
    header("location: comprar_boleto.php?id_evento=" . $evento_id);
    die();
}

/* Si llega hasta aqui significa que no hay serial repetido para el evento
por lo que se procede a registrar el boleto en la base de datos */
$sql = "INSERT INTO boletos(serial, usuario_id, evento_id, ubicacion_id)
VALUES('$serial', '$usuario_id', '$evento_id', '$ubicacion')";
if(!mysqli_query($conn, $sql)) //si falla
{
    die("Fallo algo: " . $conn->connect_error);
}

$ubicacion = "cantidad_" . $ubicacion; //reutilizo var
$sql = "SELECT $ubicacion FROM eventos
WHERE id = '$evento_id'";
$resultado = mysqli_query($conn, $sql);
if (!$resultado)
{
    die("Fallo algo: " . $conn->connect_error);
}
$fila = mysqli_fetch_array($resultado);
$cantidad = $fila[0] - 1;

$sql = "UPDATE eventos
set $ubicacion = '$cantidad'
WHERE id = '$evento_id'";
if (!mysqli_query($conn, $sql))
{
    die("Fallo algo: " . $conn->connect_error);
}

//Para mostrar los datos del boleto se hace inner join en boletos con usuarios, eventos y ubicaciones
$sql = "SELECT usuarios.nombres, usuarios.apellidos, usuarios.cedula, eventos.nombre, ubicaciones.ubicacion, boletos.timestamp FROM boletos
INNER JOIN eventos
ON boletos.evento_id = eventos.id
INNER JOIN ubicaciones
ON boletos.ubicacion_id = ubicaciones.id
INNER JOIN usuarios
ON boletos.usuario_id = usuarios.id
WHERE boletos.evento_id = '$evento_id' AND boletos.serial = '$serial'";

$resultado = mysqli_query($conn, $sql);
if (!$resultado)
{
    die("Fallo la consulta.");
}

//por si acaso se revisa, pero deberia ser 1 solo resultado
elseif (mysqli_num_rows($resultado) == 1)
{
    //se muestran los detalles de la compra al cliente
    $title = "Detalles de la compra";
    $extraHeaders = '<link rel="stylesheet" type="text/css" href="../../styles/style.css">';
    include("../../includes/header.php");
    $fila = mysqli_fetch_array($resultado);
    include("../../includes/head.php");
    ?>
    <div >
        <p class="centrado">Gracias por su compra</p>
        <h2 class="title">Detalles de compra</h2>
        <div class="bloque-contenido">
            <table class="centrado">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Cédula</th>
                        <th>Nombre del evento</th>
                        <th>Ubicación</th>
                        <th>Serial</th>
                        <th>Fecha y hora de registro</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $fila[0] ?></td>
                        <td><?php echo $fila[1] ?></td>
                        <td><?php echo $fila[2] ?></td>
                        <td><?php echo $fila[3] ?></td>
                        <td><?php echo $fila[4] ?></td>
                        <td><?php echo $serial ?></td>
                        <td><?php echo $fila[5] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bloque-contenido centrado">
        <div class="centrado">
            <a href="../cliente.php">Finalizar</a>
        </div>
    </div>
<?php
}//if se consiguio algo valido
else
{
    $_SESSION["MENSAJE"] = "Lo sentimos, ocurrió un error al mostrar la información de la compra, por favor contacte con un administrador.";
    $_SESSION["STYLE"] = "error";
    header("location: comprar_boleto.php");
    die();
}
include("../../includes/footer.php");
die();
?>

