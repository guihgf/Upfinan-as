<?php
	require('../db/graficos_db.php');
    require('../../rest/Rest.inc.php');
    
    class HomeAction extends REST {
		public $graficodb;
        function index(){
			openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
						
			//MENU
            $menu=array("home"=>"active");
            $page="../home/index.php";
            include('../shared/menu.inc.php');

        }
		
		function exibir_instrucao(){
			session_start();
			$conn=get_conexao()->prepare("SELECT ASSUNTO,MENSAGEM FROM INSTRUCOES I
											 WHERE I.CODIGO=:CODIGO
											   AND NOT EXISTS(SELECT 1 
																FROM INSTRUCOES_USUARIOS IU 
																WHERE IU.CODIGO= I.CODIGO
																  AND IU.USUARIO_ID=:USUARIO)");
			$conn->bindValue(":USUARIO",$_SESSION["usuario"]);
			$conn->bindValue(":CODIGO",$_GET["tipo"]);
			$conn->execute();
			$msg=to_utf8($conn);
			echo json_encode($msg);
			$conn=null;
		}
		
		function remover_instrucao(){
			session_start();
			$conn=get_conexao()->prepare("INSERT INTO INSTRUCOES_USUARIOS VALUES(:CODIGO,:USUARIO)");
			$conn->bindValue(":USUARIO",$_SESSION["usuario"]);
			$conn->bindValue(":CODIGO",$_GET["tipo"]);
			$conn->execute();
			$conn=null;
		}
      
    }	
    $api = new HomeAction;
	$api->graficodb=new GraficoDB();
    $api->processApi();
    
    
