<?php
	require_once('conexao.php');
	
	class DespesaDB{
		private $conn;
		
		function __construct() {
			$this->conn=get_conexao();
		}
		
		function __destruct(){
			//$this->conn=null;
			unset($this->conn);
		}
		
		
		function lista_despesas_pag($usuario){
			$sql=$this->conn->prepare("SELECT L.CODIGO,
												 L.NOME LANCAMENTO,
												 DATE_FORMAT(L.DATA_VENCIMENTO,'%d/%m/%Y')DATA_VENCIMENTO,
												 CASE
                                                   WHEN L.DATA_PAGAMENTO IS NOT NULL THEN
													'Sim'
												   ELSE
												    'Não'
												 END AS PAGO,
												 C.NOME  CONTA,
												 (SELECT P.NOME FROM participantes P WHERE L.PARTICIPANTE_ID=P.CODIGO) PARTICIPANTE,
												 L.VALOR  AS VALOR,
												 T.NOME TIPO_PAGAMENTO,
												 G.NOME GRUPO_DESPESA
												 
											FROM lancamentos_despesas L,
												 contas C,
												 tipos_pagamentos T,
												 grupos_despesas G
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
		
		function inserir_despesa($values,$i,$data_vencimento,$data_pagamento,$conta,$grupo,$participante,$tipo_pagamento){
			$sql=$this->conn->prepare("INSERT INTO lancamentos_despesas
													(NOME,
													DATA_VENCIMENTO,
													DATA_PAGAMENTO,
													VALOR,
													OBSERVACAO,
													PARTICIPANTE_ID,
													CONTA_ID,
													GRUPO_ID,
													TIPO_PAGAMENTO_ID
													)
													VALUES
													(:NOME,
													:DATA_VENCIMENTO,
													:DATA_PAGAMENTO,
													:VALOR,
													:OBSERVACAO,
													:PARTICIPANTE_ID,
													:CONTA_ID,
													:GRUPO_ID,
													:TIPO_PAGAMENTO_ID
													)");

			$nome="";
			if ($values["parcela"]>1) {
				$parcela=$i+1;
				$nome=$values["nome"]." - ".$parcela."&ordf; Parcela";
				// $sql->bindValue(":NOME",$values["nome"]." - ".$parcela."&ordf; Parcela");
			}
			else
			{
				// $sql->bindValue(":NOME",$values["nome"]);
				$nome=$values["nome"];
			}

			$parameters=array('NOME'=>$nome,
								'DATA_VENCIMENTO' => $data_vencimento,
							   'DATA_PAGAMENTO' =>$data_pagamento,
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

		
		function selecionar_despesa($usuario,$id){
			$sql=$this->conn->prepare("SELECT  L.CODIGO,
											   L.NOME,
											   DATE_FORMAT(L.DATA_VENCIMENTO,'%d/%m/%Y')DATA_VENCIMENTO,
											   DATE_FORMAT(L.DATA_PAGAMENTO,'%d/%m/%Y')DATA_PAGAMENTO,
											   CASE
                                                   WHEN L.DATA_PAGAMENTO IS NOT NULL THEN
													'S'
												   ELSE
												    'N'
												 END AS PAGO,
											   CAST(VALOR as DECIMAL(18,2)) VALOR,
											   L.OBSERVACAO,
											   L.CONTA_ID,
											   L.GRUPO_ID,
											   L.PARTICIPANTE_ID,
											   L.TIPO_PAGAMENTO_ID
										  FROM lancamentos_despesas L,
											   contas C
										 WHERE L.conta_id=C.codigo
										   AND C.usuario_id=:USUARIO
										   AND L.codigo=:CODIGO");
			$sql->bindValue(":CODIGO",$id);
			$sql->bindValue(":USUARIO",$usuario);
			$sql->execute();
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
		
		function alterar_despesa($usuario,$values){
			$sql=$this->conn->prepare("UPDATE lancamentos_despesas L
										 SET L.NOME=:NOME,
										   L.DATA_VENCIMENTO=:DATA_VENCIMENTO,
										   L.DATA_PAGAMENTO=:DATA_PAGAMENTO,
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

			if ($values["data_vencimento"] !=null){
				$data_vencimento=date("Y-m-d", strtotime(str_replace('/', '-',$values["data_vencimento"])) );	
			}
			
			if($values["data_pagamento"]!=null){
				$data_pagamento=date("Y-m-d", strtotime(str_replace('/', '-',$values["data_pagamento"])) );	
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
			$sql->bindValue(":DATA_VENCIMENTO",$data_vencimento);
			$sql->bindValue(":DATA_PAGAMENTO",$data_pagamento);
			$sql->bindValue(":VALOR",$values["valor"]);
			$sql->bindValue(":OBSERVACAO",$values["observacao"]);
			$sql->bindValue(":USUARIO",$usuario);
			$sql->bindValue(":PARTICIPANTE_ID",$participante,PDO::PARAM_INT);
			$sql->bindValue(":CONTA_ID",$conta,PDO::PARAM_INT);
			$sql->bindValue(":GRUPO_ID",$grupo,PDO::PARAM_INT);
			$sql->bindValue(":TIPO_PAGAMENTO_ID",$tipo_pagamento,PDO::PARAM_INT);
			$sql->execute();
		}
		
		function deletar_despesa($usuario,$id){
			$sql=$this->conn->prepare("DELETE FROM lancamentos_despesas
									   WHERE CODIGO=:CODIGO
									     AND TRANSFERENCIA IS NULL
										 AND EXISTS(SELECT 1 FROM contas C 
													 WHERE C.CODIGO=lancamentos_despesas.CONTA_ID 
													   AND C.USUARIO_ID=:USUARIO)");
			$sql->bindValue(":CODIGO",$id);
			$sql->bindValue(":USUARIO",$usuario);
			$sql->execute();
		}

		function pagar($usuario,$id){
			$sql=$this->conn->prepare("UPDATE lancamentos_despesas L
										 SET L.DATA_PAGAMENTO=DATE_FORMAT(NOW(),'%Y-%m-%d')
										WHERE L.CODIGO=:CODIGO
										  AND EXISTS(SELECT 1 FROM contas C
													  WHERE C.CODIGO=L.CONTA_ID
														AND C.USUARIO_ID=:USUARIO)");
			$sql->bindValue(":CODIGO",$id);
			$sql->bindValue(":USUARIO",$usuario);
			$sql->execute();
		}
		function top_5_despesas_vencidas_det($usuario){
			$sql=$this->conn->prepare("SELECT L.CODIGO,
												 L.NOME LANCAMENTO,
												 DATE_FORMAT(L.DATA_VENCIMENTO,'%d/%m/%Y')DATA_VENCIMENTO,
												 CASE
                                                   WHEN L.DATA_PAGAMENTO IS NOT NULL THEN
													'Sim'
												   ELSE
												    'Não'
												 END AS PAGO,
												 C.NOME  CONTA,
												 (SELECT P.NOME FROM participantes P WHERE L.PARTICIPANTE_ID=P.CODIGO) PARTICIPANTE,
												 L.VALOR  AS VALOR,
												 T.NOME TIPO_PAGAMENTO,
												 G.NOME GRUPO_DESPESA
												 
											FROM lancamentos_despesas L,
												 contas C,
												 tipos_pagamentos T,
												 grupos_despesas G
											WHERE 
											  L.CONTA_ID=C.CODIGO
											  AND L.TIPO_PAGAMENTO_ID=T.CODIGO
											  AND L.GRUPO_ID=G.CODIGO
											  AND C.USUARIO_ID=:USUARIO
											  AND L.data_pagamento IS null
											  AND (DATE_FORMAT(L.data_vencimento,'%Y-%m-%d') BETWEEN DATE_FORMAT(NOW(),'%Y-%m-%d') AND date_add(DATE_FORMAT(NOW(),'%Y-%m-%d'), INTERVAL 5 DAY) 
												  OR DATE_FORMAT(L.data_vencimento,'%Y-%m-%d')<DATE_FORMAT(NOW(),'%Y-%m-%d'))
											ORDER BY L.CODIGO DESC");
			$sql->bindValue(":USUARIO",$usuario);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		function top_5_despesas_vencidas($usuario){
			$sql=$this->conn->prepare("SELECT LD.CODIGO,
				 							  LD.NOME,
				 							  DATE_FORMAT(LD.DATA_VENCIMENTO,'%d/%m/%Y') DATA_VENCIMENTO,
				 							  REPLACE( REPLACE( REPLACE( FORMAT(LD.VALOR  , 2 ) ,  ',',  ':' ) ,  '.',  ',' ) ,  ':',  '.' )  VALOR
										  FROM lancamentos_despesas LD,contas C
										WHERE LD.conta_id=C.codigo
										  AND C.usuario_id=:USUARIO
										  AND LD.data_pagamento IS null
										  AND (DATE_FORMAT(LD.data_vencimento,'%Y-%m-%d') BETWEEN DATE_FORMAT(NOW(),'%Y-%m-%d') AND date_add(DATE_FORMAT(NOW(),'%Y-%m-%d'), INTERVAL 5 DAY) 
											  OR DATE_FORMAT(LD.data_vencimento,'%Y-%m-%d')<DATE_FORMAT(NOW(),'%Y-%m-%d'))
										 limit 5");
			$sql->bindValue(":USUARIO",$usuario);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		function top_5_despesas_vencidas_tot($usuario){
			$sql=$this->conn->prepare("SELECT count(1)
										  FROM lancamentos_despesas LD,contas C
										WHERE LD.conta_id=C.codigo
										  AND C.usuario_id=:USUARIO
										  AND LD.data_pagamento IS null
										  AND (DATE_FORMAT(LD.data_vencimento,'%Y-%m-%d') BETWEEN DATE_FORMAT(NOW(),'%Y-%m-%d') AND date_add(DATE_FORMAT(NOW(),'%Y-%m-%d'), INTERVAL 5 DAY) 
											  OR DATE_FORMAT(LD.data_vencimento,'%Y-%m-%d')<DATE_FORMAT(NOW(),'%Y-%m-%d'))");
			$sql->bindValue(":USUARIO",$usuario);
			$sql->execute();
			return $sql->fetchColumn();
		}

		function resumo_despesa_mes($usuario,$conta){
			$sql=$this->conn->prepare("SELECT gp.NOME,
							REPLACE( REPLACE( REPLACE( FORMAT( SUM( ld.valor ) , 2 ) ,  ',',  ':' ) ,  '.',  ',' ) ,  ':',  '.' ) VALOR_TOTAL
								  FROM lancamentos_despesas ld,
									   grupos_despesas gp
								 WHERE ld.grupo_id=gp.codigo
								   AND gp.usuario_id=:USUARIO
								   AND ld.conta_id=:CONTA
								   AND (ld.data_pagamento between  DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() )
							           GROUP BY gp.NOME
");
			$sql->bindValue(":USUARIO",$usuario);
			$sql->bindValue(":CONTA",$conta);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

?>