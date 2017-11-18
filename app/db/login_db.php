<?php
	require_once('conexao.php');
	
	class LoginDB{
		private $conn;
		
		function __construct() {
			$this->conn=get_conexao();
		}
		
		function __destruct(){
			$this->conn=null;
		}
		
		function autenticar_usuario($values){
			$sql=$this->conn->prepare("SELECT ID, NOME, EMAIL,STATUS,CONFIGURACAO_INICIAL,PLANO_ID PLANO FROM usuarios U 
										WHERE U.EMAIL=:EMAIL
										  AND U.SENHA=:SENHA");


			$parameters=array('EMAIL'=>$values["email"],
								'SENHA' => $values["senha"]);

			$sql->execute($parameters);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}

		function alterar_senha($values,$usuario){
			$sql=$this->conn->prepare("UPDATE usuarios SET senha=:SENHA
									   WHERE id=:USUARIO");
			$sql->bindValue(":USUARIO",$usuario);
			$sql->bindValue(":SENHA",$values["senha"]);
			$sql->execute();	

		}

		function selecionar_usuario($values){
			$sql=$this->conn->prepare("SELECT ID,NOME,EMAIL,SENHA FROM usuarios U 
										WHERE U.EMAIL=:EMAIL");
			$sql->bindValue(":EMAIL",$values["email"]);
			$sql->execute();
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
		
		function reativar_usuario($email){
			$sql=$this->conn->prepare("UPDATE usuarios SET STATUS=2, DATA_REATIVACAO=CURRENT_TIMESTAMP,MOTIVO=NULL 
									   WHERE EMAIL=:EMAIL");
			$sql->execute();									
		}
		
		function verificar_email($email){
			$sql=$this->conn->prepare("SELECT COUNT(1) FROM usuarios U 
										WHERE U.EMAIL=:EMAIL");
			$sql->bindValue(":EMAIL",$email);
			$sql->execute();
			return $sql->fetchColumn();
		}

		function inserir_usuario($values){
			$sql=$this->conn->prepare("INSERT INTO usuarios (email, 
                                                              senha, 
                                                              nome,
															  status,
															  plano_id) 
                                                        VALUES (:email, 
                                                                :senha, 
                                                                :nome,
																2,
																1)");

            $sql->bindValue(":email", $values["email"]);
            $sql->bindValue(":senha", $values["senha"]);
            $sql->bindValue(":nome", $values["nome"]);
            $sql->execute();

		}

		function finalizar_cadastro($values,$usuario){
			$sql=$this->conn->prepare("update usuarios set email=:EMAIL,nome=:NOME,sexo=:SEXO,configuracao_inicial=1
               	                      where id=:USUARIO");

            $sql->bindValue(":EMAIL", $values["email"]);
            $sql->bindValue(":NOME", $values["nome"]);
            $sql->bindValue(":SEXO", $values["sexo"]);
            $sql->bindValue(":USUARIO", $usuario);
            $sql->execute();

            $sql=$this->conn->prepare("insert into contas (nome,padrao,status,usuario_id) 
            	                       values(:CONTA,2,1,:USUARIO)");

            $sql->bindValue(":CONTA", $values["conta"]);
            $sql->bindValue(":USUARIO", $usuario);

            $sql->execute();

 			//Grupos de Lançamentos

 			$sql=$this->conn->prepare("INSERT INTO grupos_despesas(NOME,STATUS,USUARIO_ID) VALUES('Alimentação',1,". $usuario.")");
 			$sql->execute();

 			$sql=$this->conn->prepare("INSERT INTO grupos_despesas(NOME,STATUS,USUARIO_ID) VALUES('Segurança',1,". $usuario.")");
 			$sql->execute();

 			$sql=$this->conn->prepare("INSERT INTO grupos_despesas(NOME,STATUS,USUARIO_ID) VALUES('Transporte',1,". $usuario.")");
 			$sql->execute();

 			$sql=$this->conn->prepare("INSERT INTO grupos_despesas(NOME,STATUS,USUARIO_ID) VALUES('Moradia',1,". $usuario.")");
 			$sql->execute();

 			$sql=$this->conn->prepare("INSERT INTO grupos_despesas(NOME,STATUS,USUARIO_ID) VALUES('Saúde',1,". $usuario.")");
 			$sql->execute();
 				
 			$sql=$this->conn->prepare("INSERT INTO grupos_despesas(NOME,STATUS,USUARIO_ID) VALUES('Educação',1,". $usuario.")");
 			$sql->execute();
 			
 			$sql=$this->conn->prepare("INSERT INTO grupos_despesas(NOME,STATUS,USUARIO_ID) VALUES('Lazer',1,". $usuario.")");
 			$sql->execute();	

 			$sql=$this->conn->prepare("INSERT INTO grupos_despesas(NOME,STATUS,USUARIO_ID) VALUES('Outros',1,". $usuario.")");
 			$sql->execute();

 			$sql=$this->conn->prepare("INSERT INTO grupos_receitas(NOME,STATUS,USUARIO_ID) VALUES('Salários',1,". $usuario.")");
 			$sql->execute();

 			$sql=$this->conn->prepare("INSERT INTO grupos_receitas(NOME,STATUS,USUARIO_ID) VALUES('Comissões',1,". $usuario.")");
 			$sql->execute();

 			$sql=$this->conn->prepare("INSERT INTO grupos_receitas(NOME,STATUS,USUARIO_ID) VALUES('Premiações',1,". $usuario.")");
 			$sql->execute();

 			$sql=$this->conn->prepare("INSERT INTO grupos_receitas(NOME,STATUS,USUARIO_ID) VALUES('Investimentos',1,". $usuario.")");
 			$sql->execute();

 			$sql=$this->conn->prepare("INSERT INTO tipos_pagamentos(NOME,STATUS,USUARIO_ID) VALUES('Dinheiro',1,". $usuario.")");
 			$sql->execute();

 			$sql=$this->conn->prepare("INSERT INTO tipos_pagamentos(NOME,STATUS,USUARIO_ID) VALUES('Cartão de Crédito',1,". $usuario.")");
 			$sql->execute();

 			$sql=$this->conn->prepare("INSERT INTO tipos_pagamentos(NOME,STATUS,USUARIO_ID) VALUES('Cheque',1,". $usuario.")");
 			$sql->execute();
		}

	}

?>