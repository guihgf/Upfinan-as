<!DOCTYPE>
<html>
	<head>
		<title></title>
		<style type="text/css">
			#titulo_relatorio{
				text-align: center;
				font-size: 20px;
				font-family: sans-serif,arial  !important;
				padding-bottom: 10px;
				border-bottom: black;
				border-bottom-style: solid;
				border-bottom-width: 1px;
			}

			#table_relatorio{
				text-align: center;
				width: 100%;
				padding-bottom: 10px;
				border-bottom: black;
				border-bottom-style: solid;
				border-bottom-width: 1px;
			}

			#table_relatorio_head{
				height: 35px;
			}

			#table_relatorio_summary{
				width: 100%;
				padding-top: 10px;
			}
		</style>
	</head>
	<body style="width:210mm">
		<div id="titulo_relatorio">
			<b>Extrato geral da conta</b>
		</div>
		<table id="table_relatorio"> 
			<?php 
			 if(isset($extrato)){
			 ?>		
			<thead>
				<tr id="table_relatorio_head">
					<th style="width:15%">Data Pagamento</th>
					<th style="width:30%">Histórico</th>
					<th style="width:15%">Lançamento</th>
					<th style="width:20%">Valor</th>
					<th style="width:20%">Saldo do dia</th>
				</tr>
			</thead>

			<tbody>
				<?php
					$despesa_total=0;
					$receita_total=0;
					foreach ($extrato as $row) {
						$despesa="";
						$saldo=$row['SALDO'];

						if($row['TIPO']==3){
							$despesa="color:red";
							$despesa_total+=$row['VALOR'];
						}
						else if($row['TIPO']==2){
							$receita_total+=$row['VALOR'];
						}

						if($saldo!='')
						{
							$saldo='R$' .number_format($row['SALDO'], 2, ',', '.');
						}
						echo ('<tr>
								<td>'.$row['DATA_PAGAMENTO'].'</td>
								<td>'.$row['NOME'].'</td>
								<td>'.$row['CODIGO'].'</td>
								<td style="'.$despesa.'"> R$'.number_format($row['VALOR'], 2, ',', '.').'</td>
								<td>'.$saldo.'</td></tr>');
					}
				?>  
			</tbody>
		 <?php }?>
		</table>
		<table id="table_relatorio_summary"> 	
			<tbody>
				<tr>
					<td style="width:80%; text-align:right;"><b>Total de Despesas no período:</b></td>
					<td style="width:20%; text-align:center;"><?php echo "R$".number_format($despesa_total, 2, ',', '.');?></td>
				<tr>
				<tr>
					<td style="width:80%; text-align:right;"><b>Total de Receitas no período:</b></td>
					<td style="width:20%; text-align:center;"><?php echo "R$".number_format($receita_total, 2, ',', '.');?></td>
				<tr>
			</tbody>

		</table>
		<div style="text-align: center">
			<input type="button" value="Imprimir" onClick="window.print()">
		</div>
	</body>
</html>

