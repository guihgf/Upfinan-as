<?php
    require('../../rest/Rest.inc.php');
	require('../db/participante_db.php');
    
    class ParticipanteAction extends REST {
		public $participantedb;
		
        function index(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }

            $participantes=$this->listar_participantes();  

			$menu=array("cadastro"=>"active","participantes"=>"active");
            $page="../participantes/index.php";
            include('../shared/menu.inc.php');

        }

        function create(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
			$menu=array("cadastro"=>"active","participantes"=>"active");
            $page="../participantes/create.php";
            include('../shared/menu.inc.php');
        }
		
		function create_participante(){
            openSession();
            if($this->get_request_method() != "POST")
            {
                $this->response('',406);
            }
            try
            {
                $this->participantedb->inserir_participante($_SESSION["usuario"],$_POST,$_SESSION["plano"]);
                $_SESSION["msg"]="Participante salvo com sucesso";
                $_SESSION["tipo_msg"]=1;
            }
            catch (Exception $e)
            {
                $_SESSION["msg"]="Erro ao salvar o participante: ".$e->getMessage();
                $_SESSION["tipo_msg"]=2;
            }
            header("Location: index");
        }
        
        function edit(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            try{
                $participante=$this->participantedb->selecionar_participante($_SESSION["usuario"],$_GET["id"]);
             
            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao exibir participante: ".$ex->getMessage();
                $_SESSION["tipo_msg"]=2;
                $participante= array();
            }
			$menu=array("cadastro"=>"active","participantes"=>"active");
            $page="../participantes/edit.php";
            include('../shared/menu.inc.php');
            include('edit.php');
        }
		
		function edit_participante(){
            openSession();
            if($this->get_request_method() != "POST")
            {
                $this->response('',406);
            }
            try
            {
                $this->participantedb->alterar_participante($_SESSION["usuario"],$_POST);
                $_SESSION["msg"]="Participante salvo com sucesso";
                $_SESSION["tipo_msg"]=1;
            }
            catch (Exception $e)
            {
                $_SESSION["msg"]="Erro ao salvar o participante: ".$e->getMessage();
                $_SESSION["tipo_msg"]=2;
            }
            header("Location: index");
        }
       
        function listar_participantes(){            

            try{

                $rows=$this->participantedb->lista_participantes_pag($_SESSION["usuario"]);
  
                return $rows; 
            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao listar o participante: ".$ex->getMessage();
                $_SESSION["tipo_msg"]=2;
                return array();
            }
  
        }
        		        
        function status_participante(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            } 
            try
            {
				
				$this->participantedb->atualizar_status_participante($_SESSION["usuario"],$_GET["id"],$_GET["status"]);
				
                if($_GET["status"]==2)
                {
                    $_SESSION["msg"]="Participante desativado com sucesso.";
                }
                else{
                    $_SESSION["msg"]="Participante ativado com sucesso.";
                }
                
                $_SESSION["tipo_msg"]=1;
            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao ativar o participante: ".$ex->getMessage();
                $_SESSION["tipo_msg"]=2;
            }
            header("Location: index");  
        }

        function deletar_participante(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            try
            {
                $this->participantedb->deletar_participante($_SESSION["usuario"],$_GET["codigo"]);
                $_SESSION["msg"]="Participante deletado com sucesso";
                $_SESSION["tipo_msg"]=1;
            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao deletar o participante: ".$ex->getMessage();
                $_SESSION["tipo_msg"]=2;
            }
            header("Location: index"); 
            
        }
    }
    
    $api = new ParticipanteAction();
	$api->participantedb=new ParticipanteDB();
    $api->processApi();
        