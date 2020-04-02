//seleccion.js
/* Archivo javascript necesario para EDITAR un boleto */

var evaluar = document.getElementById("evaluar");
var id_boleto = document.getElementById("id_boleto"); //input hidden
var select = document.getElementById("id_evento");

document.getElementById("actualizar_boleto").disabled = false;

var id_evento_inicial = id_evento.options[select.selectedIndex].value;
evaluar.disabled = false;

evaluar.onclick = function()
{
    var selectedOption = id_evento.options[select.selectedIndex].value;
    if (selectedOption != "")
    {
        window.location.replace("?id_boleto=" + id_boleto.value + "&id_evento=" + selectedOption);
    }
};

select.onchange = function()
{
    var selectedOption = id_evento.options[select.selectedIndex].value;
    var desplegable = document.getElementById("desplegable");
    if (id_evento_inicial != selectedOption)
    {
        desplegable.style.display = "none";
        evaluar.disabled = false;
    }
    else
    {
        desplegable.style.display = "block";
        evaluar.disabled = true;
    }
}