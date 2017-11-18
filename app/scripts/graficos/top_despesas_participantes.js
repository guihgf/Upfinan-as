document.title="Maiores despesas por participantes";

//Datepicker
$( "#data_ini" ).datepicker();
$( "#data_fim" ).datepicker();

var row="";
$("tr").live("click", function(e) {
	$("tr").removeClass("success");
	row = $(this).attr("id");
	var id = "#" + row;
	$(id).addClass("success");
});

$("#btVisualizar").click(function () {
	if(row==""){
		alert("Selecione um lançamento.");
	}
	else
	{
		window.location.assign("../despesas/edit?id=" + row);
	}
});	

google.load("visualization", "1", {packages:["corechart"]});
google.load("visualization", "1", {packages:["table"]});

$("#processar_grafico").on('click',function(){
	$('#load').removeClass('hide');

	var data_table = new google.visualization.DataTable();
	data_table.addColumn('string', 'Participantes');
	data_table.addColumn('number', 'Total em R$');
	data_table.addColumn('number', 'Id');

	$('#table_graf tbody').html("");

	var formatter = new google.visualization.NumberFormat(
		    {prefix: 'R$', negativeColor: 'red', negativeParens: false}
		);

	$.get('top_despesas_participantes_graf?conta='+$("#busca_contas").val()+'&data_ini='+$("#data_ini").val()+'&data_fim='+$("#data_fim").val(), function (data) {
		$.each($.parseJSON(data), function (i, item) {
			data_table.addRow([item.NOME,parseFloat(item.TOTAL),parseInt(item.ID)]);
			//$('#table_graf tbody').append('<tr class="tr_graf"><td>'+item.NOME+'</td><td>'+item.TOTAL+'</td></tr>');
			
		});

		formatter.format(data_table, 1);

		$('#table_graf').removeClass('hide');


		var options = {pieHole: 0.4,
						   'backgroundColor':'none',
						   legend: { position: 'bottom'}};
	 
		// Instantiate and draw our chart, passing in some options.
		var chart = new google.visualization.PieChart(document.getElementById('top_gastos_participantes'));
		
		function selectHandler() {
				var selectedItem = chart.getSelection()[0];
				if (selectedItem) {
					var id = data_table.getValue(selectedItem.row, 2);
					var grupo =data_table.getValue(selectedItem.row, 0);
					$.get('../graficos/top_despesas_participantes_det?id='+id+'&conta='+$("#busca_contas").val()+'&data_ini='+$("#data_ini").val()+'&data_fim='+$("#data_fim").val(), function (data) {
						//alert(data);
						$("#table_modal thead").html("");
						$('#table_modal tbody').html("");
						$('#detalhesParticipantesModalLabel').html("");
						$('#detalhesParticipantesModalLabel').html("Lançamentos do participante "+  grupo);
						
						$("#table_modal thead").append("<tr><th>Código</th><th>Nome</th><th>Data de Pagamento</th><th>Valor</th><th>Conta</th></tr>");

						var i = 0;
						var $rows="";
						$.each($.parseJSON(data), function (i, item) {
							$rows=$rows+"<tr id="+item.CODIGO+"><td>"+item.CODIGO+"</td><td>"+item.NOME+"</td><td>"+item.DATA_PAGAMENTO+"</td><td>"+item.VALOR+"</td><td>"+item.CONTA+"</td></tr>";
							
						});
						$('#table_modal tbody').append($rows);
						$("#detalhesParticipantesModal").modal('show');
			
					});
					//alert('The user selected ' + topping);
				}
		}		

		google.visualization.events.addListener(chart, 'select', selectHandler); 

		chart.draw(data_table,options);

		var view = new google.visualization.DataView(data_table);
		view.setColumns([0,1]);

		var table = new google.visualization.Table(document.getElementById('graf_det'));
		table.draw(view, {allowHtml: true});

		$('#load').addClass('hide');
		function resizeHandler () 
		{
			chart.draw(data_table, options);
		}
		if (window.addEventListener) {
			window.addEventListener('resize', resizeHandler, false);
		}
		else if (window.attachEvent) {
			window.attachEvent('onresize', resizeHandler);
		}
	});
});