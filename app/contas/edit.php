<div class="pageheader">
	<h2><i class="fa fa-money"></i> Contas<span>editar</span></h2>
	<div class="breadcrumb-wrapper">
		<span class="label">Você está em:</span>
		<ol class="breadcrumb">
		  <a href="index">Contas</a>
		</ol>
	</div>
</div>
<div class="contentpanel">
	<div class="row">
		<div class="col-sm-12">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
					  	<div class="panel-btns">
							<a href="#" class="panel-close">&times;</a>
							<a href="#" class="minimize">&minus;</a>
					 	</div>
					  <h4 class="panel-title">Editar Contas</h4>
					</div>
					<div class="panel-body">
						<form id="cadastro_form" action="edit_conta" method="POST">
							<input type="hidden" id="codigo" name="codigo" value="<?php echo $conta["CODIGO"]?>" />
							<div class="row">
								<div class="col-sm-4 form-group">
										<label for="nome">Nome</label>
										<input type="text" id="nome" name="nome" class="form-control" value="<?php echo $conta["NOME"]?>"/>
								</div>
								<!--<div class="col-sm-4 form-group">
									<label for="data_inicio">Data Inicio</label>
									<div class="input-group">
										<input type="text" class="form-control" placeholder="dd/mm/yyyy" id="data_inicio" name="data_inicio" value="<?php echo $conta[0]["DATA_INICIO"]?>">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
									</div>
								</div>
								<div class="col-sm-4 form-group">
									<label for="data_inicio">Data Fim</label>
									<div class="input-group">
										<input type="text" class="form-control" placeholder="dd/mm/yyyy" id="data_fim" name="data_fim" value="<?php echo $conta[0]["DATA_FIM"]?>">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
									</div>
								</div>  --> 
								<div class="col-sm-4 form-group">
									<label for="padrao">Definir como conta Padrão?</label>
									<select id="padrao" name="padrao" class="form-control">
										<?php  
											if ($conta["PADRAO"]=="2"){
												echo '<option value="1">Não</option>
													 <option value="2" selected>Sim</option>';
											}
											else {
											   echo '<option value="1" selected>Não</option>
													 <option value="2">Sim</option>';
											} ?>
									</select>
									<i class="icon-question-sign" rel="tooltip" title="Define a conta padrão para utilizar nos lançamentos"></i>
								</div>
							</div>
							<hr/>
							<div class="row">
								<div class="col-sm-4 form-group">
									<a href="index" class="btn btn-info">Listar Contas</a>
									<input type="submit" class="btn btn-success" value="Salvar"/>
								</div>
							</div>   
						</form>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	
<?php
	$scripts='
<script type="text/javascript" src="../scripts/conta/validacao.js"></script>';
?>




