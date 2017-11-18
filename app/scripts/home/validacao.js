document.title="Upfinanças - Home";

var conta_default=0;

$("#ch_resumo_contas_mes").change(function () {
	get_despesa_mes($("#ch_resumo_contas_mes").val());
	get_receita_mes($("#ch_resumo_contas_mes").val());
});

$("#ch_calendario").change(function () {
	get_agenda_lancamentos($("#ch_calendario").val());
});

function get_despesa_mes(conta){
	$('#despesas_mes tbody').html("");
	$.get('../despesas/resumo_despesa_mes?conta='+conta, function (data) {
		var i = 0;
		$.each($.parseJSON(data)["DESPESAS"], function (i, item) {
			if(item.NOME!=null){
				var block='<tr><td style="text-align:center">'+item.NOME+'</td><td style="text-align:center">R$'+item.VALOR_TOTAL+'</td></tr>';
				$('#despesas_mes tbody').append(block);
			}
			
		});
	});
}

function get_receita_mes(conta){
	$('#receita_mes tbody').html("");
	$.get('../receitas/resumo_receita_mes?conta='+conta, function (data) {
		var i = 0;
		$.each($.parseJSON(data)["RECEITAS"], function (i, item) {
			if(item.NOME!=null){
				var block='<tr><td style="text-align:center">'+item.NOME+'</td><td style="text-align:center">R$'+item.VALOR_TOTAL+'</td></tr>';
				$('#receita_mes tbody').append(block);
			}
			
		});
	});
}

function get_agenda_lancamentos(conta){
	$.get('../contas/agenda_lancamentos_contas?conta_id='+conta, function (data) {

		$('#calendar').fullCalendar( 'removeEvents');
		var i = 0;
		$.each($.parseJSON(data), function (i, item) {
			var cor="";
			var data = new Date();
			if(item.TIPO==1){
				cor="#1CAF9A";
			}
			else
			{
				cor="#428bca";
			}
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();

			if(dd<10) {
			    dd='0'+dd
			} 

			if(mm<10) {
			    mm='0'+mm
			} 

			today = yyyy+'-'+mm+'-'+dd;
			//despesas vencidas
			if(item.DATA_PAGAMENTO ==null && item.DATA_VENCIMENTO<today){
				cor="#d9534f";
			}
			//despesas abertas
			if(item.DATA_PAGAMENTO ==null && item.DATA_VENCIMENTO>=today){
				cor="#f0ad4e";
			}


			var eventObject = {
			    title: item.NOME.replace(/&ordf;/g, 'ª'),
			    start: item.DATA_VENCIMENTO,
			    allDay: true,
			    id: item.CODIGO,
			    backgroundColor: cor,
			    tipo:item.TIPO,
			    };

   			$('#calendar').fullCalendar('renderEvent', eventObject, true);
    //return eventObject;
			
		});
		 $('#calendar').fullCalendar('refetchEvents');

	});
		
}


$.get('../contas/list_contas_saldo', function (data) {
	var i = 0;
	$.each($.parseJSON(data), function (i, item) {
		$('#ch_resumo_contas_mes').append($('<option>', {
			value: item.CODIGO,
			text: item.NOME
		}));
		$('#ch_calendario').append($('<option>', {
			value: item.CODIGO,
			text: item.NOME
		}));
	});
	conta_default=$.parseJSON(data)[0].CODIGO;
	get_despesa_mes(conta_default);
	get_receita_mes(conta_default);
});




$(document).ready(function () {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        jQuery('#calendar').fullCalendar({
			lang:'pt-br',
			header: {
						
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			events: [],
			editable: false,
			eventLimit:true,
			eventClick: function(calEvent, jsEvent, view) {

		        if (calEvent.tipo==2) {
		        	window.location.assign("../despesas/edit?id=" + calEvent.id);
		        }
		        else{
		        	window.location.assign("../receitas/edit?id=" + calEvent.id);
		        }

		    }
		});
		get_agenda_lancamentos($("#ch_calendario").val());

    });
    $('#home_tabs a:first').tab('show');
});
