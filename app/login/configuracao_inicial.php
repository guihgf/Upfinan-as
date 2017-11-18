<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="../img/favicon.ico" type="image/ico">

  <title>Up Finanças - Bem Vindo(a) ao seu novo controle financeiro.</title>

  <link href="../../bracket/css/style.default.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>
<body style="display: inline-block;" >
  <div class="col-md-3"></div>
  <div class="col-md-6 style="  vertical-align: middle;"">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">Configuração Inicial.</h4>
        <p>Olá, primeiramente vamos configurar a sua conta.</p>
      </div>
      <div class="panel-body panel-body-nopadding">
        
        <!-- BASIC WIZARD -->
        <div id="progressWizard" class="basic-wizard">
          
          <ul class="nav nav-pills nav-justified">
            <li><a href="#ptab1" data-toggle="tab"><span>1º Passo: </span>Seus Dados</a></li>
            <li><a href="#ptab2" data-toggle="tab"><span>2º Passo: </span>Conta Principal</a></li>
            <!--<li><a href="#ptab3" data-toggle="tab"><span>Step 3:</span> Payment</a></li>-->
          </ul>
            
            <form id="dados_gerais" class="form"  action="finalizar_cadastro" method="POST">
              <div class="tab-content">
            
                <div class="progress progress-striped active">
                  <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="tab-pane" id="ptab1">

                    <div class="form-group">
                      <label class="col-sm-4">Email</label>
                      <div class="col-sm-8">
                        <input type="text" id="email" name="email" class="form-control" value="<?php echo  $_SESSION['email'] ?>" />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-4">Nome Completo</label>
                      <div class="col-sm-8">
                        <input type="text" id="nome" name="nome" class="form-control" value="<?php echo  $_SESSION['nome_usuario'] ?>" />
                      </div>
                    </div>
                                    
                    <div class="form-group">
                      <label class="col-sm-4">Sexo</label>
                      <div class="col-sm-8">
                        <div class="rdio rdio-primary">
                          <input type="radio" id="male2" value="m" name="sexo" checked>
                          <label for="male2">Masculino</label>
                        </div>
                        <div class="rdio rdio-primary">
                          <input type="radio" value="f" id="female2" name="sexo">
                          <label for="female2">Feminino</label>
                        </div>
                      </div>
                    </div>
                 
                </div>
                <div class="tab-pane" id="ptab2">
                    <p>No Up Finanças todas as duas despesas e entradas são feitas em uma conta (assim como a sua conta bancária). Informe o nome da sua conta principal:</p>
                    <div class="form-group">
                      <label class="col-sm-4">Nome da conta</label>
                      <div class="col-sm-8">
                        <input type="text" id="conta" name="conta" class="form-control" />
                      </div>
                    </div>
                    

                </div> 
              </div><!-- tab-content -->
            </form>          

          
          <ul class="pager wizard">
              <li class="previous"><a href="javascript:void(0)">Anterior</a></li>
              <li class="next"><a href="javascript:void(0)">Próxima</a></li>
              <li class="finish" style="display:none; float:right"><a href="javascript:;">Finalizar</a></li>
          </ul>
          
        </div><!-- #basicWizard -->
        
      </div><!-- panel-body -->
    </div><!-- panel -->
  </div><!-- col-md-6 -->
<div class="col-md-3"></div>
<script src="../../bracket/js/jquery-1.10.2.min.js"></script>
  <script src="../../bracket/js/jquery-migrate-1.2.1.min.js"></script>
  <script src="../../bracket/js/bootstrap.min.js"></script>
  <script src="../../bracket/js/jquery-ui-1.10.3.min.js"></script>
  <script src="../../bracket/js/datepicker-pt-BR.js"></script>
  <script src="../../bracket/js/modernizr.min.js"></script>
  <script src="../../bracket/js/jquery.sparkline.min.js"></script>
  <script src="../../bracket/js/toggles.min.js"></script>
  <script src="../../bracket/js/retina.min.js"></script>
  <script src="../../bracket/js/jquery.cookies.js"></script>

  <!--<script src="../../bracket/js/jquery.autogrow-textarea.js"></script>
  <script src="../../bracket/js/bootstrap-fileupload.min.js"></script>-->
  <!--<script src="../../bracket/js/bootstrap-timepicker.min.js"></script>-->
  <script src="../../bracket/js/jquery.maskedinput.min.js"></script>
  <script src="../../bracket/js/jquery.validate.min.js"></script>
  <!--<script src="../../bracket/js/jquery.tagsinput.min.js"></script>-->
  <script src="../../bracket/js/jquery.mousewheel.js"></script>
  <script src="../../bracket/js/chosen.jquery.min.js"></script>
  <script src="../../bracket/js/dropzone.min.js"></script>
  <script src="../../bracket/js/colorpicker.js"></script>
  <script src="../../bracket/js/bootstrap-wizard.min.js"></script>
  <script src="../../bracket/js/custom.js"></script>



<script>
  $( "#data_nascimento" ).datepicker();
   $('.finish').click(function() {
      if($("#dados_gerais").valid()){
          $("#dados_gerais").submit();
      }
    });

    $("#dados_gerais").validate({
        rules: {
                nome: "required",
                email: {
                        required: true,
                        email: true
                    },
                conta:"required",
                valor:"required"
        },
        messages: {
                nome: "Informe o nome do lançamento.",
                email:{
                        required:"Informe o e-mail.",
                        email:"Por favor informe um e-mail válido."
                    },
                conta: "Digite o nome da sua conta padrão.",
                valor:"Digite um valor inicial."
        }
    });
  jQuery(document).ready(function(){
    
    // Progress Wizard
    $('#progressWizard').bootstrapWizard({
      'nextSelector': '.next',
      'previousSelector': '.previous',
      onNext: function(tab, navigation, index) {
        var $total = navigation.find('li').length;
        var $current = index+1;
        var $percent = ($current/$total) * 100;

        if(!$("#dados_gerais").valid()){
          return false;

        }

          jQuery('#progressWizard').find('.progress-bar').css('width', $percent+'%');

          if($percent==100) {
            $('.next').hide();
            $('.finish').removeClass('disabled');
            $('.finish').show();

          } 
          else {
            $('.next').show();
            $('.finish').hide();
          }
      },
      onPrevious: function(tab, navigation, index) {
        var $total = navigation.find('li').length;
        var $current = index+1;
        var $percent = ($current/$total) * 100;

        if(!$("#dados_gerais").valid()){
          return false;
        }

        jQuery('#progressWizard').find('.progress-bar').css('width', $percent+'%');
        $('.next').show();
        $('.finish').hide();
      },
      onTabClick:function(tab, navigation, index) {
        if(!$("#dados_gerais").valid()){
          return false;
        }
      },
      onTabShow: function(tab, navigation, index) {
        var $total = navigation.find('li').length;
        var $current = index+1;
        var $percent = ($current/$total) * 100;

        jQuery('#progressWizard').find('.progress-bar').css('width', $percent+'%');
          if($percent==100) {
            $('.next').hide();
            $('.finish').removeClass('disabled');
            $('.finish').show();

          } 
          else {
            $('.next').show();
            $('.finish').hide();
          }

      }
    });

   
      
  });
</script>
</body>
</html>