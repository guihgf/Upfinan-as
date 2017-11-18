<?php
	require_once('conexao.php');
	
	class GrupoReceitasDB{
		private $conn;
		
		function __construct() {
			$this->conn=get_conexao();
		}
		
		function __destruct(){
			$this->conn=null;
		}
		
		function listar_grupos($usuario,$incluir_desativados){
			if($incluir_desativados)
				$query="SELECT CODIGO,NOME FROM grupos_receitas G WHERE G.USUARIO_ID=:USUARIO ORDER BY CODIGO DESC";
			else
				$query="SELECT CODIGO,NOME FROM grupos_receitas G WHERE G.USUARIO_ID=:USUARIO AND G.STATUS=1 ORDER BY CODIGO DESC";
			
			$sql=$this->conn->prepare($query);
			$sql->bindValue(":USUARIO",$usuario);			
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		
		
		function listar_grupos_pag($usuario){
			$sql=$this->conn->prepare("SELECT CODIGO,
											  NOME,
											  DATE_FORMAT(DATA_CADASTRO,'%d/%m/%Y') DATA_CADASTRO,
											  STATUS,
											  (SELECT IFNULL(SUM(L.VALOR),0) FROM lancamentos_receitas L WHERE L.GRUPO_ID=G.CODIGO AND L.DATA_CREDITO <=DATE_FORMAT(NOW(),'%Y-%m-%d')) TOTAL_GANHO
											  FROM grupos_receitas G
											  WHERE G.USUARIO_ID=:USUARIO
											  ORDER BY G.CODIGO DESC");

			$sql->bindValue(":USUARIO", $usuario);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
				
		function inserir_grupo($usuario,$values){
			$sql=$this->conn->prepare("INSERT INTO grupos_receitas(NOME,
																	STATUS,
																	USUARIO_ID)
															VALUES(:NOME,
																	1,
																	:USUARIO)");
			$sql->bindValue(":NOME", $values["nome"]);
			$sql->bindValue(":USUARIO", $usuario);
			$sql->execute();
		}
		
		function selecionar_grupo($usuario,$id){
			$sql= $this->conn->prepare("SELECT CODIGO,
												NOME                                                 
											  FROM grupos_receitas G 
											 WHERE G.USUARIO_ID=:USUARIO
											   AND G.CODIGO=:CODIGO");

			$sql->bindValue(":USUARIO", $usuario);
			$sql->bindValue(":CODIGO", $id);
			$sql->execute();
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
		
		function alterar_grupo($usuario,$values){
			$sql= $this->conn->prepare("UPDATE grupos_receitas SET NOME=:NOME
										WHERE USUARIO_ID=:USUARIO
										  AND CODIGO=:CODIGO");
			$sql->bindValue(":NOME", $values["nome"]);
			$sql->bindValue(":USUARIO", $usuario);
			$sql->bindValue(":CODIGO", $values["codigo"]);
			$sql->execute();
		}
		
		function atualizar_status_grupo($usuario,$id,$status){
			$query="";
			if($status==2)
			{
				$query="UPDATE grupos_receitas SET STATUS=:STATUS,DATA_DESATIVACAO=CURRENT_TIMESTAMP WHERE CODIGO=:CODIGO AND USUARIO_ID=:USUARIO"; 
			}
			else {
				$query="UPDATE grupos_receitas SET STATUS=:STATUS, DATA_DESATIVACAO=NULL WHERE CODIGO=:CODIGO AND USUARIO_ID=:USUARIO";
			}
			
			$sql= $this->conn->prepare($query);
			$sql->bindValue(":CODIGO", $id);
			$sql->bindValue(":STATUS", $status);
			$sql->bindValue(":USUARIO", $usuario);
			$sql->execute();
		
		}
		function deletar_grupos_receitas($usuario,$codigo){

			$sql=$this->conn->prepare("DELETE FROM lancamentos_receitas
									   WHERE GRUPO_ID=:CODIGO
										 AND EXISTS(SELECT 1 FROM grupos_receitas G 
													 WHERE G.CODIGO=lancamentos_receitas.GRUPO_ID 
													   AND G.USUARIO_ID=:USUARIO)");
			$sql->bindValue(":CODIGO",$codigo);
			$sql->bindValue(":USUARIO",$usuario);
			$sql->execute();

			$sql=$this->conn->prepare("DELETE FROM grupos_receitas
									  	WHERE CODIGO=:CODIGO
									  	  AND USUARIO_ID=:USUARIO");
			$sql->bindValue(":CODIGO",$codigo);
			$sql->bindValue(":USUARIO",$usuario);
			$sql->execute();

		}
	}
?>