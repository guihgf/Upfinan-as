<?php

	require('../db/grupo_db.php');
    require('../../rest/Rest.inc.php');
    
    class GrupoAction extends REST {
		public $grupodb;
		
        function index(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            if(!empty($_GET["opcao"])){
                $grupos=$this->buscar_grupos();
            }
            else{
                $grupos=$this->listar_grupos();  
            }
			
            $menu=array("despesas"=>"active","grupos"=>"active");
            $page="../grupos/index.php";
            include('../shared/menu.inc.php');

        }
        function create(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            $menu=array("despesas"=>"active","grupos"=>"active");
            $page="../grupos/create.php";
            include('../shared/menu.inc.php');
        }
        
        function edit(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            try{
				$grupo=$this->grupodb->selecionar_grupo($_SESSION["usuario"],$_GET["id"]);
            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao exibir grupo: ".$ex->getMessage();
                $_SESSION["tipo_msg"]=2;
                $grupo= array();
            }
            $menu=array("despesas"=>"active","grupos"=>"active");
            $page="../grupos/edit.php";
            include('../shared/menu.inc.php');
        }
        
        function edit_grupo(){
            openSession();
            if($this->get_request_method() != "POST")
            {
                $this->response('',406);
            }
            try
            {				
				$this->grupodb->alterar_grupo($_SESSION["usuario"],$_POST);
                $_SESSION["msg"]="Grupo salvo com sucesso";
                $_SESSION["tipo_msg"]=1;
            }
            catch (Exception $e)
            {
                $_SESSION["msg"]="Erro ao salvar o grupo: ".$e->getMessage();
                $_SESSION["tipo_msg"]=2;
            }
            header("Location: index");
        }
        
        function listar_grupos(){            

            try{

				return $this->grupodb->listar_grupos_pag($_SESSION["usuario"]);

            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao listar os grupos: ".$ex->getMessage();
                $_SESSION["tipo_msg"]=2;
                return array();
            }
  
        }
        
        function create_grupo(){
            openSession();
            if($this->get_request_method() != "POST")
            {
                $this->response('',406);
            }
            try
            {
                $this->grupodb->inserir_grupo($_SESSION["usuario"],$_POST);
                $_SESSION["msg"]="Grupo salvo com sucesso";
                $_SESSION["tipo_msg"]=1;
            }
            catch (Exception $e)
            {
                $_SESSION["msg"]="Erro ao salvar o grupo: ".$e->getMessage();
                $_SESSION["tipo_msg"]=2;
            }
            header("Location: index");
        }
        
        function status_grupo(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            } 
            try
            {				
				$this->grupodb->atualizar_status_grupo($_SESSION["usuario"],$_GET["id"],$_GET["status"]);
                if($_GET["status"]==2)
                {
                    $_SESSION["msg"]="Grupo desativado com sucesso.";
                }
                else{
                    $_SESSION["msg"]="Grupo ativado com sucesso.";
                }
                
                $_SESSION["tipo_msg"]=1;
            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao salvar o grupo: ".$e->getMessage();
                $_SESSION["tipo_msg"]=2;
            }
            header("Location: index");  
        }

        function deletar_grupos_despesas(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            try
            {
                $this->grupodb->deletar_grupos_despesas($_SESSION["usuario"],$_GET["codigo"]);
                $_SESSION["msg"]="Grupo deletado com sucesso";
                $_SESSION["tipo_msg"]=1;
            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao deletar o grupo: ".$ex->getMessage();
                $_SESSION["tipo_msg"]=2;
            }
            header("Location: index"); 
            
        }         
    }
    
    $api = new GrupoAction;
	$api->grupodb=new GrupoDB();
    $api->processApi();
        