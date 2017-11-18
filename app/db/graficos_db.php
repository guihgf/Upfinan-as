<?php
	require_once('conexao.php');
	header('Content-Type: text/html; charset=utf-8');
	class GraficoDB{
		private $conn;
		
		function __construct() {
			$this->conn=get_conexao();
		}
		
		function __destruct(){
			$this->conn=null;
		}
		
		function top_despesas_grupos($usuario,$conta,$data_ini, $data_fim){
			$sql=$this->conn->prepare("SELECT GL.NOME,
										   SUM(L.VALOR) TOTAL,
										   GL.CODIGO ID
									  FROM lancamentos_despesas L, grupos_despesas GL
									 WHERE L.GRUPO_ID=GL.CODIGO
									   AND L.DATA_PAGAMENTO BETWEEN :DATA_INI AND :DATA_FIM
									   AND GL.USUARIO_ID=:USUARIO
									   AND L.CONTA_ID=:CONTA
									GROUP BY GL.NOME,
											 GL.CODIGO
									ORDER BY TOTAL DESC
									LIMIT 0,5;");
			$sql->bindValue(":USUARIO", $usuario);
			$sql->bindValue(":CONTA", $conta);
			$sql->bindValue(":DATA_INI", $data_ini);
			$sql->bindValue(":DATA_FIM", $data_fim);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
			
		}
		function top_despesas_grupos_det($usuario,$id,$data_ini,$data_fim,$conta){
			$sql=$this->conn->prepare("SELECT L.CODIGO,L.NOME,DATE_FORMAT(L.DATA_PAGAMENTO,'%d/%m/%Y') DATA_PAGAMENTO,L.VALOR,C.NOME CONTA
										  FROM lancamentos_despesas L,contas C
										 WHERE L.CONTA_ID=C.CODIGO
										   AND L.DATA_PAGAMENTO BETWEEN :DATA_INI AND :DATA_FIM
										   AND L.GRUPO_ID=:GRUPO AND C.USUARIO_ID=:USUARIO
										   AND L.CONTA_ID=:CONTA");
			$sql->bindValue(":USUARIO", $usuario);
			$sql->bindValue(":GRUPO", $id);
			$sql->bindValue(":DATA_INI", $data_ini);
			$sql->bindValue(":DATA_FIM", $data_fim);
			$sql->bindValue(":CONTA", $conta);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);						   
		
		}
		
		function top_despesas_participantes($usuario,$conta,$data_ini,$data_fim){
			
			$sql=$this->conn->prepare("SELECT P.NOME,
										   SUM(L.VALOR) TOTAL,
										   P.CODIGO ID
									  FROM lancamentos_despesas L,participantes P
									 WHERE L.PARTICIPANTE_ID=P.CODIGO
									   AND L.DATA_PAGAMENTO BETWEEN :DATA_INI AND :DATA_FIM
									   AND P.USUARIO_ID=:USUARIO
									   AND L.CONTA_ID=:CONTA
									GROUP BY P.NOME,
											 P.CODIGO
									ORDER BY TOTAL DESC
									  LIMIT 0,5");
			$sql->bindValue(":USUARIO", $usuario);
			$sql->bindValue(":DATA_INI", $data_ini);
			$sql->bindValue(":DATA_FIM", $data_fim);
			$sql->bindValue(":CONTA", $conta);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
			
		}
		
		function top_despesas_participantes_det($usuario,$id,$data_ini,$data_fim,$conta){
			$sql=$this->conn->prepare("SELECT L.CODIGO,L.NOME,DATE_FORMAT(L.DATA_PAGAMENTO,'%d/%m/%Y') DATA_PAGAMENTO,L.VALOR,C.NOME CONTA
										  FROM lancamentos_despesas L,contas C
										 WHERE L.CONTA_ID=C.CODIGO
										   AND L.DATA_PAGAMENTO BETWEEN :DATA_INI AND :DATA_FIM
										   AND L.PARTICIPANTE_ID=:CODIGO AND C.USUARIO_ID=:USUARIO
										   AND L.CONTA_ID=:CONTA");
			$sql->bindValue(":USUARIO", $usuario);
			$sql->bindValue(":CODIGO", $id);
			$sql->bindValue(":DATA_INI", $data_ini);
			$sql->bindValue(":DATA_FIM", $data_fim);
			$sql->bindValue(":CONTA", $conta);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);		
		}
		
		function saldo_mes($usuario,$conta,$ano){
			$sql=$this->conn->prepare("select
									   q.descricao MES,
									   q.entrada-q.saida SALDO
									 from
									  (select m.descricao,
											 (select ifnull(sum(L.VALOR),0) 
												 from lancamentos_receitas L, contas C
												 where L.CONTA_ID=C.CODIGO
												   and C.USUARIO_ID=:USUARIO
												   and L.CONTA_ID=:CONTA
												   and L.DATA_CREDITO<=DATE_FORMAT(NOW(),'%Y-%m-%d')
												   and DATE_FORMAT(L.DATA_CREDITO,'%Y')=:ANO
												   and DATE_FORMAT(L.DATA_CREDITO,'%m')=m.mes) as entrada,
											  (select ifnull(sum(L.VALOR),0) 
												 from lancamentos_despesas L, contas C
												 where L.CONTA_ID=C.CODIGO
												   and C.USUARIO_ID=:USUARIO
												   and L.CONTA_ID=:CONTA
												   and L.DATA_PAGAMENTO<=DATE_FORMAT(NOW(),'%Y-%m-%d')
												   and DATE_FORMAT(L.DATA_PAGAMENTO,'%Y')=:ANO
												   and DATE_FORMAT(L.DATA_PAGAMENTO,'%m')=m.mes) as saida
										  from meses m
										  ) q;");
			$sql->bindValue(":USUARIO", $usuario);
			$sql->bindValue(":CONTA", $conta);
			$sql->bindValue(":ANO", $ano);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);		
		}
	}
?>