<?php

require('../db/relatorios_db.php');

require('../../rest/Rest.inc.php');

require('../db/conta_db.php');

class RelatorioAction extends REST
{
    public $relatoriodb;

    function extrato()
    {
        openSession();

        if ($this->get_request_method() != "GET") {

            $this->response('', 406);

        }

        $contadb = new ContaDB();

        $contas = $contadb->listar_contas($_SESSION["usuario"], false);

        $menu = array("relatorios" => "active", "extrato" => "active");

        $page = "../relatorios/extrato.php";

        include('../shared/menu.inc.php');

    }

    function extrato_pdf()
    {
        openSession();

        if ($this->get_request_method() != "GET") {

            $this->response('', 406);

        }

        $usuario = $_SESSION['usuario'];

        $conta = $_GET["conta"];

        $data_ini = date("Y-m-d", strtotime(str_replace('/', '-', $_GET["data_ini"])));

        $data_fim = date("Y-m-d", strtotime(str_replace('/', '-', $_GET["data_fim"])));


        $extrato = $this->relatoriodb->extrato($usuario, $conta, $data_ini, $data_fim);

        include('extrato_pdf.php');
    }
}

$api = new RelatorioAction();
$api->relatoriodb = new RelatorioDB();
$api->processApi();
?>

