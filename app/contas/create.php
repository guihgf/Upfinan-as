<div class="pageheader">
	<h2><i class="fa fa-money"></i> Contas<span>cadastrar</span></h2>
	<div class="breadcrumb-wrapper">
		<span class="label">Você está em:</span>
		<ol class="breadcrumb">
		  <a href="index">Contas</a>
		</ol>
	</div>
</div>
<div class="contentpanel">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			  	<div class="panel-btns">
					<a href="#" class="panel-close">&times;</a>
					<a href="#" class="minimize">&minus;</a>
			  	</div>
			  	<h4 class="panel-title">Cadastrar Contas</h4>
			</div>
			<div class="panel-body">
				<form id="cadastro_form" action="create_conta" method="POST">
					<div class="row">
						<div class="col-sm-4 form-group">
							<label for="nome">Nome</label>
							<input type="text" id="nome" name="nome" class="form-control"/>
						</div>
						<!--<div class="col-sm-4 form-group">
							<label for="data_inicio">Data Inicio</label>
							<div class="input-group">
								<input type="text" class="form-control" placeholder="dd/mm/yyyy" id="data_inicio" name="data_inicio" value="<?php echo date('d/m/Y');?>">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</div>
						<div class="col-sm-4 form-group">
							<label for="data_inicio">Data Fim</label>
							<div class="input-group">
								<input type="text" class="form-control" placeholder="dd/mm/yyyy" id="data_fim" name="data_fim"/>
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</div>-->   
						<div class="col-sm-4 form-group">
							<label for="padrao">Definir como conta Padrão?</label>
							<select id="padrao" name="padrao" class="form-control">
								<option value="1">Não</option>
								<option value="2">Sim</option>
							</select>		
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
<?php
	$scripts='
<script type="text/javascript" src="../scripts/conta/validacao.js"></script>';
?>



