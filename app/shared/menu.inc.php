<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/png">

    <title></title>

    <link href="../../bracket/css/style.default.css" rel="stylesheet">
    <link rel="stylesheet" href="../../bracket/css/jquery.datatables.css">
    <link href="../../fullcalendar-2.1.1/fullcalendar.css" rel="stylesheet">
    <link href="../layout/layout.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>

<section>

    <div class="leftpanel">

        <div class="logopanel" style="padding:10px 0px 10px 28px">
            <img src="../img/up_beta.jpg" title="Up Finanças" style=" height: 60px; width: 180px;">
        </div>
        <!-- logopanel -->

        <div class="leftpanelinner">

            <!-- This is only visible to small devices -->
            <div class="visible-xs hidden-sm hidden-md hidden-lg">
                <div class="media userlogged">
                    <div class="media-body">
                        <h4><?php echo $_SESSION["nome_usuario"] ?></h4>
                        <span><?php echo $_SESSION["email"] ?></span>
                    </div>
                </div>

                <h5 class="sidebartitle actitle">Ações</h5>
                <ul class="nav nav-pills nav-stacked nav-bracket mb30">

                    <li><a href="#"
                           onClick="alert('Para dúvidas, criticas e sugestões, envie e-mail para suporte@upfinancas.com.br que assim que possível responderei.')"><i
                                class="fa fa-comments-o"></i> <span>Contato</span></a></li>
                    <?php
                    if ($_SESSION["facebook_user"] == "N") {
                        echo '<li><a data-toggle="modal" data-target="#alterarSenha"><i class="glyphicon glyphicon-retweet"></i> Alterar Senha</a></li>';
                    }
                    ?>
                    <li><a href="../login/encerrar_sessao"><i class="fa fa-sign-out"></i> <span>Sair</span></a></li>
                </ul>
            </div>

            <h5 class="sidebartitle">Menu</h5>
            <ul class="nav nav-pills nav-stacked nav-bracket">
                <li class="<?php if (isset($menu["home"])) {
                    echo $menu["home"];
                } ?>"><a href="../home/index"><i class="glyphicon glyphicon-home"></i> <span>Home</span></a></li>
                <li class="nav-parent <?php if (isset($menu["receitas"])) {
                    echo $menu["receitas"];
                } ?>"><a href="#"><i class="glyphicon glyphicon-plus"></i> <span>Minhas Receitas</span></a>
                    <ul class="children" <?php if (isset($menu["receitas"])) {
                        if ($menu["receitas"] == "active") {
                            echo 'style=display:block';
                        }
                    } ?>>
                        <li class="<?php if (isset($menu["receitas"])) {
                            echo $menu["lancamentos"];
                        } ?>"><a href="../receitas/index"><i class="fa fa-caret-right"></i>Lançar Receitas</a></li>
                        <li class="<?php if (isset($menu["receitas"])) {
                            echo $menu["grupos"];
                        } ?>"><a href="../grupos_receitas/index"><i class="fa fa-caret-right"></i>Grupos de Receitas</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-parent <?php if (isset($menu["despesas"])) {
                    echo $menu["despesas"];
                } ?>"><a href="#"><i class="glyphicon glyphicon-minus"></i> <span>Minhas Despesas</span></a>
                    <ul class="children" <?php if (isset($menu["despesas"])) {
                        if ($menu["despesas"] == "active") {
                            echo 'style=display:block';
                        }
                    } ?>>
                        <li class="<?php if (isset($menu["despesas"])) {
                            echo $menu["lancamentos"];
                        } ?>"><a href="../despesas/index"><i class="fa fa-caret-right"></i>Lançar Despesas</a></li>
                        <li class="<?php if (isset($menu["despesas"])) {
                            echo $menu["grupos"];
                        } ?>"><a href="../grupos/index"><i class="fa fa-caret-right"></i>Grupos de Despesas</a></li>
                    </ul>
                </li>
                <?php
                if ($_SESSION["plano"] == 1) {
                    ?>
                    <li class="<?php if (isset($menu["transferencias"])) {
                        echo $menu["transferencias"];
                    } ?>"><a href="../transferencias/index"><i class="glyphicon glyphicon-retweet"></i> <span>Transferências</span></a>

                    </li>
                    <?php
                }
                ?>
                <li class="nav-parent <?php if (isset($menu["cadastro"])) {
                    echo $menu["cadastro"];
                } ?>"><a href="#"><i class="glyphicon glyphicon-edit"></i> <span>Cadastros em Geral</span></a>
                    <ul class="children" <?php if (isset($menu["cadastro"])) {
                        if ($menu["cadastro"] == "active") {
                            echo 'style=display:block';
                        }
                    } ?>>
                        <li class="<?php if (isset($menu["contas"])) {
                            echo $menu["contas"];
                        } ?>"><a href="../contas/index"><i class="fa fa-caret-right"></i>Contas</a></li>
                        <li class="<?php if (isset($menu["participantes"])) {
                            echo $menu["participantes"];
                        } ?>"><a href="../participantes/index"><i
                                    class="fa fa-caret-right"></i>Fontes(Participantes)</a></li>
                        <li class="<?php if (isset($menu["tipos_pagamentos"])) {
                            echo $menu["tipos_pagamentos"];
                        } ?>"><a href="../tipos_pagamentos/index"><i class="fa fa-caret-right"></i>Tipos de
                                Pagamentos</a></li>
                    </ul>
                </li>
                <li class="nav-parent <?php if (isset($menu["graficos"])) {
                    echo $menu["graficos"];
                } ?>"><a href="#"><i class="glyphicon glyphicon-signal"></i> <span>Análises em Gráficos</span></a>
                    <ul class="children" <?php if (isset($menu["graficos"])) {
                        if ($menu["graficos"] == "active") {
                            echo 'style=display:block';
                        }
                    } ?>>
                        <li class="<?php if (isset($menu["saldo_mes"])) {
                            echo $menu["saldo_mes"];
                        } ?>"><a href="../graficos/saldo_mes"><i class="fa fa-caret-right"></i>Saldos por Mês</a></li>
                        <?php if ($_SESSION["plano"] == 1) { ?>
                            <li class="<?php if (isset($menu["saldo_mes_ano"])) {
                                echo $menu["saldo_mes_ano"];
                            } ?>"><a href="../graficos/saldo_mes_anos"><i class="fa fa-caret-right"></i>Saldos por
                                    Mês(Comparando dois anos)</a></li>
                            <li class="<?php if (isset($menu["top_despesas_grupos"])) {
                                echo $menu["top_despesas_grupos"];
                            } ?>"><a href="../graficos/top_despesas_grupos"><i class="fa fa-caret-right"></i>Maiores
                                    despesas por grupos</a></li>
                            <li class="<?php if (isset($menu["top_despesas_participantes"])) {
                                echo $menu["top_despesas_participantes"];
                            } ?>"><a href="../graficos/top_despesas_participantes"><i class="fa fa-caret-right"></i>Maiores
                                    despesas por participantes</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <?php
                if ($_SESSION["plano"] == 1) {
                    ?>
                    <li class="nav-parent <?php if (isset($menu["relatorios"])) {
                        echo $menu["relatorios"];
                    } ?>"><a href="#"><i class="glyphicon  glyphicon-file"></i> <span>Relatórios</span></a>
                        <ul class="children" <?php if (isset($menu["relatorios"])) {
                            if ($menu["relatorios"] == "active") {
                                echo 'style=display:block';
                            }
                        } ?>>
                            <li class="<?php if (isset($menu["extrato"])) {
                                echo $menu["extrato"];
                            } ?>"><a href="../relatorios/extrato"><i class="fa fa-caret-right"></i>Extrato geral por
                                    conta</a></li>
                        </ul>
                    </li>
                    <?php
                }
                ?>
                <li>
                    <hr/>
                    <div id="panel_saldo" class="panel panel-primary panel-stat">

                        <div class="panel-heading">

                            <div class="stat">
                                <div class="row">
                                    <iframe
                                        src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FUp-Finan%25C3%25A7as%2F816592375050007&amp;width&amp;height=62&amp;colorscheme=light&amp;show_faces=false&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=729980113722350"
                                        scrolling="no" frameborder="0"
                                        style="border:none; overflow:hidden; height:62px;" width="100%"
                                        allowTransparency="true"></iframe>

                                    <small class="stat-label">Selecione uma conta:</small>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <select id="ch_saldo_contas" name="ch_saldo_contas" class="form-control"
                                                data-placeholder="Selecione a conta...">

                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-4">
                                        <img src="../../bracket/images/is-money.png" alt="">
                                    </div>
                                    <div class="col-xs-8">
                                        <small class="stat-label">Saldo Atual</small>
                                        <h4 id="saldo_atual">R$ 0,00</h4>
                                    </div>
                                </div>
                                <!-- row -->

                                <div class="mb15"></div>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <small class="stat-label">Saldo 7 dias atrás</small>
                                        <small id="saldo_7"><b>R$ 0,00</b></small>
                                    </div>

                                    <div class="col-xs-6">
                                        <small class="stat-label">Saldo 30 dias atrás</small>
                                        <small id="saldo_30"><b>R$ 0,00</b></small>
                                    </div>
                                </div>
                                <!-- row -->

                            </div>
                            <!-- stat -->

                        </div>
                        <!-- panel-heading -->


                    </div>
                </li>
            </ul>
        </div>
        <!-- leftpanelinner -->
    </div>
    <!-- leftpanel -->

    <div class="mainpanel">

        <div class="headerbar">

            <a class="menutoggle"><i class="fa fa-bars"></i></a>

            <div class="header-right">
                <ul class="headermenu">
                    <li>
                        <div class="btn-group">
                            <button class="btn btn-default dropdown-toggle tp-icon" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-calendar"></i>
                                <span id="total_top_5_desp" class="badge"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-head pull-right">
                                <h5 class="title">Despesas vencidas ou em aberto nos próximos 5 dias.</h5>
                                <ul id="despesas_vencidas" class="dropdown-list gen-list">
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <?php echo $_SESSION["nome_usuario"] ?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                                <li><a href="#"
                                       onClick="alert('Para dúvidas, criticas e sugestões, envie e-mail para suporte@upfinancas.com.br que assim que possível responderei.')"><i
                                            class="fa fa-comments-o"></i> <span>Contato</span></a></li>
                                <?php
                                if ($_SESSION["facebook_user"] == "N") {
                                    echo '<li><a data-toggle="modal" data-target="#alterarSenha"><i class="glyphicon glyphicon-retweet"></i> Alterar Senha</a></li>';
                                }
                                ?>

                                <li><a href="../login/encerrar_sessao"><i class="glyphicon glyphicon-log-out"></i> Sair</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- header-right -->

        </div>
        <!-- headerbar -->

        <?php
        include($page);

        ?>
        <div class="row text-center">
            <script type="text/javascript">
                google_ad_client = "ca-pub-6598394291799189";
                google_ad_slot = "3299437694";
                google_ad_width = 728;
                google_ad_height = 90;
            </script>
            <!-- cabecalho -->
            <script type="text/javascript"
                    src="//pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>
        </div>

        <div class="row text-center">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- menu_2 -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:336px;height:280px"
                 data-ad-client="ca-pub-6598394291799189"
                 data-ad-slot="1683103695"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>

    </div>
    <!-- mainpanel -->
    <div class="modal fade" id="alterarSenha" tabindex="-1" role="dialog" aria-labelledby="alterarSenha"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Alterar Senha</h4>
                </div>
                <form id='alterar_senha_form' method='post' action='../login/alterar_senha'>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="senha">Senha</label>
                                <input type="password" id="senha" name="senha" class="form-control"/>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="resenha">Repita a senha</label>
                                <input type="password" id="resenha" name="resenha" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btAlterar" type="submit" class="btn btn-primary">Alterar</button>
                    </div>
                </form>
            </div>
            <!-- modal-content -->
        </div>
        <!-- modal-dialog -->
    </div>
    <!-- modal -->
