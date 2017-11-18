<div class="pageheader">
	<h2><i class="fa fa-users"></i> Participantes<span>editar</span></h2>
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
			  <h4 class="panel-title">Editar Participantes</h4>
			</div>
			<div class="panel-body">
				<form id="cadastro_form" action="edit_participante" method="POST">
					<input type="hidden" id="codigo" name="codigo" value="<?php echo $participante["CODIGO"]?>" />
					<div class="row">
						<div class="col-sm-3 form-group">
							<label for="nome">Nome</label>
							<input type="text" id="nome" name="nome" value="<?php echo $participante["NOME"]?>" class="form-control"/>
						</div> 
						<div class="col-sm-3 form-group">
							<label for="telefone">Telefone</label>
							<input id="telefone" name="telefone" value="<?php echo $participante["TELEFONE"]?>"  class="form-control"/>
						</div> 
						<div class="col-sm-3 form-group">
							<label for="celular">Celular</label>
							<input id="celular" name="celular" value="<?php echo $participante["CELULAR"]?>"  class="form-control"/>
						</div> 
						<div class="col-sm-3 form-group">
							<label for="email">E-mail</label>
							<input type="email" id="email" name="email" value="<?php echo $participante["EMAIL"]?>"  class="form-control"/>
						</div> 
					</div>
					<div class="row">
						<div class="col-sm-3 form-group">
							<label for="rua">Rua</label>
							<input type="text" id="rua" name="rua" value="<?php echo $participante["RUA"]?>" class="form-control"/>
						</div> 
						<div class="col-sm-3 form-group">
							<label for="numero">Número</label>
							<input type="text" id="numero" name="numero" value="<?php echo $participante["NUMERO"]?>"  class="form-control"/>
						</div>
						<div class="col-sm-3 form-group">
							<label for="bairro">Bairro</label>
							<input type="text" id="bairro" name="bairro" value="<?php echo $participante["BAIRRO"]?>"  class="form-control"/>
						</div>
						<div class="col-sm-3 form-group">
							<label for="cidade">Cidade</label>
							<input type="text" id="cidade" name="cidade"  value="<?php echo $participante["CIDADE"]?>"  class="form-control"/>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3 form-group">
							<label for="nome">Complemento</label>
							<textarea id="complemento" name="complemento" class="form-control"><?php echo $participante["COMPLEMENTO"]?></textarea>
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
	$scripts='<script type="text/javascript" src="../scripts/participante/validacao.js"></script>';
?>



