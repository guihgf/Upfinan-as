<link href="../../bracket/css/jquery.datatables.css" rel="stylesheet">
<div class="pageheader">
	<h2><i class="fa fa-users"></i> Participantes<span>cadastrados</span></h2>
	<div class="breadcrumb-wrapper">
		<span class="label">Você está em:</span>
		<ol class="breadcrumb">
		  <a href="index">Participantes</a>
		</ol>
	</div>
</div>
<input type="hidden" id="codigo_instrucao" value="PARTICIPANTES_INSTRUCAO">
<div class="contentpanel">
	<div class="row">
		<?php
	$participantes;
	
	include('../shared/msg.inc.php');

	include('../shared/instrucoes.inc.php');
?>
	</div>
    <div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
			  	<div class="panel-btns">
					<a href="create" class="btn btn-primary">Novo Participante</a>
			  	</div>
			  	<h4 class="panel-title">Participantes</h4>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="table-responsive table-hover">
						<table class="table table_page" id="table1">
							<thead>
								<tr>
									<th>Número</th>
									<th>Nome</th>
									<th>Cidade</th>
									<th>Status</th>
									<th>Saída</th>
									<th>Entrada</th>
									<th>Saldo</th>
									<th>Editar</th>
									<th>Status</th>
									<th>Excluir</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach ($participantes as $row) {
										$classe="";
										$status="";
										$btn_desa="";
										$btn_ativ="";
										if ($row['STATUS']==2)
										{
											$classe="danger";
											$status="Desativado";
											$btn_desa="hidden";
										}
										else{
											$status="Ativado";
											$btn_ativ="hidden";
										}
										
										
										echo ('<tr id="'.$row['CODIGO'].'" class="'.$classe.'">
												<td>'.$row['CODIGO'].'</td>
												<td>'.$row['NOME'].'</td>
												<td>'.$row['CIDADE'].'</td>
												<td>'.$status.'</td>
												<td>R$'.number_format($row['SAIDA'], 2, ',', '.').'</td>
												<td>R$'.number_format($row['ENTRADA'], 2, ',', '.').'</td>
												<td>R$'.number_format($row['SALDO'], 2, ',', '.').'</td>
												<td class="col-md-1"><a href=edit?id='.$row['CODIGO'].' class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a></td>
												<td class="col-md-1">
													<a href=status_participante?id='.$row['CODIGO'].'&status=2  class="btn btn-danger btn-sm '.$btn_desa.'" title="Desativar"><i class="fa fa-ban"></i></a>
													<a href=status_participante?id='.$row['CODIGO'].'&status=1  class="btn btn-success btn-sm '.$btn_ativ.'"  title="Ativar"><i class="fa  fa-check-square"></i></a>
												</td>
												<td><a href=# onClick="deletar_participante('.$row['CODIGO'].');" class="btn btn-danger btn-sm " title="Excluir"><i class="fa  fa-times-circle"></i></a></td>
												</tr>');
										$classe="";
										$status="";
										$btn_desa="";
										$btn_ativ="";
									}
								?>           
											
							</tbody>
						</table>
						<?php //include('../shared/pag.inc.php');

						?>
					</div><!-- table-responsive -->
				</div>
					</div>
				</div>	
			</div>
		</div>
        
		
    
</div>
<?php 
	$scripts='<script type="text/javascript" src="../scripts/participante/validacao.js"></script>
	<script type="text/javascript" src="../scripts/table.js"></script>';?>

    