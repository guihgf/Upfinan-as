<link href="../../bracket/css/jquery.datatables.css" rel="stylesheet">

<div class="pageheader">

	<h2><i class="glyphicon glyphicon-minus"></i> Despesas<span>lancamentos</span></h2>

	<div class="breadcrumb-wrapper">
		<span class="label">Você está em:</span>
		<ol class="breadcrumb">
		  <a href="index">Despesas</a>
		</ol>
	</div>
</div>
<input type="hidden" id="codigo_instrucao" value="DESPESAS_INSTRUCAO">

<div class="contentpanel">
	<div class="row">
	<?php
		include('../shared/msg.inc.php');
		include('../shared/instrucoes.inc.php');
	?>
	</div>
    <div class="row">
    	<div class="panel panel-default">
			<div class="panel-heading">
			  	<div class="panel-btns">
					<a href="nova_despesa" class="btn btn-primary">Nova Despesa</a>
			  	</div>
			  	<h4 class="panel-title">Despesas Lançadas (Saídas)</h4>
			</div>
			<div class="panel-body">
				<div class="table-responsive table-hover">
					<table class="table table_page" id="table1">
						<thead>
							<tr>
								<th>Número</th>
								<th>Despesa</th>
								<th>Data Vencimento</th>
								<th>Tipo de Pagamento</th>
								<th>Pago</th>
								<th>Conta</th>
								<th>Grupo de Despesa
								<th>Valor</th>
								<th>Pagar</th>
								<th>Editar</th>
								<th>Excluir</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach ($lancamentos as $row) {
									$debito="";
									$pago="";
									$parameter="";

									if($row['PAGO']=="Sim"){
										$pago="hide";
									}

									if(isset($_GET["tipo"])){
										$parameter="tipo=1";
									}

									echo ('<tr id="'.$row['CODIGO'].'">

											<td>'.$row['CODIGO'].'</td>

											<td>'.$row['LANCAMENTO'].'</td>

											<td>'.$row['DATA_VENCIMENTO'].'</td>

											<td>'.$row['TIPO_PAGAMENTO'].'</td>

											<td>'.$row['PAGO'].'</td>

											<td>'.$row['CONTA'].'</td>

											<td>'.$row['GRUPO_DESPESA'].'</td>

											<td>R$'.number_format($row['VALOR'], 2, ',', '.').'</td>

											<td><a href=pagar?id='.$row['CODIGO'].'&'.$parameter.' class="btn btn-success btn-sm '.$pago.'" title="Pagar agora"><i class="fa fa-check"></i></a></td>

											<td><a href=edit?id='.$row['CODIGO'].' class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a></td>

											<td><a href=deletar_despesa?id='.$row['CODIGO'].' class="btn btn-danger btn-sm " title="Excluir"><i class="fa  fa-times-circle"></i></a></td></tr>');
								}

							?>
						</tbody>
					</table>
				</div><!-- table-responsive -->
			</div>
		</div>
    </div>
</div>

<?php
	$scripts='<script type="text/javascript" src="../scripts/table.js"></script>
				<script type="text/javascript" src="../scripts/despesas/validacao.js"></script>'; ?>

