<link href="../../bracket/css/jquery.datatables.css" rel="stylesheet">
<div class="pageheader">
	<h2><i class="glyphicon glyphicon-plus"></i> Receitas<span>lancamentos</span></h2>
	<div class="breadcrumb-wrapper">
		<span class="label">Você está em:</span>
		<ol class="breadcrumb">
		  <a href="index">Receitas</a>
		</ol>

	</div>
</div>
<input type="hidden" id="codigo_instrucao" value="RECEITAS_INSTRUCAO">
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
					<a href="nova_receita" class="btn btn-primary">Nova Receitas</a>
			  	</div>
			  	<h4 class="panel-title">Receitas Lançadas (Entradas)</h4>
			</div>
			<div class="panel-body">
				<div class="table-responsive table-hover">
					<table class="table table_page" id="table1">
						<thead>
							<tr>
								<th>Número</th>
								<th>Receitas</th>
								<th>Data Crédito</th>
								<th>Tipo de Pagamento</th>
								<th>Conta</th>
								<th>Grupo de Receita
								<th>Valor</th>
								<th>Editar</th>
								<th>Excluir</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach ($lancamentos as $row) {
									$debito="";
									echo ('<tr id="'.$row['CODIGO'].'">
											<td>'.$row['CODIGO'].'</td>
											<td>'.$row['LANCAMENTO'].'</td>
											<td>'.$row['DATA_CREDITO'].'</td>
											<td>'.$row['TIPO_PAGAMENTO'].'</td>
											<td>'.$row['CONTA'].'</td>
											<td>'.$row['GRUPO_RECEITA'].'</td>
											<td>R$'.number_format($row['VALOR'], 2, ',', '.').'</td>
											<td><a href=edit?id='.$row['CODIGO'].' class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a></td>
											<td><a href=deletar_receita?id='.$row['CODIGO'].' class="btn btn-danger btn-sm " title="Excluir"><i class="fa  fa-times-circle"></i></a></td></tr>');
								}
							?>  


						</tbody>
					</table>
				    <?php 
				    	//include('../shared/pag.inc.php') 
				    ?>
				</div><!-- table-responsive -->	
			</div>
		</div>
    </div>
    
</div>
<?php 
	$scripts='<script type="text/javascript" src="../scripts/receitas/validacao.js"></script>
	<script type="text/javascript" src="../scripts/table.js"></script>'; ?>  
