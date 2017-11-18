<?php
	require_once('conexao.php');
	header('Content-Type: text/html; charset=utf-8');
	class InstrucaoDB{
		private $conn;
		
		function __construct() {
			$this->conn=get_conexao();
		}
		
		function __destruct(){
			$this->conn=null;
		}
		
		function get_instrucao($codigo, $usuario){
			$sql=$this->conn->prepare("SELECT CODIGO, 
												ASSUNTO,
												MENSAGEM
										   FROM instrucoes
										  WHERE CODIGO=:CODIGO
										    AND NOT EXISTS(SELECT 1 FROM instrucoes_usuarios IU 
										    				WHERE IU.CODIGO=instrucoes.CODIGO AND USUARIO_ID=:USUARIO)");
			$sql->bindValue(":USUARIO", $usuario);
			$sql->bindValue(":CODIGO", $codigo);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
			
		}	

		function desativar_instrucao($codigo,$usuario)
		{
			$sql=$this->conn->prepare("INSERT INTO instrucoes_usuarios VALUES(:CODIGO,:USUARIO)");
			$sql->bindValue(":CODIGO", $codigo);
			$sql->bindValue(":USUARIO", $usuario);
			$sql->execute();
		}

	}
?>