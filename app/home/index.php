	<div class="pageheader">
		<h2><i class="fa fa-home"></i> Home<span></span></h2>
		<div class="breadcrumb-wrapper">
			<span class="label">Você está em:</span>
			<ol class="breadcrumb">
			  <li><a href="../home/index">Home</a></li>
			</ol>
		</div>
	</div>
	<div class="contentpanel">
		<div class="row">
			<?php
				include('../shared/msg.inc.php');
				include('../shared/instrucoes.inc.php');
			?>
		</div>
		<ul class="nav nav-tabs nav-justified" id="home_tabs">
          <li class="active"><a href="#resumo" data-toggle="tab"><b>Resumo de receitas e despesas neste mês em R$.</b></a></li>
          <?php
          if($_SESSION["plano"]==1){?>
          	<li class=""><a href="#calendar_tab" data-toggle="tab"><b>Calendário de lançamentos</b></a></li>
          <?php
          }
          ?>
        </ul>

        <div class="tab-content">
	          <div class="tab-pane active" id="resumo">
	          	<div class="row">
					<div class="col-sm-12 col-md-12">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="row">
									<div class="form-group col-md-4">
										<label for="ch_resumo_contas_mes">Selecione uma conta:</label>
										<select id="ch_resumo_contas_mes" name="ch_resumo_contas_mes"  class="form-control" data-placeholder="Selecione a conta...">

										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6 col-md-6">
										<div class="table-responsive table-hover">
											<h5 class="subtitle" style="text-align:center;background-color: #292828;color: white;height: 20px;padding-top: 2px">Resumo de despesas no mês</h5>
											<table id="despesas_mes" class="table" style="border: 1px;border-style: dashed;">
												<thead>
												<tr>
													<th style="text-align:center">Grupo de Despesa</th>
													<th style="text-align:center">Valor</th>
												</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div>

									</div>
									<div class="col-sm-6 col-md-6">
										<div class="table-responsive table-hover">
											<h5 class="subtitle" style="text-align:center;background-color: #292828;color: white;height: 20px;padding-top: 2px">Resumo de receitas no mês</h5>
											<table id="receita_mes" class="table" style="border: 1px;border-style: dashed;">
												<thead>
												<tr>
													<th style="text-align:center">Grupo de Receita</th>
													<th style="text-align:center">Valor</th>
												</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
	          </div>
	          <div class="tab-pane" id="calendar_tab">
	          	<div class="row">
	          		<div class=" col-md-4">
		          		<label for="ch_calendario">Selecione uma conta:</label>
							<select id="ch_calendario" name="ch_calendario"  class="form-control" data-placeholder="Selecione a conta...">
							</select>
					</div>
					<div class=" col-md-8">
						<span class="label label-success">Receitas</span>
						<span class="label label-warning">Despesas em aberto</span>
						<span class="label label-danger">Despesas já vencidas</span>
						<span class="label label-primary">Despesas Pagas </span>
					</div>

				</div>
				<br/>
				<div class="row">
					<div id="calendar"></div>
				</div>

	          </div>

        </div>

	</div>

<script type="text/javascript">

	<?php
	$scripts='<script type="text/javascript" src="../scripts/home/validacao.js"></script>
			  <script src="../../fullcalendar-2.1.1/lib/moment.min.js"></script>
				<script src="../../fullcalendar-2.1.1/lib/jquery-ui.custom.min.js"></script>
				<script src="../../fullcalendar-2.1.1/fullcalendar.js"></script>
				<script src="../../fullcalendar-2.1.1/lang/pt-br.js"></script>
	';?>

</script>