$(document).ready(function(){

    // Função que verifica se ambos os campos de senha e confirmar senha estão iguais antes de submeter para o php
    $("#formEsq").submit(function(e) { // Id do form
		if($("#inputPass").val() != $("#inputConfPass").val()) { // Verifica os valores dos campos
			e.preventDefault();
        }
    });

    // Verifica o campo confirmar senha com senha para mostrar para o usuário que está diferente de senha
    $("#inputConfPass").on("change paste keyup",  function() {
        if ($("#inputConfPass").val() != $("#inputPass").val()) {
            $("#inputConfPass").css("border", "1px solid red");
        }
        else {       
            $("#inputConfPass").css("border", "1px solid #ced4da");
        }
    });
});
