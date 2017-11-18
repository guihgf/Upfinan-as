<?php
	require_once('conexao.php');
	
	class TiposPagamentosDB{
		private $conn;
		
		function __construct() {
			$this->conn=get_conexao();
		}
		
		function __destruct(){
			$this->conn=null;
		}
		
		function listar_tipos_pagamentos($usuario,$incluir_desativados){
			if($incluir_desativados)
				$query="SELECT CODIGO,NOME FROM tipos_pagamentos T WHERE T.USUARIO_ID=:USUARIO ORDER BY CODIGO DESC";
			else
				$query="SELECT CODIGO,NOME FROM tipos_pagamentos T WHERE T.USUARIO_ID=:USUARIO AND T.STATUS=1 ORDER BY CODIGO DESC";
			
			$sql=$this->conn->prepare($query);
			$sql->bindValue(":USUARIO",$usuario);			
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		
		
		function listar_tipos_pagamentos_pag($usuario){
			$sql=$this->conn->prepare("SELECT CODIGO,
											  NOME,
											  DATE_FORMAT(DATA_CADASTRO,'%d/%m/%Y') DATA_CADASTRO,
											  STATUS,
											  (SELECT IFNULL(SUM(L.VALOR),0) FROM lancamentos_despesas L WHERE L.TIPO_PAGAMENTO_ID=T.CODIGO AND L.DATA_PAGAMENTO <=DATE_FORMAT(NOW(),'%Y-%m-%d')) TOTAL_GASTO,
											  (SELECT IFNULL(SUM(L.VALOR),0) FROM lancamentos_receitas L WHERE L.TIPO_PAGAMENTO_ID=T.CODIGO AND L.DATA_CREDITO <=DATE_FORMAT(NOW(),'%Y-%m-%d')) TOTAL_GANHO
											  FROM tipos_pagamentos T
											  WHERE T.USUARIO_ID=:USUARIO
											  ORDER BY T.CODIGO DESC");

			$sql->bindValue(":USUARIO", $usuario);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
				
		function inserir_tipo_pagamento($usuario,$values){
			$sql=$this->conn->prepare("INSERT INTO tipos_pagamentos(NOME,
																	STATUS,
																	USUARIO_ID)
															VALUES(:NOME,
																	1,
																	:USUARIO)");
			$sql->bindValue(":NOME", $values["nome"]);
			$sql->bindValue(":USUARIO", $usuario);
			$sql->execute();
		}
		
		function selecionar_tipo_pagamento($usuario,$id){
			$sql= $this->conn->prepare("SELECT CODIGO,
												NOME                                                 
											  FROM tipos_pagamentos T
											 WHERE T.USUARIO_ID=:USUARIO
											   AND T.CODIGO=:CODIGO");

			$sql->bindValue(":USUARIO", $usuario);
			$sql->bindValue(":CODIGO", $id);
			$sql->execute();
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
		
		function alterar_tipo_pagamento($usuario,$values){
			$sql= $this->conn->prepare("UPDATE tipos_pagamentos SET NOME=:NOME
										WHERE USUARIO_ID=:USUARIO
										  AND CODIGO=:CODIGO");
			$sql->bindValue(":NOME", $values["nome"]);
			$sql->bindValue(":USUARIO", $usuario);
			$sql->bindValue(":CODIGO", $values["codigo"]);
			$sql->execute();
		}
		
		function atualizar_status_tipo_pagamento($usuario,$id,$status){
			$query="";
			if($status==2)
			{
				$query="UPDATE tipos_pagamentos SET STATUS=:STATUS,DATA_DESATIVACAO=CURRENT_TIMESTAMP WHERE CODIGO=:CODIGO AND USUARIO_ID=:USUARIO"; 
			}
			else {
				$query="UPDATE tipos_pagamentos SET STATUS=:STATUS, DATA_DESATIVACAO=NULL WHERE CODIGO=:CODIGO AND USUARIO_ID=:USUARIO";
			}
			
			$sql= $this->conn->prepare($query);
			$sql->bindValue(":CODIGO", $id);
			$sql->bindValue(":STATUS", $status);
			$sql->bindValue(":USUARIO", $usuario);
			$sql->execute();
		
		}
		function deletar_tipo_pagamento($usuario,$codigo){
            $sql=$this->conn->prepare("DELETE FROM lancamentos_despesas
                                       WHERE TIPO_PAGAMENTO_ID=:CODIGO
                                         AND EXISTS(SELECT 1 FROM tipos_pagamentos T
                                                     WHERE T.CODIGO=lancamentos_despesas.TIPO_PAGAMENTO_ID 
                                                       AND T.USUARIO_ID=:USUARIO)");
            $sql->bindValue(":CODIGO",$codigo);
            $sql->bindValue(":USUARIO",$usuario);
            $sql->execute();

            $sql=$this->conn->prepare("DELETE FROM lancamentos_receitas
                                       WHERE TIPO_PAGAMENTO_ID=:CODIGO
                                         AND EXISTS(SELECT 1 FROM tipos_pagamentos T
                                                     WHERE T.CODIGO=lancamentos_receitas.TIPO_PAGAMENTO_ID 
                                                       AND T.USUARIO_ID=:USUARIO)");
            $sql->bindValue(":CODIGO",$codigo);
            $sql->bindValue(":USUARIO",$usuario);
            $sql->execute();

            $sql=$this->conn->prepare("DELETE FROM tipos_pagamentos
                                        WHERE CODIGO=:CODIGO
                                          AND USUARIO_ID=:USUARIO");
            $sql->bindValue(":CODIGO",$codigo);
            $sql->bindValue(":USUARIO",$usuario);
            $sql->execute();

        } 
	}
?>