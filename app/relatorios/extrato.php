
<div class="pageheader">
	<h2><i class="glyphicon glyphicon-file"></i> Relatórios<span>extrato geral por conta</span></h2>
	<div class="breadcrumb-wrapper">
		<span class="label">Você está em:</span>
		<ol class="breadcrumb">
		  <a href="extrato">Extrato geral por conta</a>
		</ol>

	</div>
</div>
<input type="hidden" id="codigo_instrucao" value="EXTRATO">
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
					<a href="#" class="panel-close">&times;</a>
					<a href="#" class="minimize">&minus;</a>
			  	</div>
			  	<h4 class="panel-title">Extrato geral por conta</h4>
			</div>
			<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row form-inline">

								<div class="form-group">
									<label for="busca_contas">Conta:</label>
									<select id="busca_contas" name="busca_contas" data-placeholder="Selecione a conta..." class="chosen-select form-control ">
										<?php
											foreach ($contas as $row) {
											
												echo '<option value="'.$row['CODIGO'].'">'.$row['NOME'].'</option>';
											}
										?>
										
									</select>
								</div>
								<div class="form-group">
									<label for="busca_contas">Período:</label>
									<select id="periodo" name="periodo" class="form-control ">
										<option value="0">Selecione...</option>
										<option value="7">Últimos 7 dias</option>
										<option value="10">Últimos 10 dias</option>
										<option value="15">Últimos 15 dias</option>	
										<option value="30">Últimos 30 dias</option>	
										<option value="45">Últimos 45 dias</option>	
										<option value="60">Últimos 60 dias</option>											
									</select>
								</div>
								<div class="form-group">
									<label for="data_ini">Data Início:</label>
									<input type="text" class="form-control" placeholder="dd/mm/yyyy" id="data_ini" name="data_ini" value="<?php echo date('01/m/Y');?>">
								</div>
								<div class="form-group">
									<label for="data_fim">Data Fim:</label>
									<input type="text" class="form-control" placeholder="dd/mm/yyyy" id="data_fim" name="data_fim" value="<?php echo date('d/m/Y');?>">
								</div>
							</div>
							<br/>
							<div class="row form-inline" style="text-align:center">
								<a href="#" id="processar_relatorio" class="btn btn-primary">Processar relatório</a>
							</div>	
						</div>
				    </div>
				    <br/>
				    <div class="row">
				    	<b>**Relatório será aberto em uma nova janela.</b>
				    </div>
				</div>
			</div>
		</div>
    </div>
</div>

<?php
	$scripts='<script type="text/javascript" src="../scripts/relatorios/extrato.js"></script>
			  <script type="text/javascript" src="../scripts/table.js"></script>';
?>

