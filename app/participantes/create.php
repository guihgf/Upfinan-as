<div class="pageheader">
	<h2><i class="fa fa-users"></i> Participantes<span>cadastrar</span></h2>
	<div class="breadcrumb-wrapper">
		<span class="label">Você está em:</span>
		<ol class="breadcrumb">
		  <a href="index">Participantes</a>
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
				<h4 class="panel-title">Cadastrar Participantes</h4>
			</div>
			<div class="panel-body">
				<form id="cadastro_form" action="create_participante" method="POST">
					<div class="row">
						<div class="col-sm-3 form-group">
							<label for="nome">Nome</label>
							<input type="text" id="nome" name="nome" class="form-control"/>
						</div> 
						<div class="col-sm-3 form-group">
							<label for="telefone">Telefone</label>
							<input id="telefone" name="telefone" class="form-control"/>
						</div> 
						<div class="col-sm-3 form-group">
							<label for="celular">Celular</label>
							<input id="celular" name="celular" class="form-control"/>
						</div> 
						<div class="col-sm-3 form-group">
							<label for="email">E-mail</label>
							<input type="email" id="email" name="email" class="form-control"/>
						</div> 
					</div>
					<div class="row">
						<div class="col-sm-3 form-group">
							<label for="rua">Rua</label>
							<input type="text" id="rua" name="rua" class="form-control"/>
						</div> 
						<div class="col-sm-3 form-group">
							<label for="numero">Número</label>
							<input type="text" id="numero" name="numero" class="form-control"/>
						</div>
						<div class="col-sm-3 form-group">
							<label for="bairro">Bairro</label>
							<input type="text" id="bairro" name="bairro" class="form-control"/>
						</div>
						<div class="col-sm-3 form-group">
							<label for="cidade">Cidade</label>
							<input type="text" id="cidade" name="cidade" class="form-control"/>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3 form-group">
							<label for="nome">Complemento</label>
							<textarea id="complemento" name="complemento" class="form-control"></textarea>
						</div> 
						
					</div>
					<hr/>
					<div class="row">
						<div class="col-sm-4 form-group">
							<a href="index" class="btn btn-info">Listar Participantes</a>
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
<script type="text/javascript" src="../scripts/participante/validacao.js"></script>';
?>



