// Pega todos os elementos de p
var x = document.getElementsByClassName("p-truncated");

// Função que limita a quantidade de caracteres em maxLength
function truncateText(element, maxLength) {
	var truncated = element.innerText; // Pega o texto

	if (truncated.length > maxLength) { // Se é maior que o maxLength passado pelo parâmetro
		truncated = truncated.substr(0,maxLength); // Copia apenas a parte menor
		// Procura o último espaço, copia apenas a parte anterior a esse index e concatenando com '...'
		truncated = truncated.substr(0, truncated.lastIndexOf(" ")) + '...';
	}
return truncated;
}

// Aplica maxLength para todos os elementos de p
for (i = 0; i < x.length; i++) {
	x[i].innerHTML = truncateText(x[i], 400);
}
