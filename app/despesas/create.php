<div class="pageheader">
	<h2><i class="glyphicon glyphicon-minus"></i> Despesas<span>nova</span></h2>
	<div class="breadcrumb-wrapper">
		<span class="label">Você está em:</span>
		<ol class="breadcrumb">
		  <a href="index">Despesas</a>
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
			  <h4 class="panel-title">Lançar nova despesa(saídas)</h4>
			</div>
			<div class="panel-body">
				<form id="cadastro_form" action="create_despesa" method="POST" onsubmit="desmascararValor()">
					<div class="row">
						<div class="col-md-3 form-group">
								<label for="nome">Nome</label>
								<input type="text" id="nome" name="nome" class="form-control"/>
						</div> 
						<div class="col-md-3 form-group">
							<label for="data_vencimento">Data Vencimento</label>
							<input type="text" class="form-control" placeholder="dd/mm/yyyy" id="data_vencimento" name="data_vencimento" value="<?php echo date('d/m/Y');?>">
							<!-- <div class="input-group">
								<input type="text" class="form-control" placeholder="dd/mm/yyyy" id="data_vencimento" name="data_vencimento" value="<?php echo date('d/m/Y');?>">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							</div> -->
						</div>  
						<div class="col-md-3 form-group">
							<label for="valor">Parcelas</label>
							<input type="number" id="parcela" name="parcela" step="any" class="form-control" value="1" />
						</div> 
						<div class="col-md-3 form-group">
							<label for="valor">Valor</label>
								<input type="text" id="valor" name="valor"  class="form-control" value=0/>
						</div>   
					</div>
					<div class="row">	
						<div class="col-md-3 form-group">
							<label for="tipo_pagamento">Tipo de Pagamento (<a href="../tipos_pagamentos/create" title="Novo tipo de pagamento"><i class="fa fa-plus"></i></a>)</label>
							<select id="tipo_pagamento" name="tipo_pagamento" data-placeholder="Selecione o tipo de pagamento..." class="form-control chosen-select">
								<option value=""></option>
								<?php

									foreach ($tipos_pagamento as $row) {
									
										echo '<option value="'.$row['CODIGO'].'">'.$row['NOME'].'</option>';
									}
								?>
							</select>
						</div>

						<div class="col-md-3 form-group">
							<label for="busca_contas">Conta (<a href="../contas/create" title="Nova conta"><i class="fa fa-plus"></i></a>)</label>
							<select id="busca_conta" name="busca_conta"  class="form-control chosen-select col-md-3" data-placeholder="Selecione a conta...">
							
								<?php
									foreach ($contas as $row) {
									
										echo '<option value="'.$row['CODIGO'].'">'.$row['NOME'].'</option>';
									}
								?>
							</select>
						</div>

						<div class="col-md-3 form-group">
							<label for="busca_grupos">Grupo de despesas (<a href="../grupos/create" title="Novo grupo de despesa"><i class="fa fa-plus"></i></a>)</label>
							<select id="busca_grupos" name="busca_grupos"  class="form-control chosen-select" data-placeholder="Selecione o grupo...">
								<option></option>
								<?php
									foreach ($grupos as $row) {
									
										echo '<option value="'.$row['CODIGO'].'">'.$row['NOME'].'</option>';
									}
								?>
							</select>
						</div>
						<div class="col-md-3 form-group">
							<label for="busca_participantes">Participante (<a href="../participantes/create" title="Novo participante"><i class="fa fa-plus"></i></a>)</label>
							<select id="busca_participantes" name="busca_participantes" data-placeholder="Selecione o participante..." class="form-control chosen-select">
								<option></option>
								<?php

									foreach ($participantes as $row) {
									
										echo '<option value="'.$row['CODIGO'].'">'.$row['NOME'].'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 form-group">
							<label for="pago">Despesa já paga?</label>
							<select id="pago" name="pago" class="form-control">
								<option value="N" selected>Não</option>
								<option value="S">Sim</option>
							</select>
						</div>
						<div class="col-md-3 form-group">
							<label for="data_pagamento">Data Pagamento</label>
							<input type="text" class="form-control" placeholder="dd/mm/yyyy" id="data_pagamento" name="data_pagamento">
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
							<a href="index" class="btn btn-info">Listar Despesas</a>
							<input type="submit" class="btn btn-success" value="Salvar"/>
						</div>
					</div>   
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	
</script>
<?php
	$scripts="<script type=text/javascript src=../scripts/despesas/validacao.js></script>
	";
?>
