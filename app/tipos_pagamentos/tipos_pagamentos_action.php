<?php
	require('../db/tipos_pagamentos_db.php');
    require('../../rest/Rest.inc.php');
    
    class TiposPagamentosAction extends REST {
		public $tipospagamentosdb;
		
        function index(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }

            $tipos_pagamentos=$this->listar_tipos_pagamentos();  

			
            $menu=array("cadastro"=>"active","tipos_pagamentos"=>"active");
            $page="../tipos_pagamentos/index.php";
            include('../shared/menu.inc.php');

        }
        function create(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            $menu=array("cadastro"=>"active","tipos_pagamentos"=>"active");
            $page="../tipos_pagamentos/create.php";
            include('../shared/menu.inc.php');
        }
        
        function edit(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            try{
				$tipo_pagamento=$this->tipospagamentosdb->selecionar_tipo_pagamento($_SESSION["usuario"],$_GET["id"]);
            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao exibir tipo de pagamento: ".$ex->getMessage();
                $_SESSION["tipo_msg"]=2;
                $tipo_pagamento= array();
            }
            $menu=array("cadastro"=>"active","tipos_pagamentos"=>"active");
            $page="../tipos_pagamentos/edit.php";
            include('../shared/menu.inc.php');
        }
        
        function edit_tipo_pagamento(){
            openSession();
            if($this->get_request_method() != "POST")
            {
                $this->response('',406);
            }
            try
            {				
				$this->tipospagamentosdb->alterar_tipo_pagamento($_SESSION["usuario"],$_POST);
                $_SESSION["msg"]="Tipo de pagamento salvo com sucesso";
                $_SESSION["tipo_msg"]=1;
            }
            catch (Exception $e)
            {
                $_SESSION["msg"]="Erro ao salvar o tipo de pagamento: ".$e->getMessage();
                $_SESSION["tipo_msg"]=2;
            }
            header("Location: index");
        }
        
        function listar_tipos_pagamentos(){            

            try{

				return $this->tipospagamentosdb->listar_tipos_pagamentos_pag($_SESSION["usuario"]);

            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao listar os tipos de pagamento: ".$ex->getMessage();
                $_SESSION["tipo_msg"]=2;
                return array();
            }
  
        }
        
        function create_tipo_pagamento(){
            openSession();
            if($this->get_request_method() != "POST")
            {
                $this->response('',406);
            }
            try
            {
                $this->tipospagamentosdb->inserir_tipo_pagamento($_SESSION["usuario"],$_POST);
                $_SESSION["msg"]="Tipo de pagamento salvo com sucesso";
                $_SESSION["tipo_msg"]=1;
            }
            catch (Exception $e)
            {
                $_SESSION["msg"]="Erro ao salvar o tipo de pagamento: ".$e->getMessage();
                $_SESSION["tipo_msg"]=2;
            }
            header("Location: index");
        }
        
        function status_tipo_pagamento(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            } 
            try
            {				
		$this->tipospagamentosdb->atualizar_status_tipo_pagamento($_SESSION["usuario"],$_GET["id"],$_GET["status"]);
                if($_GET["status"]==2)
                {
                    $_SESSION["msg"]="Tipo de pagamento desativado com sucesso.";
                }
                else{
                    $_SESSION["msg"]="Tipo de pagamento ativado com sucesso.";
                }
                
                $_SESSION["tipo_msg"]=1;
            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao salvar o tipo de pagamento: ".$e->getMessage();
                $_SESSION["tipo_msg"]=2;
            }
            header("Location: index");  
        } 

        function deletar_tipo_pagamento(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            try
            {
                $this->tipospagamentosdb->deletar_tipo_pagamento($_SESSION["usuario"],$_GET["codigo"]);
                $_SESSION["msg"]="Tipo de pagamento deletado com sucesso";
                $_SESSION["tipo_msg"]=1;
            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao deletar o Tipo de pagamento: ".$ex->getMessage();
                $_SESSION["tipo_msg"]=2;
            }
            header("Location: index"); 
            
        }  

            
    }
    
    $api = new TiposPagamentosAction;
	$api->tipospagamentosdb=new TiposPagamentosDB();
    $api->processApi();
        