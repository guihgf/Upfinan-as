<?php
    require('../db/instrucoes_db.php');
    require('../../rest/Rest.inc.php');
    
    class InstrucaoAction extends REST {

		public $instrucaodb;
        
        function desativar_instrucao(){
			openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
			$this->instrucaodb->desativar_instrucao($_GET['codigo'],$_SESSION['usuario']);
		}
		
		function get_instrucao(){
			openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
			$instrucoes=$this->instrucaodb->get_instrucao($_GET['codigo'],$_SESSION['usuario']);
			echo json_encode($instrucoes);
			
		}
	}
	$api = new InstrucaoAction();
    $api->instrucaodb=new InstrucaoDB();
	$api->processApi();
?>