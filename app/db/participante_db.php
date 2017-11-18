<?php

	require_once('conexao.php');

	class ParticipanteDB{

		private $conn;

		function __construct() {
			$this->conn=get_conexao();
		}

		function __destruct(){
			$this->conn=null;
		}

		function listar_participantes($usuario,$incluir_desativados){
			if($incluir_desativados)
				$query="SELECT CODIGO,NOME FROM participantes P WHERE P.USUARIO_ID=:USUARIO ORDER BY CODIGO DESC";
			else
				$query="SELECT CODIGO,NOME FROM participantes P WHERE P.USUARIO_ID=:USUARIO AND P.STATUS=1 ORDER BY CODIGO DESC";

			$sql=$this->conn->prepare($query);

			$sql->bindValue(":USUARIO",$usuario);			

			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		function lista_participantes_pag($usuario){
			$sql=$this->conn->prepare("SELECT Q.*,
											   Q.ENTRADA-Q.SAIDA SALDO 
											  FROM
											  (SELECT CODIGO,
													  NOME,
													  CIDADE,
													  STATUS,
													  (SELECT IFNULL(SUM(L.VALOR),0) FROM lancamentos_receitas L WHERE L.PARTICIPANTE_ID=P.CODIGO AND L.DATA_CREDITO <=DATE_FORMAT(NOW(),'%Y-%m-%d')) AS ENTRADA,
												  (SELECT IFNULL(SUM(L.VALOR),0) FROM lancamentos_despesas L WHERE L.PARTICIPANTE_ID=P.CODIGO AND L.DATA_PAGAMENTO <=DATE_FORMAT(NOW(),'%Y-%m-%d')) AS SAIDA
													  FROM participantes P 
													  WHERE P.USUARIO_ID=:USUARIO
													  ORDER BY P.CODIGO DESC) Q");
			$sql->bindValue(":USUARIO", $usuario);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		function inserir_participante($usuario,$values,$tipo_plano){
			$total_participantes=$sql=$this->conn->prepare("SELECT COUNT(1) FROM participantes P
															WHERE P.usuario_id=:usuario");

			$sql->bindValue(":usuario", $usuario);
			$sql->execute();
			$total=$sql->fetchColumn();

			if($total<=4 || $tipo_plano==1){
				$sql=$this->conn->prepare("INSERT INTO participantes(NOME,
																TELEFONE,
																CELULAR,
																EMAIL,
																RUA,
																NUMERO,
																BAIRRO,
																COMPLEMENTO,
																CIDADE,
																STATUS,
																USUARIO_ID)
														VALUES(:NOME,
																:TELEFONE,
																:CELULAR,
																:EMAIL,
																:RUA,
																:NUMERO,
																:BAIRRO,
																:COMPLEMENTO,
																:CIDADE,
																:STATUS,
																:USUARIO)");

				$sql->bindValue(":NOME", $values["nome"]);
				$sql->bindValue(":TELEFONE", $values["telefone"]);
				$sql->bindValue(":CELULAR", $values["celular"]);
				$sql->bindValue(":EMAIL", $values["email"]);
				$sql->bindValue(":RUA", $values["rua"]);
				$sql->bindValue(":NUMERO", $values["numero"]);
				$sql->bindValue(":BAIRRO", $values["bairro"]);
				$sql->bindValue(":COMPLEMENTO", $values["complemento"]);
				$sql->bindValue(":CIDADE", $values["cidade"]);
				$sql->bindValue(":STATUS", 1);
				$sql->bindValue(":USUARIO", $usuario);
				$sql->execute();	

			}
			else
				throw new Exception("O plano gratuito permite que você cadastre até 4 participantes.");
		}

		function selecionar_participante($usuario,$id)
		{
			$sql=$this->conn->prepare("SELECT CODIGO,
											NOME,
											TELEFONE,
											CELULAR,
											EMAIL,
											RUA,
											NUMERO,
											BAIRRO,
											COMPLEMENTO,
											CIDADE,
											STATUS
										  FROM participantes P 
										 WHERE P.USUARIO_ID=:USUARIO
										   AND P.CODIGO=:CODIGO");

			$sql->bindValue(":USUARIO",$usuario);
			$sql->bindValue(":CODIGO", $id);
			$sql->execute();

			return $sql->fetch(PDO::FETCH_ASSOC);
		}

		function alterar_participante($usuario,$values){
			$sql=$this->conn->prepare("UPDATE participantes 
										SET NOME=:NOME,
											TELEFONE=:TELEFONE,
											CELULAR=:CELULAR,
											EMAIL=:EMAIL,
											RUA=:RUA,
											NUMERO=:NUMERO,
											BAIRRO=:BAIRRO,
											COMPLEMENTO=:COMPLEMENTO,
											CIDADE=:CIDADE,
											STATUS=:STATUS
										WHERE USUARIO_ID=:USUARIO
										  AND CODIGO=:CODIGO");

			$sql->bindValue(":NOME", $values["nome"]);
			$sql->bindValue(":TELEFONE", $values["telefone"]);
			$sql->bindValue(":CELULAR", $values["celular"]);
			$sql->bindValue(":EMAIL", $values["email"]);
			$sql->bindValue(":RUA", $values["rua"]);
			$sql->bindValue(":NUMERO", $values["numero"]);
			$sql->bindValue(":BAIRRO", $values["bairro"]);
			$sql->bindValue(":COMPLEMENTO", $values["complemento"]);
			$sql->bindValue(":CIDADE", $values["cidade"]);
			$sql->bindValue(":STATUS", 1);
			$sql->bindValue(":CODIGO", $values["codigo"]);
			$sql->bindValue(":USUARIO", $usuario);
			$sql->execute();
		}

		function atualizar_status_participante($usuario,$id,$status){
			$query="";

			if($status==2)
			{
				$query="UPDATE participantes SET STATUS=:STATUS,DATA_DESATIVACAO=CURRENT_TIMESTAMP WHERE CODIGO=:CODIGO AND USUARIO_ID=:USUARIO";
			}
			else {
				$query="UPDATE participantes SET STATUS=:STATUS,DATA_DESATIVACAO=NULL WHERE CODIGO=:CODIGO AND USUARIO_ID=:USUARIO";
			}

			$sql= $this->conn->prepare($query);

			$sql->bindValue(":CODIGO", $id);
			$sql->bindValue(":STATUS", $status);
			$sql->bindValue(":USUARIO", $usuario);

			$sql->execute();		

		}

		function deletar_participante($usuario,$codigo){
			$sql=$this->conn->prepare("DELETE FROM lancamentos_despesas
									   WHERE PARTICIPANTE_ID=:CODIGO
										 AND EXISTS(SELECT 1 FROM participantes P
													 WHERE P.CODIGO=lancamentos_despesas.PARTICIPANTE_ID 
													   AND P.USUARIO_ID=:USUARIO)");
			$sql->bindValue(":CODIGO",$codigo);
			$sql->bindValue(":USUARIO",$usuario);
			$sql->execute();

			$sql=$this->conn->prepare("DELETE FROM lancamentos_receitas
									   WHERE PARTICIPANTE_ID=:CODIGO
										 AND EXISTS(SELECT 1 FROM participantes P
													 WHERE P.CODIGO=lancamentos_receitas.PARTICIPANTE_ID 
													   AND P.USUARIO_ID=:USUARIO)");
			$sql->bindValue(":CODIGO",$codigo);
			$sql->bindValue(":USUARIO",$usuario);
			$sql->execute();

			$sql=$this->conn->prepare("DELETE FROM participantes
									  	WHERE CODIGO=:CODIGO
									  	  AND USUARIO_ID=:USUARIO");
			$sql->bindValue(":CODIGO",$codigo);
			$sql->bindValue(":USUARIO",$usuario);
			$sql->execute();

		}

	}

?>