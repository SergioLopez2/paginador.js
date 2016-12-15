// url para llamar la peticion por ajax
var url_listar_usuario = "php/listar.php";

$( document ).ready(function() {
   // se genera el paginador
   paginador = $(".pagination");
	// cantidad de items por pagina
	var items = 2, numeros =4;	
	// inicia el paginador
	init_paginator(paginador,items,numeros);
	// se envia la peticion ajax que se realizara como callback
	set_callback(get_data_callback_clientes_top);
	cargaPagina(0);
});
// peticion ajax enviada como callback
function get_data_callback_clientes_top(){
	$.ajax({
		data:{
		limit: itemsPorPagina,							
		offset: desde,									
		},
		type:"POST",
		url:url_listar_usuario
	}).done(function(data,textStatus,jqXHR){		
		// obtiene la clave lista del json data
		var lista = data.lista;
		$("#table").html("");
		
		// si es necesario actualiza la cantidad de paginas del paginador
		if(pagina==0){
			creaPaginador(data.cantidad);
		}
		// genera el cuerpo de la tabla
		$.each(lista, function(ind, elem){			
			$('<tr>'+				
				'<td>'+elem.id+'</td>'+								
				'<td>'+elem.nombres+'</td>'+				
				'<td>'+elem.apellidos+'</td>'+				
				'</tr>').appendTo($("#table"));		
		});			
	}).fail(function(jqXHR,textStatus,textError){
		alert("Error al realizar la peticion dame".textError);
	});
}