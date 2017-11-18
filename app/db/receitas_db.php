<?php
	require_once('conexao.php');
	
	class ReceitaDB{
		private $conn;
		
		function __construct() {
			$this->conn=get_conexao();
		}
		
		function __destruct(){
			$this->conn=null;
		}
		
		
		function lista_receitas_pag($usuario){
			$sql=$this->conn->prepare("SELECT L.CODIGO,
												 L.NOME LANCAMENTO,
												 DATE_FORMAT(L.DATA_CREDITO,'%d/%m/%Y')DATA_CREDITO,
												 
												 C.NOME  CONTA,
												 (SELECT P.NOME FROM participantes P WHERE L.PARTICIPANTE_ID=P.CODIGO) PARTICIPANTE,
												 L.VALOR  AS VALOR,
												 T.NOME TIPO_PAGAMENTO,
												 G.NOME GRUPO_RECEITA
												 
											FROM lancamentos_receitas L,
												 contas C,
												 tipos_pagamentos T,
												 grupos_receitas G
											WHERE 
											  L.CONTA_ID=C.CODIGO
											  AND L.TIPO_PAGAMENTO_ID=T.CODIGO
											  AND L.GRUPO_ID=G.CODIGO
											  AND C.USUARIO_ID=:USUARIO
											ORDER BY L.CODIGO DESC");

            $sql->bindValue(":USUARIO", $usuario);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		
		function inserir_receita($values,$i,$data_credito,$conta,$grupo,$participante,$tipo_pagamento){
			$sql=$this->conn->prepare("INSERT INTO lancamentos_receitas
													(NOME,
													DATA_CREDITO,
													VALOR,
													OBSERVACAO,
													PARTICIPANTE_ID,
													CONTA_ID,
													GRUPO_ID,
													TIPO_PAGAMENTO_ID
													)
													VALUES
													(:NOME,
													:DATA_CREDITO,
													:VALOR,
													:OBSERVACAO,
													:PARTICIPANTE_ID,
													:CONTA_ID,
													:GRUPO_ID,
													:TIPO_PAGAMENTO_ID
													)");

			$parameters=array('NOME'=>$values["nome"],
								'DATA_CREDITO' => $data_credito,
							   'VALOR'=>$values["valor"],
							   'OBSERVACAO'=>$values["observacao"],
							   'PARTICIPANTE_ID'=>$participante,
							   'CONTA_ID'=>$conta,
							   'GRUPO_ID'=>$grupo,
							   'TIPO_PAGAMENTO_ID'=>$tipo_pagamento);

			/*echo sql_debug($sql->queryString,$parameters);
			exit;*/

			$sql->execute($parameters);
		}

		
		function selecionar_receita($usuario,$id){
			$sql=$this->conn->prepare("SELECT  L.CODIGO,
											   L.NOME,
											   DATE_FORMAT(L.DATA_CREDITO,'%d/%m/%Y')DATA_CREDITO,
											   CAST(VALOR as DECIMAL(18,2)) VALOR,
											   L.OBSERVACAO,
											   L.CONTA_ID,
											   L.GRUPO_ID,
											   L.PARTICIPANTE_ID,
											   L.TIPO_PAGAMENTO_ID
										  FROM lancamentos_receitas L,
											   contas C
										 WHERE L.conta_id=C.codigo
										   AND C.usuario_id=:USUARIO
										   AND L.codigo=:CODIGO");
			$sql->bindValue(":CODIGO",$id);
			$sql->bindValue(":USUARIO",$usuario);
			$sql->execute();
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
		
		function alterar_receita($usuario,$values){
			$sql=$this->conn->prepare("UPDATE lancamentos_receitas L
										 SET L.NOME=:NOME,
										   L.DATA_CREDITO=:DATA_CREDITO,
										   L.VALOR=:VALOR,
										   L.OBSERVACAO=:OBSERVACAO,
										   L.CONTA_ID=:CONTA_ID,
										   L.GRUPO_ID=:GRUPO_ID,
										   L.PARTICIPANTE_ID=:PARTICIPANTE_ID,
										   L.TIPO_PAGAMENTO_ID=:TIPO_PAGAMENTO_ID
									WHERE L.CODIGO=:CODIGO
									  AND EXISTS(SELECT 1 FROM contas C
												  WHERE C.CODIGO=L.CONTA_ID
													AND C.USUARIO_ID=:USUARIO)");

			if ($values["data_credito"] !=null){
				$data_credito=date("Y-m-d", strtotime(str_replace('/', '-',$values["data_credito"])) );	
			}
			
			$conta=$values["busca_conta"];;
		
			if($values["busca_participantes"]==""){
				$participante=null;
			}
			else{
				$participante=$values["busca_participantes"];
			}
			
			$grupo=$values["busca_grupos"];

			$tipo_pagamento=$values["tipo_pagamento"];
			
			$sql->bindValue(":CODIGO",$values["codigo"]);
			$sql->bindValue(":NOME",$values["nome"]);
			$sql->bindValue(":DATA_CREDITO",$data_credito);
			$sql->bindValue(":VALOR",$values["valor"]);
			$sql->bindValue(":OBSERVACAO",$values["observacao"]);
			$sql->bindValue(":USUARIO",$usuario);
			$sql->bindValue(":PARTICIPANTE_ID",$participante,PDO::PARAM_INT);
			$sql->bindValue(":CONTA_ID",$conta,PDO::PARAM_INT);
			$sql->bindValue(":GRUPO_ID",$grupo,PDO::PARAM_INT);
			$sql->bindValue(":TIPO_PAGAMENTO_ID",$tipo_pagamento,PDO::PARAM_INT);
			$sql->execute();
		}
		
		function deletar_receita($usuario,$id){
			$sql=$this->conn->prepare("DELETE FROM lancamentos_receitas
									   WHERE CODIGO=:CODIGO
									     AND TRANSFERENCIA IS NULL
										 AND EXISTS(SELECT 1 FROM contas C 
													 WHERE C.CODIGO=lancamentos_receitas.CONTA_ID 
													   AND C.USUARIO_ID=:USUARIO)");
			$sql->bindValue(":CODIGO",$id);
			$sql->bindValue(":USUARIO",$usuario);
			$sql->execute();
		}

		function resumo_receita_mes($usuario,$conta){
			$sql=$this->conn->prepare("SELECT gp.NOME,
									    REPLACE( REPLACE( REPLACE( FORMAT( SUM( ld.valor ) , 2 ) ,  ',',  ':' ) ,  '.',  ',' ) ,  ':',  '.' ) VALOR_TOTAL
								  FROM lancamentos_receitas ld,
									   grupos_receitas gp
								 WHERE ld.grupo_id=gp.codigo
								   AND gp.usuario_id=:USUARIO
								   AND ld.conta_id=:CONTA
								   AND (ld.data_credito between  DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() )
							           group by gp.NOME");
			$sql->bindValue(":USUARIO",$usuario);
			$sql->bindValue(":CONTA",$conta);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

?>