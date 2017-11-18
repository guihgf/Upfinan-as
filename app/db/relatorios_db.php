<?php
	require_once('conexao.php');
	header('Content-Type: text/html; charset=utf-8');
	class RelatorioDB{
		private $conn;
		
		function __construct() {
			$this->conn=get_conexao();
		}
		
		function __destruct(){
			$this->conn=null;
		}
		
		function extrato($usuario,$conta,$data_ini,$data_fim){
			$sql=$this->conn->prepare("SELECT DATE_FORMAT(Q.DATA_PAGAMENTO,'%d/%m/%Y') DATA_PAGAMENTO,
												Q.NOME,
												Q.CODIGO,
												Q.VALOR,
												Q.DATA_INI,
												Q.TIPO
										  FROM(
													SELECT :DATA_INI DATA_PAGAMENTO,
													         'SALDO ANTERIOR' NOME,
													         NULL CODIGO,
													         NULL VALOR,
													         DATE_ADD(:DATA_INI,INTERVAL -1 DAY) DATA_INI,
													         1 TIPO
													UNION
													SELECT LD.DATA_CREDITO DATA_PAGAMENTO ,
													         LD.NOME,
													         LD.CODIGO,
													         LD.VALOR,
													         CASE LD.CODIGO WHEN  (SELECT MIN(LD2.CODIGO) 
													                                  FROM lancamentos_receitas LD2 
													                                         WHERE  DATE_FORMAT(LD2.DATA_CREDITO,'%Y-%m-%d')=DATE_FORMAT(LD.DATA_CREDITO,'%Y-%m-%d')
													                                           AND LD2.CONTA_ID=LD.CONTA_ID) THEN
													             DATE_FORMAT(LD.DATA_CREDITO,'%Y-%m-%d')

													         ELSE
													             NULL
													        END AS DATA_INI,
													         2 TIPO                                  
													    FROM lancamentos_receitas LD, contas C
													WHERE DATE_FORMAT(LD.DATA_CREDITO,'%Y-%m-%d')  BETWEEN :DATA_INI AND :DATA_FIM
													  AND LD.CONTA_ID=C.CODIGO
													  AND LD.CONTA_ID=:CONTA
													  AND C.USUARIO_ID=:USUARIO
													  AND DATE_FORMAT(LD.DATA_CREDITO,'%Y-%m-%d')  <= DATE_FORMAT(NOW(),'%Y-%m-%d')
													UNION
													SELECT LD.DATA_PAGAMENTO DATA_PAGAMENTO ,
													         LD.NOME,
													         LD.CODIGO,
													         LD.VALOR*-1,
													         CASE LD.CODIGO WHEN  (SELECT MIN(LD2.CODIGO) 
													                                  FROM lancamentos_despesas LD2 
													                                         WHERE  DATE_FORMAT(LD2.DATA_PAGAMENTO,'%Y-%m-%d')=DATE_FORMAT(LD.DATA_PAGAMENTO,'%Y-%m-%d')
													                                           AND LD2.CONTA_ID=LD.CONTA_ID
													                                            AND NOT EXISTS(SELECT 1 FROM lancamentos_receitas LR
													                                                                 WHERE LR.CONTA_ID=LD.CONTA_ID AND DATE_FORMAT(LR.DATA_CREDITO,'%Y-%m-%d')=DATE_FORMAT(LD.DATA_PAGAMENTO,'%Y-%m-%d'))) THEN
													             DATE_FORMAT(LD.DATA_PAGAMENTO,'%Y-%m-%d')
													         ELSE
													             NULL
													        END AS DATA_INI,
													         3 TIPO                              
													    FROM lancamentos_despesas LD,contas C 
													WHERE DATE_FORMAT(LD.DATA_PAGAMENTO,'%Y-%m-%d')  BETWEEN :DATA_INI AND :DATA_FIM
													  AND LD.CONTA_ID=C.CODIGO
													  AND LD.CONTA_ID=:CONTA
													  AND C.USUARIO_ID=:USUARIO
													  AND DATE_FORMAT(LD.DATA_PAGAMENTO,'%Y-%m-%d')  <= DATE_FORMAT(NOW(),'%Y-%m-%d')
													ORDER BY DATA_PAGAMENTO,TIPO, DATA_INI DESC,CODIGO) Q");
			$sql->bindValue(":USUARIO", $usuario);
			$sql->bindValue(":CONTA", $conta);
			$sql->bindValue(":DATA_INI", $data_ini);
			$sql->bindValue(":DATA_FIM", $data_fim);
			$sql->execute();

			$lancamentos=$sql->fetchAll(PDO::FETCH_ASSOC);

			foreach ($lancamentos as $chave => $valor){
				$saldo=null;

				if($valor['TIPO']=1 && $valor['DATA_INI']!=null){
					$data=$valor['DATA_INI'];
					$sql=$this->conn->prepare("CALL saldo_conta_dia($conta,$usuario,'$data',@_valor)");
					$sql->execute();
					$sql->closeCursor();

					$saldo= $this->conn->query("select @_valor")->fetchColumn();
				}

				if($valor['TIPO']=2 && $valor['DATA_INI']!=null){
					$data=$valor['DATA_INI'];
					$sql=$this->conn->prepare("CALL saldo_conta_dia($conta,$usuario,'$data',@_valor)");
					$sql->execute();
					$sql->closeCursor();

					$saldo= $this->conn->query("select @_valor")->fetchColumn();
				}

				if($valor['TIPO']=3 && $valor['DATA_INI']!=null){
					$data=$valor['DATA_INI'];
					$sql=$this->conn->prepare("CALL saldo_conta_dia($conta,$usuario,'$data',@_valor)");
					$sql->execute();
					$sql->closeCursor();

					$saldo= $this->conn->query("select @_valor")->fetchColumn();
				}

				$lancamentos[$chave]['SALDO']=$saldo;
			}

			return $lancamentos;
		}
		
	}
?>