</section>

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
<script src="../../bracket/js/custom.js"></script>
<script src="../../bracket/js/jquery.datatables.min.js"></script>
<script type=text/javascript src=../scripts/jquery.price_format.2.0.min.js></script>


<?php if (isset($scripts)) {
    echo $scripts;
} ?>

<script type="text/javascript">

    $("#alterar_senha_form").validate({
        rules: {

            senha: {
                required: true,
                minlength: 5
            },
            resenha: {

                required: true,
                minlength: 5,
                equalTo: "#senha"
            }

        },
        messages: {
            senha: {
                required: "Informe a senha.",
                minlength: "Sua senha precisa ter ao menos 5 caracteres."
            },
            resenha: {
                required: "Confirme a senha.",
                minlength: "Sua senha precisa ter ao menos 5 caracteres.",
                equalTo: "Senhas não são iguais."
            }
        }
    });

    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {allow_single_deselect: true},
        '.chosen-select-no-single': {disable_search_threshold: 10},
        '.chosen-select-no-results': {no_results_text: 'Valores não encontrado.'},
        '.chosen-select-width': {width: "95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

    $("#ch_saldo_contas").change(function () {
        getSaldo($("#ch_saldo_contas").val());
    });

    function getSaldo(conta) {

        $.get("../contas/conta_saldo?conta_id=" + conta, function (data) {
            $("#saldo_atual").html($.parseJSON(data).SALDO);
            $("#saldo_7").html("<b>" + $.parseJSON(data).SALDO_SEMANA);
            $("#saldo_30").html("<b>" + $.parseJSON(data).SALDO_MES + "</b>");
            if ($.parseJSON(data).SALDO.substring(3, 2) == "-") {
                $("#saldo_atual").css("color", "red");
            }
            else {
                $("#saldo_atual").css("color", "white");
            }
        });
    }


    $.get('../contas/list_contas_saldo', function (data) {
        var i = 0;
        $.each($.parseJSON(data), function (i, item) {
            $('#ch_saldo_contas').append($('<option>', {
                value: item.CODIGO,
                text: item.NOME
            }));
        });
        getSaldo($.parseJSON(data)[0].CODIGO);
    });

    $.get('../despesas/top_5_despesas_vencidas', function (data) {
        var i = 0;
        if ($.parseJSON(data)["TOTAL"] > 0) {
            $.each($.parseJSON(data)["DESPESAS"], function (i, item) {

                var block = '<li><a href=../despesas/edit?id=' + item.CODIGO + '><span class="thumb"><img src="../../bracket/images/warn.png" alt="vencida" title="Despesas"./></span><span class="desc"><span class="name">' + item.NOME + ' - R$' + item.VALOR + '</span><span class=msg>Vencimento em: ' + item.DATA_VENCIMENTO + '</span></span></a></li>';

                $('#despesas_vencidas').append(block
                );
            });
            if ($.parseJSON(data)["TOTAL"] > 0) {
                $('#despesas_vencidas').append('<li class=new><a href="../despesas/index?tipo=1">Visualizar mais despesas...</a></li>');
            }
            $('#total_top_5_desp').html($.parseJSON(data)["TOTAL"]);
        }
        else {
            $('#despesas_vencidas').append('<li class=new>Sem lançamentos.</li>');
        }
    });

    $("#table1").dataTable({

        "sPaginationType": "full_numbers",
        "oLanguage": {
            "sEmptyTable": "Nenhum registro encontrado na tabela",
            "sInfo": "_START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrar 0 até 0 de 0 Registros",
            "sInfoFiltered": "(Filtrar de _MAX_ total registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Proximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Ultimo"
            }
        },
        "aoColumnDefs": [{
            "bSortable": true,
            "aTargets": ["_all"]
        }],
        "aaSorting": []
    });


</script>

</body>
</html>