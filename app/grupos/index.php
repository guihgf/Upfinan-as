<link href="../../bracket/css/jquery.datatables.css" rel="stylesheet">
<div class="pageheader">
	<h2><i class="fa  fa-file-text-o"></i> Grupos de despesas<span>cadastrados</span></h2>
	<div class="breadcrumb-wrapper">
		<span class="label">Você está em:</span>
		<ol class="breadcrumb">
		  <a href="index">Grupos de despesas</a>
		</ol>

	</div>
</div>
<input type="hidden" id="codigo_instrucao" value="GRUPOS_DESPESAS_INSTRUCAO">
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
					<a href="create" class="btn btn-primary">Novo Grupo</a>
			  	</div>
			  	<h4 class="panel-title">Grupos de despesas</h4>
			</div>
			<div class="panel-body">			  
				<div class="row">
					<div class="table-responsive table-hover">
						<table class="table table_page" id="table1">
							<thead>
								<tr>
									<th>Número</th>
									<th>Nome</th>
									<th>Data de Cadastro</th>
									<th>Status</th>
									<th>Total gasto</th>
									<th>Editar</th>
									<th>Desativar</th>
									<th>Excluir</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach ($grupos as $row) {
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
												<td>'.$row['DATA_CADASTRO'].'</td>
												<td>'.$status.'</td>
												<td>R$'.number_format($row['TOTAL_GASTO'], 2, ',', '.').'</td>
												<td class="col-md-1"><a href=edit?id='.$row['CODIGO'].' class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a></td>
												<td class="col-md-1">
													<a href=status_grupo?id='.$row['CODIGO'].'&status=2  class="btn btn-danger btn-sm '.$btn_desa.'" title="Desativar"><i class="fa fa-ban"></i></a>
													<a href=status_grupo?id='.$row['CODIGO'].'&status=1  class="btn btn-success btn-sm '.$btn_ativ.'"  title="Ativar"><i class="fa  fa-check-square"></i></a>
												</td>
												<td><a href=# onClick="deletar_grupo('.$row['CODIGO'].');" class="btn btn-danger btn-sm " title="Excluir"><i class="fa  fa-times-circle"></i></a></td></tr>');
										$classe="";
										$status="";
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
<?php 
	$scripts='<script type="text/javascript" src="../scripts/grupo/validacao.js"></script>
	<script type="text/javascript" src="../scripts/table.js"></script>';?>

    