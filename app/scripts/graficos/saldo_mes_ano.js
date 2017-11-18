document.title="Saldos por mês(Comparando dois anos)";

google.load("visualization", "1", {packages:["corechart"]});

google.load("visualization", "1", {packages:["table"]});

$("#processar_grafico").on('click',function(){

	$('#load').removeClass('hide');

	var data_table = new google.visualization.DataTable();

	data_table.addColumn('string', 'Meses');

	data_table.addColumn('number', 'Saldos '+$("#ano").val());

	data_table.addColumn('number', 'Saldos '+$("#ano2").val());

	$('#table_graf tbody').html("");

	var formatter = new google.visualization.NumberFormat(
		    {prefix: 'R$', negativeColor: 'red', negativeParens: false}
		);

	$.get('saldo_mes_ano_action?conta='+$("#busca_contas").val()+'&ano='+$("#ano").val()+'&ano2='+$("#ano2").val(), function (data) {
		
		for (var i=0;i<12;i++){
			
			data_table.addRow([$.parseJSON(data)[0][i].MES,parseFloat($.parseJSON(data)[0][i].SALDO),parseFloat($.parseJSON(data)[1][i].SALDO)]);
			
			//$('#table_graf tbody').append('<tr class="tr_graf"><td>'+$.parseJSON(data)[0][i].MES+'</td><td>'+parseInt($.parseJSON(data)[0][i].SALDO)+'</td><td>'+parseInt($.parseJSON(data)[1][i].SALDO)+'</td></tr>');
		}

		formatter.format(data_table, 1);
		formatter.format(data_table, 2);

		$('#table_graf').removeClass('hide');

		var options = {'backgroundColor':'none'};

		var chart = new google.visualization.LineChart(document.getElementById('saldo_mes'));

		chart.draw(data_table,options);

		var table = new google.visualization.Table(document.getElementById('graf_det'));

		table.draw(data_table, {allowHtml: true});

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