<?php
require_once('conexao.php');

class ContaDB
{
    private $conn;

    function __construct()
    {
        $this->conn = get_conexao();
    }

    function __destruct()
    {
        $this->conn = null;
    }

    function saldo_conta($usuario, $id)
    {


        $sql = $this->conn->prepare("CALL saldo_conta($id,$usuario,0,@_valor)");
        $sql->execute();
        $sql->closeCursor();

        $saldo = $this->conn->query("select @_valor")->fetchColumn();

        $sql = $this->conn->prepare("CALL saldo_conta($id,$usuario,7,@_valor)");
        $sql->bindValue(":USUARIO", $usuario);
        $sql->bindValue(":CONTA", $id);
        $sql->execute();
        $sql->closeCursor();

        $saldo_semana = $this->conn->query("select @_valor")->fetchColumn();

        $sql = $this->conn->prepare("CALL saldo_conta($id,$usuario,30,@_valor)");
        $sql->bindValue(":USUARIO", $usuario);
        $sql->bindValue(":CONTA", $id);
        $sql->execute();
        $sql->closeCursor();

        $saldo_mes = $this->conn->query("select @_valor")->fetchColumn();


        /*$sql=$this->conn->prepare("SELECT
                                    saldo_conta(:CONTA,:USUARIO,0) SALDO,
                                    saldo_conta(:CONTA,:USUARIO,7) SALDO_SEMANA,
                                    saldo_conta(:CONTA,:USUARIO,30) SALDO_MES");
        $sql->bindValue(":USUARIO",$usuario);
        $sql->bindValue(":CONTA",$id);
        $sql->execute();*/

        $saldo = array("SALDO" => $saldo,
            "SALDO_SEMANA" => $saldo_semana,
            "SALDO_MES" => $saldo_mes);


        return $saldo;
    }

