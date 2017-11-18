<?php
	require('../db/despesas_db.php');
	require('../db/conta_db.php');
	require('../db/transferencia_db.php');
    require('../../rest/Rest.inc.php');
    class TransferenciaAction extends REST {

    	function index()
		{
	        openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }

			$transferencias=$this->transferenciadb->listar_transferencias($_SESSION["usuario"]);
			
            $menu=array("transferencias"=>"active");
            $page="../transferencias/index.php";
            include('../shared/menu.inc.php');
        }
				
		function create_transferencia()
		{
	        openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }


            
			$contadb=new ContaDB();
			$contas=$contadb->listar_contas($_SESSION["usuario"],false);
			
            $menu=array("transferencias"=>"active");
            $page="../transferencias/create_transferencia.php";
            include('../shared/menu.inc.php');
        }
				       
        		
		function salvar_transferencia(){
			openSession();
			if($this->get_request_method() != "POST")
            {
                $this->response('',406);
            }

            $data_transferencia=date("Y-m-d", strtotime(str_replace('/', '-',$_POST["data_transferencia"])));

    				
			try{
				$this->transferenciadb->salvar_transferencia($_POST,$data_transferencia);
				$_SESSION["msg"]="Transferência salva com sucesso";
				$_SESSION["tipo_msg"]=1;
			}
			catch (Exception $e)
			{
				$_SESSION["msg"]="Erro ao salvar a transferência: ".$e->getMessage();
				$_SESSION["tipo_msg"]=2;
			}
			header("Location: index"); 
		}

		function deletar_transferencia(){
			openSession();
			if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
    				
			try{
				$this->transferenciadb->deletar_transferencia($_GET,$_SESSION["usuario"]);
				$_SESSION["msg"]="Transferência deletada com sucesso";
				$_SESSION["tipo_msg"]=1;
			}
			catch (Exception $e)
			{
				$_SESSION["msg"]="Erro ao deletar a transferência: ".$e->getMessage();
				$_SESSION["tipo_msg"]=2;
			}
			            
			header("Location: index"); 
		}
		
    }
    
    $api = new TransferenciaAction();
	$api->transferenciadb=new TransferenciaDB();
    $api->processApi();
        