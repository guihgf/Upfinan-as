<link href="../../bracket/css/jquery.datatables.css" rel="stylesheet">
<div class="pageheader">
	<h2><i class="glyphicon glyphicon-retweet"></i> Transferências<span>lançadas</span></h2>
	<div class="breadcrumb-wrapper">
		<span class="label">Você está em:</span>
		<ol class="breadcrumb">
		  <a href="index">Transferências</a>
		</ol>

	</div>
</div>
<input type="hidden" id="codigo_instrucao" value="TRANSFERENCIAS_INSTRUCAO">
<div class="contentpanel">
	<div class="row">
		<?php
	$contas;

	include('../shared/msg.inc.php');

	include('../shared/instrucoes.inc.php');

?>
	</div>
    <div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
			  	<div class="panel-btns">
					<a href="create_transferencia" class="btn btn-primary">Nova Transferência</a>
			  	</div>
			  	<h4 class="panel-title">Transferências</h4>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="table-responsive table-hover">
						<table class="table table_page" id="table1">
							<thead>
								<tr>
									<th>Nome</th>
									<th>Data da Transferência</th>
									<th>Valor</th>
									<th>Excluir</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach ($transferencias as $row) {										
										
										echo ('<tr id='.$row['CODIGO'].'>
												<td>'.$row['NOME'].'</td>
												<td>'.$row['DATA_TRANSFERENCIA'].'</td>
												<td>R$'.number_format($row['VALOR'], 2, ',', '.').'</td>
												<td><a href=deletar_transferencia?id='.$row['CODIGO'].' class="btn btn-danger btn-sm " title="Excluir"><i class="fa  fa-times-circle"></i></a></td>
											  </tr>');
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
        
    
</div>
<?php 
	$scripts='<script type="text/javascript" src="../scripts/transferencias/validacao.js"></script>
	<script type="text/javascript" src="../scripts/table.js"></script>';?>

    