    function listar_contas($usuario, $incluir_desativadas)
    {
        if ($incluir_desativadas)
            $query = "SELECT CODIGO,NOME FROM contas C WHERE C.USUARIO_ID=:USUARIO ORDER BY PADRAO DESC";
        else
            $query = "SELECT CODIGO,NOME FROM contas C WHERE C.USUARIO_ID=:USUARIO AND C.STATUS=1 ORDER BY PADRAO DESC";

        $sql = $this->conn->prepare($query);
        $sql->bindValue(":USUARIO", $usuario);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function lista_contas_pag($usuario)
    {
        $sql = $this->conn->prepare("SELECT Q.*,
											   Q.ENTRADA-Q.SAIDA SALDO 
										 FROM
										  (SELECT CODIGO,
												  NOME,
												  DATE_FORMAT(DATA_CADASTRO,'%d/%m/%Y') DATA_CADASTRO,
												  STATUS,
												  PADRAO,
												  (SELECT IFNULL(SUM(L.VALOR),0) FROM lancamentos_receitas L WHERE L.CONTA_ID=C.CODIGO AND L.DATA_CREDITO <=DATE_FORMAT(NOW(),'%Y-%m-%d')) AS ENTRADA,
												  (SELECT IFNULL(SUM(L.VALOR),0) FROM lancamentos_despesas L WHERE L.CONTA_ID=C.CODIGO AND L.DATA_PAGAMENTO <=DATE_FORMAT(NOW(),'%Y-%m-%d')) AS SAIDA
												  FROM contas C
												  WHERE C.USUARIO_ID=:USUARIO
												  ORDER BY C.PADRAO DESC,C.CODIGO DESC) Q");

        $sql->bindValue(":USUARIO", $usuario);
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $rows;

    }


    function retirar_padroes($usuario)
    {
        $sql = $this->conn->prepare("UPDATE contas SET PADRAO=1
										WHERE USUARIO_ID=:USUARIO");
        $sql->bindValue(":USUARIO", $usuario);
        $sql->execute();
    }

    function inserir_conta($usuario, $values, $tipo_usuario)
    {
        $sql = $this->conn->prepare("SELECT COUNT(1) FROM contas C WHERE C.USUARIO_ID=:USUARIO");
        $sql->bindValue(":USUARIO", $usuario);
        $sql->execute();
        $total_contas = $sql->fetchColumn();

        if ($total_contas <= 2 || $tipo_usuario == 1) {
            $sql = $this->conn->prepare("INSERT INTO contas(NOME,
														PADRAO,
														STATUS,
														USUARIO_ID)
												VALUES(:NOME,
														:PADRAO,
														:STATUS,
														:USUARIO)");
            $sql->bindValue(":NOME", $values["nome"]);
            $sql->bindValue(":PADRAO", $values["padrao"]);
            $sql->bindValue(":STATUS", 1);
            $sql->bindValue(":USUARIO", $usuario);
            $sql->execute();
        } else
            throw new Exception('O plano gratuito permite que você cadastre até 2 contas.');


    }

    function selecionar_conta($usuario, $id)
    {
        $sql = $this->conn->prepare("SELECT CODIGO,
												NOME,
												PADRAO,
												STATUS
											  FROM contas C
											 WHERE C.USUARIO_ID=:USUARIO
											   AND C.CODIGO=:CODIGO");

        $sql->bindValue(":USUARIO", $usuario);
        $sql->bindValue(":CODIGO", $id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);

    }

    function alterar_conta($usuario, $values)
    {
        $sql = $this->conn->prepare("UPDATE contas
										   SET NOME=:NOME,
												PADRAO=:PADRAO
											WHERE USUARIO_ID=:USUARIO
											  AND CODIGO=:CODIGO");

        $sql->bindValue(":NOME", $values["nome"]);
        $sql->bindValue(":PADRAO", $values["padrao"]);
        $sql->bindValue(":USUARIO", $usuario);
        $sql->bindValue(":CODIGO", $values["codigo"]);
        $sql->execute();
    }

    function atualizar_status_conta($usuario, $id, $status)
    {
        $query = "";
        if ($status == 2) {
            $query = "UPDATE contas SET STATUS=:STATUS,DATA_DESATIVACAO=CURRENT_TIMESTAMP WHERE CODIGO=:CODIGO AND USUARIO_ID=:USUARIO";
        } else {
            $query = "UPDATE contas SET STATUS=:STATUS, DATA_DESATIVACAO=NULL WHERE CODIGO=:CODIGO AND USUARIO_ID=:USUARIO";
        }
        $sql = $this->conn->prepare($query);
        $sql->bindValue(":CODIGO", $id);
        $sql->bindValue(":STATUS", $status);
        $sql->bindValue(":USUARIO", $usuario);
        $sql->execute();
    }


    function agenda_lancamentos_contas($usuario, $conta)
    {

        $sql = $this->conn->prepare("SELECT LR.CODIGO,LR.NOME,DATE_FORMAT(LR.DATA_CREDITO ,'%Y-%m-%d') DATA_VENCIMENTO,DATE_FORMAT(LR.DATA_CREDITO ,'%Y-%m-%d') DATA_PAGAMENTO, LR.VALOR,1 TIPO
										  FROM lancamentos_receitas LR,contas C
										 WHERE LR.CONTA_ID=C.CODIGO AND LR.CONTA_ID=:CONTA AND C.USUARIO_ID=:USUARIO AND LR.TRANSFERENCIA IS NULL
										UNION ALL
										SELECT LD.CODIGO,LD.NOME, DATE_FORMAT(LD.DATA_VENCIMENTO,'%Y-%m-%d') DATA_VENCIMENTO,DATE_FORMAT(LD.DATA_PAGAMENTO,'%Y-%m-%d') DATA_PAGAMENTO ,LD.VALOR,2 TIPO 
										  FROM lancamentos_despesas LD,contas C
										 WHERE LD.CONTA_ID=C.CODIGO AND LD.CONTA_ID=:CONTA AND C.USUARIO_ID=:USUARIO AND LD.TRANSFERENCIA IS NULL
										ORDER BY TIPO"); 

        $sql->bindValue(":USUARIO", $usuario);
        $sql->bindValue(":CONTA", $conta);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);

    }

    function deletar_conta($usuario, $codigo)
    {
        $sql = $this->conn->prepare("DELETE FROM lancamentos_despesas
									   WHERE CONTA_ID=:CODIGO
										 AND EXISTS(SELECT 1 FROM contas C 
													 WHERE C.CODIGO=lancamentos_despesas.CONTA_ID 
													   AND C.USUARIO_ID=:USUARIO)");
        $sql->bindValue(":CODIGO", $codigo);
        $sql->bindValue(":USUARIO", $usuario);
        $sql->execute();

        $sql = $this->conn->prepare("DELETE FROM lancamentos_receitas
									   WHERE CONTA_ID=:CODIGO
										 AND EXISTS(SELECT 1 FROM contas C 
													 WHERE C.CODIGO=lancamentos_receitas.CONTA_ID 
													   AND C.USUARIO_ID=:USUARIO)");
        $sql->bindValue(":CODIGO", $codigo);
        $sql->bindValue(":USUARIO", $usuario);
        $sql->execute();

        $sql = $this->conn->prepare("DELETE FROM contas
									  	WHERE CODIGO=:CODIGO
									  	  AND USUARIO_ID=:USUARIO");
        $sql->bindValue(":CODIGO", $codigo);
        $sql->bindValue(":USUARIO", $usuario);
        $sql->execute();

    }
}

?>