<link href="../../bracket/css/jquery.datatables.css" rel="stylesheet">
<div class="pageheader">
	<h2><i class="glyphicon glyphicon-retweet"></i> Transferências<span>lançamento</span></h2>
	<div class="breadcrumb-wrapper">
		<span class="label">Você está em:</span>
		<ol class="breadcrumb">
		  <a href="create_transferencia">Transferências</a>
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
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			  <div class="panel-btns">
				<a href="#" class="panel-close">&times;</a>
				<a href="#" class="minimize">&minus;</a>
			  </div>
			  <h4 class="panel-title">Lançar transferência</h4>
			</div>
			<div class="panel-body">
				<form id="cadastro_form" action="salvar_transferencia" method="POST" onsubmit="desmascararValor()">
					<div class="row">	
						<div class="col-md-3 form-group">
							<label for="contade">De conta: (<a href="../contas/create" title="Nova conta"><i class="fa fa-plus"></i></a>)</label>
							<select id="contade" name="contade"  class="form-control chosen-select col-md-3" data-placeholder="Selecione a conta...">
							
								<?php
									foreach ($contas as $row) {
									
										echo '<option value="'.$row['CODIGO'].'">'.$row['NOME'].'</option>';
									}
								?>
							</select>
						</div>
						<div class="col-md-3 form-group">
							<label for="contapara">Para conta: (<a href="../contas/create" title="Nova conta"><i class="fa fa-plus"></i></a>)</label>
							<select id="contapara" name="contapara"  class="form-control chosen-select col-md-3" data-placeholder="Selecione a conta...">
			
								<?php
									foreach ($contas as $row) {
									
										echo '<option value="'.$row['CODIGO'].'">'.$row['NOME'].'</option>';
									}
								?>
							</select>
						</div>
						<div class="col-md-3 form-group">
							<label for="data_transferencia">Data transferência:</label>
							<input type="text" class="form-control" placeholder="dd/mm/yyyy" id="data_transferencia" name="data_transferencia" value="<?php echo date('d/m/Y');?>">
						</div>  
						<div class="col-md-3 form-group">
							<label for="valor">Valor:</label>
								<input type="text" id="valor" name="valor"  class="form-control" value=0/>
						</div> 
					</div>
					
					<div class="row">
						<div class="col-md-12 form-group">
							<label for="observacao">Observação</label>
							<textarea id="observacao" name="observacao" class="form-control"></textarea>
						</div>
					</div>
					<hr/>

					<div class="row">
						<div class="col-md-12 form-group">
							<a href="index" class="btn btn-info">Listar Transferências</a>
							<input type="submit" class="btn btn-success" value="Salvar"/>
						</div>
					</div>   
				</form>
			</div>
		</div>
	</div>     
</div>
<?php 
	$scripts='<script type=text/javascript src=../scripts/jquery.price_format.2.0.min.js></script>
			  <script type="text/javascript" src="../scripts/transferencias/validacao.js"></script>'; ?>  
