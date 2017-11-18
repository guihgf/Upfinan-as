<?php
	require('../db/conta_db.php');
    require('../../rest/Rest.inc.php');
    
    class ContaAction extends REST {
		public $contadb;
				
        function index(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            $contas=$this->listar_contas();  
			$menu=array("cadastro"=>"active","contas"=>"active");
            $page="../contas/index.php";
            include('../shared/menu.inc.php');

        }

        function create(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
			$menu=array("cadastro"=>"active","contas"=>"active");
            $page="../contas/create.php";
            include('../shared/menu.inc.php');
        }
        
        function edit(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            try{
               
                $conta=$this->contadb->selecionar_conta($_SESSION["usuario"],$_GET["id"]);
             
            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao exibir a conta: ".$ex->getMessage();
                $_SESSION["tipo_msg"]=2;
                $conta= array();
            }
			$menu=array("cadastro"=>"active","contas"=>"active");
            $page="../contas/edit.php";

            include('../shared/menu.inc.php');
        }
       
        function listar_contas(){            

            try{
				
				return $this->contadb->lista_contas_pag($_SESSION["usuario"]);
                 
            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao listar as contas: ".$ex->getMessage();
                $_SESSION["tipo_msg"]=2;
                return array();
            }
  
        }
        
        function create_conta(){
            openSession();
            if($this->get_request_method() != "POST")
            {
                $this->response('',406);
            }
            try
            {
                if($_POST["padrao"]==2){
                    $this->contadb->retirar_padroes($_SESSION["usuario"]);
                }
                
				$this->contadb->inserir_conta($_SESSION["usuario"],$_POST,$_SESSION["plano"]);
				
				$_SESSION["msg"]="Conta salva com sucesso";
				$_SESSION["tipo_msg"]=1;
            }
            catch (Exception $e)
            {
                $_SESSION["msg"]="Erro ao salvar a conta: ".$e->getMessage();
                $_SESSION["tipo_msg"]=2;
            }
            header("Location: index");
        }
        
        function edit_conta(){
            openSession();
            if($this->get_request_method() != "POST")
            {
                $this->response('',406);
            }
            try
            {
				
				if($_POST["padrao"]==2){
					$this->contadb->retirar_padroes($_SESSION["usuario"]);
				}
                $this->contadb->alterar_conta($_SESSION["usuario"],$_POST);
                $_SESSION["msg"]="Conta salva com sucesso";
                $_SESSION["tipo_msg"]=1;
            }
            catch (Exception $e)
            {
                $_SESSION["msg"]="Erro ao salvar a conta: ".$e->getMessage();
                $_SESSION["tipo_msg"]=2;
            }
            $conn=null;
            header("Location: index");
        }
        
        
        function status_conta(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            } 
            try
            {
                $this->contadb->atualizar_status_conta($_SESSION["usuario"],$_GET["id"],$_GET["status"]);
                if($_GET["status"]==2)
                {
                    $_SESSION["msg"]="Conta desativada com sucesso.";
                }
                else{
                    $_SESSION["msg"]="Conta ativada com sucesso.";
                }
                
                $_SESSION["tipo_msg"]=1;
            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao salvar a conta: ".$ex->getMessage();
                $_SESSION["tipo_msg"]=2;
            }
            header("Location: index");  
        }

		function list_contas_saldo(){
			openSession();
			if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            } 
			echo json_encode($this->contadb->listar_contas($_SESSION["usuario"],true));
		}

		function conta_saldo(){
			openSession();
			if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
			$saldos=$this->contadb->saldo_conta($_SESSION["usuario"],$_GET["conta_id"]);
			$saldos["SALDO"]= "R$".number_format($saldos["SALDO"], 2, ',', '.');
			$saldos["SALDO_SEMANA"]="R$".number_format($saldos["SALDO_SEMANA"], 2, ',', '.');
			$saldos["SALDO_MES"]="R$".number_format($saldos["SALDO_MES"], 2, ',', '.');
			echo json_encode($saldos); 
		}

        function agenda_lancamentos_contas(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            $agenda=$this->contadb->agenda_lancamentos_contas($_SESSION["usuario"],$_GET["conta_id"]);
            echo json_encode($agenda);
        }

        function deletar_conta(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            try
            {
                $this->contadb->deletar_conta($_SESSION["usuario"],$_GET["codigo"]);
                $_SESSION["msg"]="Conta deletada com sucesso";
                $_SESSION["tipo_msg"]=1;
            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao deletar a conta: ".$ex->getMessage();
                $_SESSION["tipo_msg"]=2;
            }
            header("Location: index"); 
            
        }
    }
    
    $api = new ContaAction();
	$api->contadb=new ContaDB();
    $api->processApi();
	
        
