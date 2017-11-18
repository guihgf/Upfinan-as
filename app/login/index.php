<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/png">

    <title>Up Finanças - Bem Vindo(a) ao seu novo controle financeiro.</title>

    <link href="../../bracket/css/style.default.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-37428163-1', 'auto');
        ga('send', 'pageview');

    </script>
</head>

<body style="background-color:white">

<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>

<div class="row">
    <?php
    //include('../shared/msg.inc.php');
    if(isset($_SESSION["msg"])){
        echo "<script>alert('".$_SESSION["msg"]."');</script>";
    }

    $_SESSION["tipo_msg"]=null;
    $_SESSION["msg"]=null;
    ?>
</div>
<section>
    <div class="signuppanel">
        <div class="row">
            <div class="col-md-7">
                <div class="signin-info">
                    <div class="logopanel">
                        <img src="../img/up.jpg" style="width:220px">
                    </div><!-- logopanel -->

                    <div class="mb20"></div>

                    <h5><strong>Bem vindo(a) ao seu novo controle financeiro.</strong></h5>
                    <ul style="padding:0px;">
                        <li style="list-style-type:none;"><i class="fa fa-arrow-circle-o-right mr5"></i>Fácil de utilizar em qualquer dispositivo.</li>
                        <li style="list-style-type:none;"><i class="fa fa-arrow-circle-o-right mr5"></i>Gerencie suas despesas em contas.</li>
                        <li style="list-style-type:none;"><i class="fa fa-arrow-circle-o-right mr5"></i>Gráficos para controle.</li>
                        <li style="list-style-type:none;"><i class="fa fa-arrow-circle-o-right mr5"></i>e muito mais...</li>
                    </ul>
                </div><!-- signin0-info -->
                <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FUp-Finan%25C3%25A7as%2F816592375050007&amp;width=441&amp;height=240&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;appId=729980113722350" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:290px;" allowTransparency="true"></iframe>

            </div><!-- col-sm-7 -->

            <div class="col-md-5">
                <form id="login_form" method="post" action="autenticar">
                    <h4 class="nomargin">Olá.</h4>
                    <p class="mt5 mb20">Informe e-mail e senha para acessar.</p>

                    <div class="mb10">
                        <label class="control-label">E-mail</label>
                        <input id="email" name="email" type="text" class="form-control" />

                    </div>

                    <div class="mb10">
                        <label class="control-label">Senha</label>
                        <input id="senha" name="senha" type="password" class="form-control" />
                    </div>

                    <a id="recuperar_senha" href="#"><small>Esqueceu a sua senha?</small></a><br/>
                    <a id="recuperar_senha" href="cadastro"><small>Novo usuário? Cadastre Aqui.</small></a>
                    <button class="btn btn-success btn-block">Entrar</button>
                    <a class="btn btn-darkblue btn-block" href="https://www.facebook.com/dialog/oauth?client_id=729980113722350&redirect_uri=http://www.upfinancas.com.br/sistema/app/login/index&scope=email,public_profile"><i class="fa fa-facebook-square"></i> Entrar com Facebook</a>
                </form>
            </div><!-- col-sm-5 -->

        </div><!-- row -->
        <div class="row">
            <p >
                <h2 style="text-align: center;">IMPORTANTE!</h2>
            </p>
            <p style="text-align: justify;">
                O site <a href="http://www.upconsultoriafinanceira.com/contato">http://www.upconsultoriafinanceira.com/contato</a> representado pela empresa Uptrend Consultoria Econômica Financeira-LTDA,
                vem utilizando o logo do Up Finanças de modo indevido, sem a minha autorização (Guilherme Fermino), em propostas de empréstimos. O Up Finanças é apenas um controle financeiro pessoal,
                não realizo empréstimos de qualquer espécie e nem mesmo tenho <b>QUALQUER</b> tipo de participação nessa empresa.
            </p>
            <p style="text-align: justify;">
                Hoje(28/09/2016), uma pessoa entrou em contato solicitando retorno sobre uma prosposta de empréstimo na qual ela havia adiantado um valor já.
            </p>
            <p style="text-align: justify;">
                Pessoal, pesquisem muito antes de realizar qualquer acordo financeiro como deste caso!
            </p>
        </div>

        <div class="signup-footer">
            <div class="pull-left">
                &copy; <?= date('Y')?>. Up Finanças
            </div>
        </div>

        <div class="modal fade" id="modalAviso" tabindex="-1" role="dialog" aria-labelledby="modalAvisoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="modalAvisoLabel">Comunicado aos usuários do sistema antigo</h4>
                    </div>
                    <div class="modal-body"  style="height:470px;overflow-y:auto">
                        <p>Olá meus amigos e amigas.</p>
                        <p>É com grande prazer que lhes apresento a nova versão do Up Finanças. O sistema está com uma cara totalmente
                            nova, mais moderno e com um layout responsivo no qual permite que você acesse de maneira fluída o sistema em seu computador, notebook, tablet, tv e em seu celular.</p>

                        <p>Para esse novo site, foi utilizado tecnologias diferentes da versão anterior, o que impossibilitou que os dados da versão anterior fossem migrados para a versão atual,
                            até porque a estrutura do sistema foi alterada. Com isso, deixo disponível o site antigo em <a href="http://www.upfinancas.tk">upfinancas.tk</a> até o final do mês de outubro de 2014. Assim meus amigos, você podem fazer um "apanhado" geral de suas
                            receitas e despesas e já lançar no site novo, basta vocês fazerem um novo cadastro <a href="cadastro">aqui</a>.</p>

                        <p>Para quem já gostava do antigo Up, irá gostar ainda mais, o novo sistema terá ainda mais funcionalidades que o anterior, pois com o novo layout poderei trazer muito mais funcionalidades mais facilmente.</p>

                        <p>Espero que gostem, qualquer problema, entre em contato através do e-mail <b>contato@upfinancas.com.br</b>.</p>
                    </div>
                    <div class="modal-footer">
                        <button id="btSair" type="button" class="btn btn-danger"  data-dismiss="modal" >Sair</button>
                    </div>
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- modal -->

    </div><!-- signin -->

</section>


<script src="../../bracket/js/jquery-1.10.2.min.js"></script>
<script src="../../bracket/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../scripts/login/validacao.js"></script>
<script src="../../bracket/js/jquery-migrate-1.2.1.min.js"></script>
<script src="../../bracket/js/bootstrap.min.js"></script>
<script src="../../bracket/js/modernizr.min.js"></script>
<script src="../../bracket/js/retina.min.js"></script>
<script src="../../bracket/js/custom.js"></script>
<!--<script type="text/javascript">
  $('#modalAviso').modal('show');
</script>-->




</body>
</html>