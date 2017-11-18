<?php
	require('../db/despesas_db.php');
	require('../db/conta_db.php');
	require('../db/grupo_db.php');
	require('../db/participante_db.php');
	require('../db/tipos_pagamentos_db.php');
    require('../../rest/Rest.inc.php');
    class DespesaAction extends REST {
		
		public $lancamentodb;
		
		function index()
		{
	        openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }


            if(isset($_GET["tipo"])){
            	//top 5 despesas detalhadas
            	$lancamentos=$this->top_5_despesas_vencidas_det(); 
            }
            else
				$lancamentos=$this->listar_despesas();  

			$contadb=new ContaDB();
			$contas=$contadb->listar_contas($_SESSION["usuario"],false);
			
            $menu=array("despesas"=>"active","lancamentos"=>"active");
            $page="../despesas/index.php";
            include('../shared/menu.inc.php');
        }
				       
        function listar_despesas(){            

            try{
                
				return $this->despesadb->lista_despesas_pag($_SESSION["usuario"]);
  
            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao listar as despesas: ".$ex->getMessage();
                $_SESSION["tipo_msg"]=2;
                return array();
            }
  
        }

        function top_5_despesas_vencidas_det(){            

            try{
                
				return $this->despesadb->top_5_despesas_vencidas_det($_SESSION["usuario"]);
  
            } catch (Exception $ex) {
                $_SESSION["msg"]="Erro ao listar as despesas: ".$ex->getMessage();
                $_SESSION["tipo_msg"]=2;
                return array();
            }
  
        }
        
        function nova_despesa(){
            openSession();
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
			
		    $contadb=new ContaDB();
		    $contas=$contadb->listar_contas($_SESSION["usuario"],false);
	            unset($contadb);

		    $participantedb=new ParticipanteDB();
		    $participantes=$participantedb->listar_participantes($_SESSION["usuario"],false);
                    unset($participantedb);

			$grupodb=new GrupoDB();
                        $grupos=$grupodb->listar_grupos($_SESSION["usuario"],false);
unset($grupodb);

			$tipopagamentodb=new TiposPagamentosDB();
			$tipos_pagamento=$tipopagamentodb->listar_tipos_pagamentos($_SESSION["usuario"],false);
unset($tipopagamentodb);


			$menu=array("lancamentos"=>"active","despesas"=>"active");
            $page="../despesas/create.php";
            include('../shared/menu.inc.php');
        }
		
		function create_despesa(){
			openSession();
			if($this->get_request_method() != "POST")
            {
                $this->response('',406);
            }

            $data_pagamento=null;
			for ($i = 0; $i < $_POST["parcela"]; $i++)
			{

				$data_vencimento=date("Y-m-d", strtotime(str_replace('/', '-',$_POST["data_vencimento"])) );

				if ($_POST["data_pagamento"]!=null){
					$data_pagamento=date("Y-m-d", strtotime(str_replace('/', '-',$_POST["data_pagamento"])) );
				}
				
				$conta=$_POST["busca_conta"];;
				

				if($_POST["busca_participantes"]==""){
					$participante=null;
				}
				else{
					$participante=$_POST["busca_participantes"];
				}
				
			
				$grupo=$_POST["busca_grupos"];
			

				$tipos_pagamento=$_POST["tipo_pagamento"];
				
				if ($i > 0)
				{
					$data_pagamento=null;
					$_POST["pago"]="N";
					$data_vencimento= date('Y-m-d', strtotime("+$i months", strtotime(str_replace('/', '-',$_POST["data_vencimento"]))));
					
				}	
				try{
						$this->despesadb->inserir_despesa($_POST,$i,$data_vencimento,$data_pagamento,$conta,$grupo,$participante,$tipos_pagamento);
						$_SESSION["msg"]="Despesa salva com sucesso";
						$_SESSION["tipo_msg"]=1;
					}
					catch (Exception $e)
					{
						$_SESSION["msg"]="Erro ao salvar a despesa: ".$e->getMessage();
						$_SESSION["tipo_msg"]=2;
					}
					$conn=null;
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

				$despesa=$this->despesadb->selecionar_despesa($_SESSION["usuario"],$_GET["id"]);

$contadb=new ContaDB();
		    $contas=$contadb->listar_contas($_SESSION["usuario"],false);
	            unset($contadb);

		    $participantedb=new ParticipanteDB();
		    $participantes=$participantedb->listar_participantes($_SESSION["usuario"],false);
                    unset($participantedb);

			$grupodb=new GrupoDB();
                        $grupos=$grupodb->listar_grupos($_SESSION["usuario"],false);
unset($grupodb);

			$tipopagamentodb=new TiposPagamentosDB();
			$tipos_pagamento=$tipopagamentodb->listar_tipos_pagamentos($_SESSION["usuario"],false);
unset($tipopagamentodb);
			}
			catch(Exception $e){
				$_SESSION["msg"]="Erro ao exibir a despesa: ".$e->getMessage();
				$_SESSION["tipo_msg"]=2;
			}
						
			$menu=array("lancamentos"=>"active","despesas"=>"active");
            $page="../despesas/edit.php";
            include('../shared/menu.inc.php');
			
		}
		
		function editar_despesa(){
			openSession();
			if($this->get_request_method() != "POST")
            {
                $this->response('',406);
            }
			try{
				
				$this->despesadb->alterar_despesa($_SESSION["usuario"],$_POST);
												
				$_SESSION["msg"]="Despesa alterada com sucesso";
				$_SESSION["tipo_msg"]=1;
			}
			catch(Exception $e){
				$_SESSION["msg"]="Não foi possível alterar a despesa: ".$e->getMessage();
				$_SESSION["tipo_msg"]=2;
			}
			
			header("Location: index");
			
		}
		
		function deletar_despesa(){
			openSession();
			if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
			try{

				$this->despesadb->deletar_despesa($_SESSION["usuario"],$_GET["id"]);
				$_SESSION["msg"]="Despesa deletada com sucesso";
				$_SESSION["tipo_msg"]=1;
			}
			catch(Exception $e)
			{
				$_SESSION["msg"]="Erro ao deletar a despesa: ".$e->getMessage();
				$_SESSION["tipo_msg"]=2;
			}

			header("Location: index");

			
		}

		function pagar(){
			openSession();
			if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
			try{

				$this->despesadb->pagar($_SESSION["usuario"],$_GET["id"]);
				$_SESSION["msg"]="Despesa paga com sucesso";
				$_SESSION["tipo_msg"]=1;
			}
			catch(Exception $e)
			{
				$_SESSION["msg"]="Erro ao pagar a despesa: ".$e->getMessage();
				$_SESSION["tipo_msg"]=2;
			}

			if(isset($_GET["tipo"])){
				header("Location: index?tipo=1");
			}
			else
				header("Location: index");

			
		}

		function top_5_despesas_vencidas(){
			openSession();
			if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            $despesas_vencidas=array();
			try{
				$despesas=$this->despesadb->top_5_despesas_vencidas($_SESSION["usuario"]);
				$despesas_vencidas["DESPESAS"]=[];
				foreach($despesas as $despesa){
					array_push($despesas_vencidas["DESPESAS"],$despesa);
				}
				$despesas_vencidas["TOTAL"]=$this->despesadb->top_5_despesas_vencidas_tot($_SESSION["usuario"]);
			}
			catch(Exception $e)
			{
				$despesas_vencidas=array();
			}

			echo json_encode($despesas_vencidas);
			
		}

		function resumo_despesa_mes(){
			openSession();
			if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            $despesas["DESPESAS"]=array();
			try{

				$despesas["DESPESAS"]=$this->despesadb->resumo_despesa_mes($_SESSION["usuario"],$_GET["conta"]);
			}
			catch(Exception $e)
			{
				$despesas["DESPESAS"]=array();
			}

			echo json_encode($despesas);

		}
    }
    
    $api = new DespesaAction();
	$api->despesadb=new DespesaDB();
    $api->processApi();
        