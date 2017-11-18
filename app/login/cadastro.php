<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="../img/favicon.ico" type="image/png">

  <title>Up Finanças - Faça o seu cadastro aqui</title>

  <link href="../../bracket/css/style.default.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>

<body style="background-color:white">

<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>

<section>
  
    <div class="signuppanel">
        
        <div class="row">
            
            <div class="col-md-6">
                
                <div class="signup-info">
                    <p>O novo Up Finanças foi planejado pensando totalmente em você. Com novo layout o Up irá lhe surpreender. As novidades são:</p>
                    <div class="mb20"></div>
                    
                    <div class="feat-list">
                        <i class="fa fa-compress"></i>
                        <h4 class="text-success">Layout Responsivo</h4>
                        <p>Opere suas despesas e receitas em qualquer resolução de tela, do seu computador até o seu celular.</p>
                    </div>
					
					<div class="feat-list">
                        <i class="fa fa-compress"></i>
                        <h4 class="text-success">Mais rápido</h4>
                        <p>Navegue entre as páginas do sistema mais rapidamente com o nosso novo menu.</p>
                    </div>

                    <div class="feat-list">
                        <i class="fa fa-file-text-o"></i>
                        <h4 class="text-success">Contas estão para vencer?</h4>
                        <p>Fique tranquilo, o UP lhe mostrará as contas que estão para vencer.</p>
                    </div>

                    <div class="feat-list">
                        <i class="fa fa-credit-card"></i>
                        <h4 class="text-success">Você gasta muito com cartão de crédito?</h4>
                        <p>Com o Up você enxergará se a maioria das sua compras são feitas nessa modalidade.</p>
                    </div>
                                        
                    <h4 class="mb20">e muito mais..</h4>
                
                </div><!-- signup-info -->
            
            </div><!-- col-sm-6 -->
            
            <div class="col-md-6">
                
                <form method="post" action="create_usuario" id="cadastro_form">             

                    <h3 class="nomargin">Criar uma conta</h3>
                    <p class="mt5 mb20">Já possui conta no Up? <a href="index"><strong>Entre aqui.</strong></a></p>
                
                    
                    <div class="mb10">
                        <label class="control-label">Nome:</label>
                        <input id="nome" name="nome" type="text" class="form-control" />
                        
                    </div>
                    
                    <div class="mb10">
                        <label class="control-label">Email:</label>
                        <input id="email" name="email" type="email" class="form-control" />
                    </div>

                    <div class="mb10">
                        <label class="control-label">Confirme o e-mail:</label>
                        <input id="confirmar_email" name="confirmar_email" type="email" class="form-control" />
                    </div>
                    
                    <div class="mb10">
                        <label class="control-label">Senha</label>
                        <input id="senha" name="senha" type="password" class="form-control" />
                    </div>
                    
                    <div class="mb10">
                        <label class="control-label">Repita a  Senha</label>
                        <input id="confirmar_senha" name="confirmar_senha" type="password" class="form-control" />
                    </div>

                    <div class="mb10">
                        <label for="captcha" class="control-label">Informe o resultado da soma</label><br/>
                        <input id="num1" class="col-md-3" type="text" name="num1" value="<?php echo rand(1,4) ?>" readonly="readonly" />
                        <label class="col-md-1">+</label>
                        <input id="num2" class="col-md-3" type="text" name="num2" value="<?php echo rand(5,9) ?>" readonly="readonly" /> 
                        <label class="col-md-1">=</label>
                        <input id="captcha" class="captcha col-md-3" type="text" name="captcha" maxlength="2" /><br/>
                    </div>

                    
                    <br />
                    
                    <button class="btn btn-success btn-block">Criar a conta</button>   
                    <a class="btn btn-darkblue btn-block" href="https://www.facebook.com/dialog/oauth?client_id=729980113722350&redirect_uri=http://www.upfinancas.com.br/sistema/app/login/index&scope=email,public_profile"><i class="fa fa-facebook-square"></i> Criar conta com Facebook</a>    
                </form>
            </div><!-- col-sm-6 -->
            
        </div><!-- row -->
        
        <div class="signup-footer">
            <div class="pull-left">
                &copy; <?= date('Y')?>. Upfinanças
            </div>
        </div>
        
    </div><!-- signuppanel -->
  
</section>


<script src="../../bracket/js/jquery-1.10.2.min.js"></script>
<script src="../../bracket/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../scripts/login/validacao.js"></script>
<script src="../../bracket/js/jquery-migrate-1.2.1.min.js"></script>
<script src="../../bracket/js/bootstrap.min.js"></script>
<script src="../../bracket/js/modernizr.min.js"></script>
<script src="../../bracket/js/retina.min.js"></script>
<script src="../../bracket/js/custom.js"></script>

</body>
</html>