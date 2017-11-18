<?php
	require_once('conexao.php');
	
	class TransferenciaDB{
		private $conn;
		
		function __construct() {
			$this->conn=get_conexao();
		}
		
		function __destruct(){
			$this->conn=null;
		}
		
		function listar_transferencias($usuario){
			$sql=$this->conn->prepare("SELECT L.CODIGO,L.NOME,DATE_FORMAT(L.DATA_CREDITO,'%d/%m/%Y')  DATA_TRANSFERENCIA,L.VALOR 
										 FROM lancamentos_receitas L, contas C
									    WHERE L.CONTA_ID=C.CODIGO
									      AND C.USUARIO_ID=:USUARIO
									      AND L.TRANSFERENCIA='S'");
			$parameters=array('USUARIO'=>$usuario);
			$sql->execute($parameters);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}	
		function salvar_transferencia($values,$data_transferencia){

			$sql=$this->conn->prepare("SELECT NOME FROM contas WHERE CODIGO=:ID");
			$parameters=array('ID'=>$values['contade']);
			$sql->execute($parameters);
			$contade=$sql->fetchColumn();

			$sql=$this->conn->prepare("SELECT NOME FROM contas WHERE CODIGO=:ID");
			$parameters=array('ID'=>$values['contapara']);
			$sql->execute($parameters);
			$contapara=$sql->fetchColumn();


			$sql=$this->conn->prepare("INSERT INTO lancamentos_receitas
													(NOME,
													DATA_CREDITO,
													VALOR,
													OBSERVACAO,
													CONTA_ID,
													TRANSFERENCIA
													)
													VALUES
													(:NOME,
													:DATA_CREDITO,
													:VALOR,
													:OBSERVACAO,
													:CONTA_ID,
													'S'
													)");

			$parameters=array('NOME'=>'Transferência da conta '.$contade. ' para '.$contapara,
								'DATA_CREDITO' => $data_transferencia,
							   'VALOR'=>$values["valor"],
							   'OBSERVACAO'=>$values["observacao"],
							   'CONTA_ID'=>$values["contapara"]);

			/*echo sql_debug($sql->queryString,$parameters);
			exit;*/

			$sql->execute($parameters);

			$receita=$this->conn->lastInsertId();

			$sql=$this->conn->prepare("INSERT INTO lancamentos_despesas
													(NOME,
													DATA_VENCIMENTO,
													DATA_PAGAMENTO,
													VALOR,
													OBSERVACAO,
													CONTA_ID,
													TRANSFERENCIA,
													TRANSF_REC_REL
													)
													VALUES
													(:NOME,
													:DATA_VENCIMENTO,
													:DATA_PAGAMENTO,
													:VALOR,
													:OBSERVACAO,
													:CONTA_ID,
													'S',
													:TRANSF_REC_REL
													)");

			$parameters=array('NOME'=>'Transferência da conta '.$contade. ' para '.$contapara ,
								'DATA_VENCIMENTO' => $values['data_transferencia'],
							   'DATA_PAGAMENTO' =>$data_transferencia,
							   'VALOR'=>$values["valor"],
							   'OBSERVACAO'=>$values["observacao"],
							   'CONTA_ID'=>$values["contade"],
							   'TRANSF_REC_REL'=>$receita);

			$sql->execute($parameters);
		}

		function deletar_transferencia($values,$usuario){
			$sql=$this->conn->prepare("DELETE FROM lancamentos_receitas 
									    WHERE lancamentos_receitas.CODIGO=:CODIGO
									      AND lancamentos_receitas.TRANSFERENCIA='S'
									      AND EXISTS(SELECT 1 FROM contas C WHERE C.CODIGO=lancamentos_receitas.CONTA_ID AND C.USUARIO_ID=:USUARIO)");
			$parameters=array('CODIGO'=>$values['id'],
							  'USUARIO'=>$usuario);
			$sql->execute($parameters);

			$sql=$this->conn->prepare("DELETE FROM lancamentos_despesas 
									    WHERE lancamentos_despesas.TRANSF_REC_REL=:CODIGO
									      AND lancamentos_despesas.TRANSFERENCIA='S'
									      AND EXISTS(SELECT 1 FROM contas C WHERE C.CODIGO=lancamentos_despesas.CONTA_ID AND C.USUARIO_ID=:USUARIO)");
			$parameters=array('CODIGO'=>$values['id'],
							  'USUARIO'=>$usuario);

			/*echo sql_debug($sql->queryString,$parameters);
			exit;*/

			$sql->execute($parameters);

		}	

		
		
	}

?>