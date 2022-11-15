<?php 

Class Pessoa {

    private $pdo;

    //CONEXAO COM BANCO DE DADOS
    public function __construct($dbname, $host, $user, $senha){
        try {
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
        } catch (PDOException $e) {
            echo "Erro com banco de dados: ".$e->getMessage();
            exit();
        } catch (PDOException $e) {
            echo "Erro generico: ".$e->getMessage();
            exit();
        }
    }

    //FUNCAO BUSCAR DADOS E COLOCAR NO CANTO DIREITO
    public function buscarDados(){
        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM tb_pessoa ORDER BY ds_nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function cadastrarPessoa($nome, $sexo, $dataNasc, $telefone, $email) {

        //VERICAR SE JA EXISTIR
        $cmd = $this->pdo->prepare("SELECT id_pessoa FROM tb_pessoa WHERE ds_email = :e");
        $cmd->bindValue(":e", $email);
        $cmd->execute();

        if($cmd->rowCount() > 0) {
            return false;
        } else {
            $cmd = $this->pdo->prepare("INSERT INTO agenda . tb_pessoa (ds_nome, cd_sexo, dt_nasc, nr_telefone, ds_email)
                    VALUES (:nome, :sexo, :dtnasc, :telefone, :email);");
            $cmd->bindValue(":nome", $nome);
            $cmd->bindValue(":sexo", $sexo);
            $cmd->bindValue(":dtnasc", $dataNasc);
            $cmd->bindValue(":telefone", $telefone);
            $cmd->bindValue(":email", $email);
            $cmd->execute();
            return false;
        }
    }

    public function excluirPessoa($id) {
        $cmd = $this->pdo->prepare("DELETE FROM tb_pessoa WHERE tb_pessoa . id_pessoa = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    public function buscarDadosPessoa($id) {
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM tb_pessoa WHERE id_pessoa =:id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

}

?>