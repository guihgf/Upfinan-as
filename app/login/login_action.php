<?php
    //require('../db/conexao.php');
	require('../db/login_db.php');
    require('../../phpmailer/mail.php');
    require('../../facebook/facebook.php');
    require('../../rest/Rest.inc.php');
    include('../../mailchimp/MailChimp.php');
    
    class LoginAction extends REST {
		public $logindb;
        function index(){
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
			session_start();

            if(isset($_SESSION["usuario"])){
                header("Location:../home/index");
            }

            //login com facebook
            if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['code'])){
                // Informe o seu App ID abaixo

                $appId = 'seu app id';
                // Digite o App Secret do seu aplicativo abaixo:

                $appSecret = 'seu app secret';

                // Url informada no campo "Site URL"

                $redirectUri = urlencode('http://www.upfinancas.com.br/sistema/app/login/index');

                // Obtém o código da query string
                $code = $_GET['code'];

                // Monta a url para obter o token de acesso e assim obter os dados do usuário

                $token_url = "https://graph.facebook.com/oauth/access_token?". "client_id=" . $appId . "&redirect_uri=" . $redirectUri
                . "&client_secret=" . $appSecret . "&code=" . $code;

                //pega os dados
                $response = @file_get_contents($token_url);
                if($response){
                    $params = null;
                    parse_str($response, $params);
                    if(isset($params['access_token']) && $params['access_token']){
                      $graph_url = "https://graph.facebook.com/me?access_token="
                      . $params['access_token'];
                      $user = json_decode(file_get_contents($graph_url));

                      // nesse IF verificamos se veio os dados corretamente
                      if(isset($user->email) && $user->email){
                        $dados['email']=$user->email;
                        $dados['nome']=$user->name;
                        $dados['senha']="facebook_user";

                        $resultado=$this->logindb->verificar_email($dados['email']);
                        if($resultado==0){
                            $this->logindb->inserir_usuario($dados,"facebook_user");
                        }
                        
                        $usuario=$this->logindb->autenticar_usuario($dados);
                        if($usuario<>null){
                            $_SESSION["usuario"]= $usuario["ID"];
                            $_SESSION["nome_usuario"]= $usuario["NOME"];
                            $_SESSION["email"]= $usuario["EMAIL"];
                            $_SESSION["configuracao_inicial"]= $usuario["CONFIGURACAO_INICIAL"];
                            $_SESSION["tipo_usuario"]="facebook";
                            $_SESSION["plano"]=$usuario["PLANO"];
			    //reativação
                            if($usuario["STATUS"]==3){
                                $this->logindb->reativar_usuario($usuario["EMAIL"]);
                            }

                            header('Location:../home/index');   
                        }

                        /*$_SESSION['email'] = $user->email;
                        $_SESSION['nome'] = $user->name;
                        $_SESSION['localizacao'] = $user->location->name;
                        $_SESSION['uid_facebook'] = $user->id;
                        $_SESSION['user_facebook'] = $user->username;
                        $_SESSION['link_facebook'] = $user->link;*/
                      }
                    }else{
                        $_SESSION["msg"]="Erro de conexão com Facebook";
                        $_SESSION["tipo_msg"]=2;
                    }
                }else{
                    $_SESSION["msg"]="Erro de conexão com Facebook";
                    $_SESSION["tipo_msg"]=2;
                }
            }else if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['error'])){
                $_SESSION["msg"]="Permissão não concedida";
                $_SESSION["tipo_msg"]=2;
            }

			include('index.php');            
        }
        
        function cadastro(){
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
			
            include('cadastro.php');

        }
        
        function autenticar(){
            if($this->get_request_method() != "POST")
            {
                $this->response('',406);
            }
            try
			{
				session_start();
				$usuario=$this->logindb->autenticar_usuario($_POST);
				if($usuario<>null){
					$_SESSION["usuario"]= $usuario["ID"];
					$_SESSION["nome_usuario"]= $usuario["NOME"];
					$_SESSION["email"]= $usuario["EMAIL"];
					$_SESSION["configuracao_inicial"]= $usuario["CONFIGURACAO_INICIAL"];
                    $_SESSION["plano"]=$usuario["PLANO"];

                    if($usuario["SENHA"]=="facebook_user"){
                       $_SESSION["facebook_user"] = "S";
                    }
                    else{
                        $_SESSION["facebook_user"] = "N";
                    }
					//reativação
					if($usuario["STATUS"]==3){
						$this->logindb->reativar_usuario($usuario["EMAIL"]);
					}

				    header('Location:../home/index');	
				}
				else {
					$_SESSION["msg"]="Usuário e/ou senha incorreto(s).";
					$_SESSION["tipo_msg"]=2;
					header('Location:index');
				} 
            }
			catch(Exception $e){
				$_SESSION["msg"]="Erro: ".$e->getMessage();
				$_SESSION["tipo_msg"]=2;
				header('Location:index');
			}
        }
        
        function verificar_email(){
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            $resultado=$this->logindb->verificar_email($_GET["email"]);
            if($resultado==1){
                echo 'nok';
            }
            else{
                echo 'ok';
            }
        }
		
		function encerrar_sessao(){
			if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
			session_start();
			session_unset(); 
			session_destroy();
			header("Location:index");
		}

		function configuracao_inicial(){
			if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            session_start();
			include('configuracao_inicial.php');
		}

		function finalizar_cadastro(){
			//openSession();
			session_start();
			if($this->get_request_method() != "POST")
            {
                $this->response('',406);
            }
            try
            {
            	$this->logindb->finalizar_cadastro($_POST,$_SESSION['usuario']);
            	$_SESSION["configuracao_inicial"]=1;

            }
            catch(Exception $e){
            	echo($e->getMessage());
            	exit;
            }

            try
            {
                $MailChimp = new MailChimp('sua key');
                $result = $MailChimp->call('lists/subscribe', array(
                                'id'                => 'seu id',
                                'email'             => array('email'=>$_POST["email"]),
                                'merge_vars'        => array('FNAME'=>$_POST["nome"]),
                                'double_optin'      => false,
                                'update_existing'   => true,
                                'replace_interests' => false,
                                'send_welcome'      => false,
                            ));
               /* var_dump($result);
                exit;*/
            }
            catch(Exception $e){
                header("Location:../home/index");    
            }

            
            header("Location:../home/index");


		}

		function alterar_senha(){
			if($this->get_request_method() != "POST")
            {
                $this->response('',406);
            }
            openSession();

            try{
            	$this->logindb->alterar_senha($_POST,$_SESSION["usuario"]);
            	$_SESSION["msg"]="Senha alterada com sucesso.";
				$_SESSION["tipo_msg"]=1;
            }
            catch(Exception $e){
				$_SESSION["msg"]="Erro ao alterar a senha: ".$e->getMessage();
				$_SESSION["tipo_msg"]=2;
            }
           
			header("Location:../home/index");

		}

		function recuperar_senha()
        {
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }

            session_start();
			
			$usuario=$this->logindb->selecionar_usuario($_GET);

			/*var_dump($usuario);
            exit;*/
            if($usuario){

                $msg = "Olá ".$usuario['NOME']."<br/><br/>
						A sua atual senha é: ".$usuario['SENHA']."<br/><br/>
						Tenha uma vida financeira mais saudável com a Upfinanças. Controle contas, lançamentos, grupos e muito mais!";
                try
                {
					send_mail($_GET["email"],'Recuperação de Senha - Upfinanças',$msg);
					$_SESSION["msg"]="Foi enviado um e-mail para você com a senha.";
					$_SESSION["tipo_msg"]=1;
                }
                catch (Exception $ex)
                {
					$_SESSION["msg"]="Ocorreu um erro ao solicitar a senha: ".$ex->getMessage();
					$_SESSION["tipo_msg"]=2;
                }
            }
            else{
                $_SESSION["msg"]="E-mail inválido";
                $_SESSION["tipo_msg"]=2;
            }            

			header("Location:index");
		}
        	
        
        function create_usuario()
        {
            if($this->get_request_method() != "POST")
            {
                $this->response('',406);
            }
            //validando captcha para ver se javascript foi desativado.
            $num1 = isset($_POST['num1']) ? $_POST['num1'] : "";
            $num2 = isset($_POST['num2']) ? $_POST['num2'] : "";
            $total = isset($_POST['captcha']) ? $_POST['captcha'] : "";

            if ((intval($num1)+intval($num2))<>intval($total))
            {
                header('Location: create.php');
            }
            else
            {
                try
                {
                    $this->logindb->inserir_usuario($_POST);

                    //E-mail
                    $msg = "<b>Bem vindo(a) ao Upfinanças.</b><br/><br/>".
                            "Segue os dados para acesso: <br/><br/>". 
                            "Login para acesso: <b>".$_POST["email"]."</b><br/>".
                            "Aprenda a utilizar o sistema rapidinho em https://www.youtube.com/watch?v=LYHeZIHiFdk&list=PL9N6g2ub0edtlr53h15NvkmAcUpgngHay <br/><br/>".

                            "Tenha uma vida financeira mais saudável com a Upfinanças. Controle contas, lançamentos, grupos e muito mais!";

                    send_mail($_POST["email"],'Bem vindo(a) ao Up Finanças',$msg);

                    $usuario=$this->logindb->autenticar_usuario(["email"=>$_POST["email"],"senha"=>$_POST["senha"]]);

                    if($usuario<>null){
                        session_start();
                        $_SESSION["usuario"]= $usuario["ID"];
                        $_SESSION["nome_usuario"]= $usuario["NOME"];
                        $_SESSION["email"]= $usuario["EMAIL"];
                        $_SESSION["configuracao_inicial"]= $usuario["CONFIGURACAO_INICIAL"];
                        $_SESSION["plano"]=$usuario["PLANO"];
                        $_SESSION["facebook_user"] = "N";

                        header('Location:../home/index');
                    }
                    else{
                        $_SESSION["msg"]="Não foi possível realizar o seu cadastro.";
                        $_SESSION["tipo_msg"]=2;
                    }
					

                }
                catch (Exception $e)
                {
					$_SESSION["msg"]="Não foi possível realizar o cadastro. Erro: ".$e->getMessage();
					$_SESSION["tipo_msg"]=2;
					include('cadastro.php');
                }
            }
        }
		
				
		
    }	
    $api = new LoginAction;
	$api->logindb=new LoginDB();
    $api->processApi();
    
    
