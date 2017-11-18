
<div class="pageheader">
	<h2><i class="glyphicon glyphicon-signal"></i> Gráficos<span>saldos por mês</span></h2>
	<div class="breadcrumb-wrapper">
		<span class="label">Você está em:</span>
		<ol class="breadcrumb">
		  <a href="saldo_mes">Saldos por Mês</a>
		</ol>

	</div>
</div>
<input type="hidden" id="codigo_instrucao" value="GRAFICO_SALDO_MES">
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
			  	<h4 class="panel-title">Saldos por Mês (Receitas obtidas no mês menos Despesas feitas no mês)</h4>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="row form-inline">
							<div class="form-group">
								<label for="busca_contas">Conta:</label>
								<select id="busca_contas" name="busca_contas" data-placeholder="Selecione a conta..." class="chosen-select form-control">
									<?php
										foreach ($contas as $row) {
										
											echo '<option value="'.$row['CODIGO'].'">'.$row['NOME'].'</option>';
										}
									?>
									
								</select>
							</div>
							<div class="form-group">
								<label for="ano">Ano:</label>
								<input type="text" id="ano" name="ano" class="form-control"/>
							</div>
								
							<a href="#" id="processar_grafico" class="btn btn-primary">Processar</a>	
						</div>
					</div>
			    </div>
			    <hr/>
				<div class="row hide" id="load" style="text-align:center">
					<img src="../../bracket/images/loaders/loader6.gif"/>
				</div>
				<div class="row">
					<div class="col-md-9 col-sm-12">
						<div style="height:300px;width:100%" id="saldo_mes"></div>						
					</div>
					<div id="graf_det" class="col-sm-12 col-md-3">
						<!--<table id="table_graf" class="col-sm-12 col-md-12 table_graf hide">
							<thead>
								<tr>
									<th class="th_graf">Mês</th>
									<th class="th_graf">Saldo</th>
								</tr>
							</thead>
							<tbody>						
							</tbody>
						</table>	-->						
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<?php
	$scripts='<script type="text/javascript" src="../scripts/graficos/saldo_mes.js"></script>
			  <script type="text/javascript" src="../scripts/table.js"></script>';
?>

