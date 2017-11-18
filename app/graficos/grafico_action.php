<?php
	require('../db/graficos_db.php');
    require('../../rest/Rest.inc.php');
	require('../db/conta_db.php');
    class GraficoAction extends REST {
		
		public $graficodb;
		
		function index()
		{
	        openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            
			$menu=array("lancamentos"=>"active");
            $page="../graficos/index.php";
            include('../shared/menu.inc.php');
        }
        //1
        function top_despesas_grupos(){
			openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
			$contadb=new ContaDB();
			$contas=$contadb->listar_contas($_SESSION["usuario"],false);
			$menu=array("graficos"=>"active","top_despesas_grupos"=>"active");
            $page="../graficos/top_despesas_grupos.php";
            include('../shared/menu.inc.php');
		}
		function top_despesas_grupos_graf()
		{
	        openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }

            $data_ini=date("Y-m-d", strtotime(str_replace('/', '-',$_GET["data_ini"])) );
            $data_fim=date("Y-m-d", strtotime(str_replace('/', '-',$_GET["data_fim"])) );
            
			echo json_encode($this->graficodb->top_despesas_grupos($_SESSION["usuario"],$_GET['conta'],$data_ini,$data_fim));
        }
		
		function top_despesas_grupos_det()
		{
	        openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            $data_ini=date("Y-m-d", strtotime(str_replace('/', '-',$_GET["data_ini"])) );
            $data_fim=date("Y-m-d", strtotime(str_replace('/', '-',$_GET["data_fim"])) );
            
			echo json_encode($this->graficodb->top_despesas_grupos_det($_SESSION["usuario"],$_GET['id'],$data_ini,$data_fim,$_GET['conta']));
        }

		//2
		//1
        function top_despesas_participantes(){
			openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
			$contadb=new ContaDB();
			$contas=$contadb->listar_contas($_SESSION["usuario"],false);
			$menu=array("graficos"=>"active","top_despesas_participantes"=>"active");
            $page="../graficos/top_despesas_participantes.php";
            include('../shared/menu.inc.php');
		}
		function top_despesas_participantes_graf()
		{
	        openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }

            $data_ini=date("Y-m-d", strtotime(str_replace('/', '-',$_GET["data_ini"])) );
            $data_fim=date("Y-m-d", strtotime(str_replace('/', '-',$_GET["data_fim"])) );
            
			echo json_encode($this->graficodb->top_despesas_participantes($_SESSION["usuario"],$_GET['conta'],$data_ini,$data_fim));
        }


		function top_despesas_participantes_det()
		{
	        openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            $data_ini=date("Y-m-d", strtotime(str_replace('/', '-',$_GET["data_ini"])) );
            $data_fim=date("Y-m-d", strtotime(str_replace('/', '-',$_GET["data_fim"])) );
			echo json_encode($this->graficodb->top_despesas_participantes_det($_SESSION["usuario"],$_GET['id'],$data_ini,$data_fim,$_GET['conta']));
        }
		
		function saldo_mes(){
			openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
			$contadb=new ContaDB();
			$contas=$contadb->listar_contas($_SESSION["usuario"],false);
			$menu=array("graficos"=>"active","saldo_mes"=>"active");
            $page="../graficos/saldo_mes.php";
            include('../shared/menu.inc.php');
		}
				
		function saldo_mes_action(){
			openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            
			echo json_encode($this->graficodb->saldo_mes($_SESSION["usuario"],$_GET['conta'],$_GET['ano']));
		}
		
		function saldo_mes_anos(){
			openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
			$contadb=new ContaDB();
			$contas=$contadb->listar_contas($_SESSION["usuario"],false);
			$menu=array("graficos"=>"active","saldo_mes_ano"=>"active");
            $page="../graficos/saldo_mes_ano.php";
            include('../shared/menu.inc.php');
		}
		
		function saldo_mes_ano_action(){
			openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
			
			$arr[0]=$this->graficodb->saldo_mes($_SESSION["usuario"],$_GET['conta'],$_GET['ano']);
			$arr[1]=$this->graficodb->saldo_mes($_SESSION["usuario"],$_GET['conta'],$_GET['ano2']);
			//$arr["ANO2"]=$this->graficodb->saldo_mes($_SESSION["usuario"],$_GET['conta'],$_GET['ano2']);
			
			echo json_encode($arr);
		}
		
    }
    
    $api = new GraficoAction();
	$api->graficodb=new GraficoDB();
    $api->processApi();
?>        
