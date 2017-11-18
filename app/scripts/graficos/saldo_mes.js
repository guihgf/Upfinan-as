document.title="Saldos por mês";

google.load("visualization", "1", {packages:["corechart"]});
google.load("visualization", "1", {packages:["table"]});

$("#processar_grafico").on('click',function(){

	$('#load').removeClass('hide');

	var data_table = new google.visualization.DataTable();
	data_table.addColumn('string', 'Meses');

	data_table.addColumn('number', 'Saldos');

	$('#table_graf tbody').html("");

	var formatter = new google.visualization.NumberFormat(
		    {prefix: 'R$', negativeColor: 'red', negativeParens: false}
		);

	$.get('saldo_mes_action?conta='+$("#busca_contas").val()+'&ano='+$("#ano").val(), function (data) {

		$.each($.parseJSON(data), function (i, item) {

			data_table.addRow( [ item.MES,parseFloat(item.SALDO)]);
			
		});

		formatter.format(data_table, 1);

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
			table.draw(data_table, {allowHtml: true});
		}
		if (window.addEventListener) {
			window.addEventListener('resize', resizeHandler, false);
		}
		else if (window.attachEvent) {
			window.attachEvent('onresize', resizeHandler);
		}

	});
	
});