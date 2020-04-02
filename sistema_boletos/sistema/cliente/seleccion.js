//seleccion.js
/* Archivo javascript necesario para COMPRAR un boleto */

var evaluar = document.getElementById("evaluar");
var bandera = document.getElementById("registrar_boleto");
evaluar.disabled = false;
if (!bandera)
{
    var select = document.getElementById("id_evento");
    evaluar.onclick = function()
    {
        var selectedOption = id_evento.options[select.selectedIndex].value;
        if (selectedOption != "")
        {
            window.location.replace("?id_evento=" + selectedOption);
        }
    };
}
else
{
    bandera.disabled = false;
    evaluar.onclick = function()
    {
        window.location.replace("../cliente/comprar_boleto.php");
    };
}