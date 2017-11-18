var row;
var desativacao;
var codigo;

$('tr').on('click', function(e) {
    $('tr').removeClass("success");
    row = $(this).attr('id');
    var id = "#" + row;
    $(id).addClass("success");
});

$('#remover_msg').on('click', function(e) { 
	$.get( "../instrucoes/desativar_instrucao?codigo="+$("#codigo_instrucao").val(), function( data ){
		$("#instrucoes").addClass('hide');
	});
});

$(document).ready(function(){
		$.get( "../instrucoes/get_instrucao?codigo="+$("#codigo_instrucao").val(), function( data ){
			if($.parseJSON(data)[0].ASSUNTO!=""){
				$("#instrucoes").removeClass('hide');
				$("#header_msg_instrucoes").html($.parseJSON(data)[0].ASSUNTO);
				$("#body_msg_instrucoes").html($.parseJSON(data)[0].MENSAGEM);
			}
		});
	
});


