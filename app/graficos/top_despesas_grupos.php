
<div class="pageheader">
	<h2><i class="glyphicon glyphicon-signal"></i> Gráficos<span>maiores despesas por grupos</span></h2>
	<div class="breadcrumb-wrapper">
		<span class="label">Você está em:</span>
		<ol class="breadcrumb">
		  <a href="top_despesas_grupos">Maiores despesas por grupos</a>
		</ol>

	</div>
</div>
<input type="hidden" id="codigo_instrucao" value="MAIORES_DESPESAS_GRUPOS">
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
			  	<h4 class="panel-title">Maiores despesas por grupos (Valores em R$)</h4>
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
								<label for="data_ini">Data Início:</label>
								<input type="text" class="form-control" placeholder="dd/mm/yyyy" id="data_ini" name="data_ini" value="<?php echo date('01/m/Y');?>">
							</div>
							<div class="form-group">
								<label for="data_fim">Data Fim:</label>
								<input type="text" class="form-control" placeholder="dd/mm/yyyy" id="data_fim" name="data_fim" value="<?php echo date('d/m/Y');?>">
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
						<div style="height:300px;width:100%" id="top_gastos_grupos"></div>
						<p>**Clique no grupo do gráfico para visualizar detalhes.</p>					
					</div>
					<div id="graf_det" class="col-md-3 col-sm-12">
						<!--<table id="table_graf" class="col-sm-12 col-md-12 table_graf hide">
							<thead>
								<tr>
									<th class="th_graf">Grupo de despesa</th>
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
    <div class="modal fade" id="detalhesGruposModal" tabindex="-1" role="dialog" aria-labelledby="detalhesGruposModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="detalhesGruposModalLabel"></h4>
			  </div>
			  <div class="modal-body"  style="height:400px;overflow-y:auto">
				<div class="row">
					<div class="table-responsive table-hover">
						<table class="table" id="table_modal">
							<thead>
							</thead>
							<tbody>			
							</tbody>
						</table>
					</div><!-- table-responsive -->
				</div>		
			  </div>
			  <div class="modal-footer">
				<button id="btVisualizar" type="button" class="btn btn-primary">Visualizar</button>
			  </div>
			</div><!-- modal-content -->
		</div><!-- modal-dialog -->
	</div><!-- modal -->
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<?php
	$scripts='<script type="text/javascript" src="../scripts/graficos/top_despesas_grupos.js"></script>
			  <script type="text/javascript" src="../scripts/table.js"></script>';
?>

