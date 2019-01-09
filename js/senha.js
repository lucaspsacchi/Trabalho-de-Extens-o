$(document).ready(function(){

    // Função que verifica se ambos os campos de senha e confirmar senha estão iguais antes de submeter para o php
    $("#cadastro").submit(function(e) { // Id do form
		if($('#inputPass').val() != $('#inputConfPass').val()) { // Verifica os valores dos campos
			e.preventDefault();
			$("#inputConfPass").css("border", "1px solid red");
            $('[data-toggle="popover"]').popover();
        }
    });
}