<div class="pageheader">
	<h2><i class="fa  fa-file-text-o"></i> Grupos de despesas<span>cadastrar</span></h2>
	<div class="breadcrumb-wrapper">
		<span class="label">Você está em:</span>
		<ol class="breadcrumb">
		  <a href="index">Grupos de despesas</a>
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
			    <h4 class="panel-title">Cadastrar grupos de despesas</h4>
			</div>
			<div class="panel-body">
				<form id="cadastro_form" action="create_grupo" method="POST">
					<div class="row">
						<div class="col-sm-4 form-group">
			                    <label for="nome">Nome</label>
			                    <input type="text" id="nome" name="nome" class="form-control"/>
			            </div> 
					</div>
					<hr/>
					<div class="row">
						<div class="col-sm-4 form-group">
							<a href="index" class="btn btn-info">Listar Grupos</a>
							<input type="submit" class="btn btn-success" value="Salvar"/>
						</div>
					</div>   
			    </form>	
			</div>
		</div>
	</div>
    
</div>


<?php
	$scripts='<script type="text/javascript" src="../scripts/grupo/validacao.js"></script>';
?>

