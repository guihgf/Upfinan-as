<?php

	require('../db/receitas_db.php');

	require('../db/conta_db.php');

	require('../db/grupo_receitas_db.php');

	require('../db/participante_db.php');

	require('../db/tipos_pagamentos_db.php');

    require('../../rest/Rest.inc.php');

    class ReceitaAction extends REST {

				

		function index()

		{

	        openSession();

            if($this->get_request_method() != "GET")

            {

                $this->response('',406);

            }



            $lancamentos=$this->listar_receitas();  



			$contadb=new ContaDB();

			$contas=$contadb->listar_contas($_SESSION["usuario"],false);

			

            $menu=array("receitas"=>"active","lancamentos"=>"active");

            $page="../receitas/index.php";

            include('../shared/menu.inc.php');

        }

				       

        function listar_receitas(){            



            try{

                

				return $this->receitadb->lista_receitas_pag($_SESSION["usuario"]);

  

            } catch (Exception $ex) {

                $_SESSION["msg"]="Erro ao listar as receitas: ".$ex->getMessage();

                $_SESSION["tipo_msg"]=2;

                return array();

            }

  

        }

        

        function nova_receita(){

            openSession();

            if($this->get_request_method() != "GET")

            {

                $this->response('',406);

            }

			

		    /*$contadb=new ContaDB();

			$participantedb=new ParticipanteDB();

			$grupodb=new GrupoReceitasDB();

			$tipopagamentodb=new TiposPagamentosDB();

		

			$contas=$contadb->listar_contas($_SESSION["usuario"],false);

			$grupos=$grupodb->listar_grupos($_SESSION["usuario"],false);

			$participantes=$participantedb->listar_participantes($_SESSION["usuario"],false);

			$tipos_pagamento=$tipopagamentodb->listar_tipos_pagamentos($_SESSION["usuario"],false);*/

$contadb=new ContaDB();
		    $contas=$contadb->listar_contas($_SESSION["usuario"],false);
	            unset($contadb);

		    $participantedb=new ParticipanteDB();
		    $participantes=$participantedb->listar_participantes($_SESSION["usuario"],false);
                    unset($participantedb);

			$grupodb=new GrupoReceitasDB();
                        $grupos=$grupodb->listar_grupos($_SESSION["usuario"],false);
unset($grupodb);

			$tipopagamentodb=new TiposPagamentosDB();
			$tipos_pagamento=$tipopagamentodb->listar_tipos_pagamentos($_SESSION["usuario"],false);
unset($tipopagamentodb);





			$menu=array("receitas"=>"active","lancamentos"=>"active");

            $page="../receitas/create.php";

            include('../shared/menu.inc.php');

        }

		

		function create_receita(){

			openSession();

			if($this->get_request_method() != "POST")

            {

                $this->response('',406);

            }



            $data_credito=date("Y-m-d", strtotime(str_replace('/', '-',$_POST["data_credito"])) );



            $conta=$_POST["busca_conta"];;

				

			if($_POST["busca_participantes"]==""){

				$participante=null;

			}

			else{

				$participante=$_POST["busca_participantes"];

			}

		

			$grupo=$_POST["busca_grupos"];

		

			$tipos_pagamento=$_POST["tipo_pagamento"];



			try{

				$this->receitadb->inserir_receita($_POST,$i,$data_credito,$conta,$grupo,$participante,$tipos_pagamento);

				$_SESSION["msg"]="Receita salva com sucesso";

				$_SESSION["tipo_msg"]=1;

			}

			catch (Exception $e)

			{

				$_SESSION["msg"]="Erro ao salvar a receita: ".$e->getMessage();

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



				$receita=$this->receitadb->selecionar_receita($_SESSION["usuario"],$_GET["id"]);

				$contadb=new ContaDB();
		    $contas=$contadb->listar_contas($_SESSION["usuario"],false);
	            unset($contadb);

		    $participantedb=new ParticipanteDB();
		    $participantes=$participantedb->listar_participantes($_SESSION["usuario"],false);
                    unset($participantedb);

			$grupodb=new GrupoReceitasDB();
                        $grupos=$grupodb->listar_grupos($_SESSION["usuario"],false);
unset($grupodb);

			$tipopagamentodb=new TiposPagamentosDB();
			$tipos_pagamento=$tipopagamentodb->listar_tipos_pagamentos($_SESSION["usuario"],false);
unset($tipopagamentodb);


				

			}

			catch(Exception $e){

				$_SESSION["msg"]="Erro ao exibir a receita: ".$e->getMessage();

				$_SESSION["tipo_msg"]=2;

			}

						

			$menu=array("receitas"=>"active","lancamentos"=>"active");

            $page="../receitas/edit.php";

            include('../shared/menu.inc.php');

			

		}

		

		function editar_receita(){

			openSession();

			if($this->get_request_method() != "POST")

            {

                $this->response('',406);

            }

			try{

				

				$this->receitadb->alterar_receita($_SESSION["usuario"],$_POST);

												

				$_SESSION["msg"]="Receita alterada com sucesso";

				$_SESSION["tipo_msg"]=1;

			}

			catch(Exception $e){

				$_SESSION["msg"]="Não foi possível alterar a receita: ".$e->getMessage();

				$_SESSION["tipo_msg"]=2;

			}

			

			header("Location: index");

			

		}

		

		function deletar_receita(){

			openSession();

			if($this->get_request_method() != "GET")

            {

                $this->response('',406);

            }

			try{



				$this->receitadb->deletar_receita($_SESSION["usuario"],$_GET["id"]);

				$_SESSION["msg"]="Receita deletada com sucesso";

				$_SESSION["tipo_msg"]=1;

			}

			catch(Exception $e)

			{

				$_SESSION["msg"]="Erro ao deletar a receita: ".$e->getMessage();

				$_SESSION["tipo_msg"]=2;

			}



			header("Location: index");	

		}



		function resumo_receita_mes(){

			openSession();

			if($this->get_request_method() != "GET")

            {

                $this->response('',406);

            }

            $receitas["RECEITAS"]=array();

			try{



				$receitas["RECEITAS"]=$this->receitadb->resumo_receita_mes($_SESSION["usuario"],$_GET["conta"]);

			}

			catch(Exception $e)

			{

				$receitas["RECEITAS"]=array();

			}



			echo json_encode($receitas);



		}

    }

    

    $api = new ReceitaAction();

	$api->receitadb=new ReceitaDB();

    $api->processApi();

        

