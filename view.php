<?php
    require_once 'classePessoa.php';
    $p = new Pessoa("agenda","localhost","root","");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contados</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h1>Contados</h1>
        <hr>

        <?php 
        if(isset($_POST['nome'])) {
        $nome = addslashes($_POST['nome']);
        $sexo = addslashes($_POST['user']);
        $dataNasc = addslashes($_POST['daNasc']);
        $telefone = addslashes($_POST['telefone']);
        $email = addslashes($_POST['email']);

        if (!empty($nome) && !empty($telefone) && !empty($email)  && !empty($sexo)  && !empty($dataNasc)) {
            //cadastrar
            if (!$p->cadastrarPessoa($nome, $sexo, $dataNasc, $telefone, $email)) {
                echo "Email cadastrado!";
            }
        } else {
            echo "Preencha todos os campos!";
        }
        }
    
        ?>  

        <?php 
        
            if(isset($_GET['id_up'])) {
                $id_update = addslashes($_GET['id_up']);
                $res = $p->buscarDadosPessoa($id_update);
            }

        ?>

        <div id="tudo">
      
            <form action="" id="cadastrar" method="POST">
                <h5>Nome</h5>
                <input type="text" name="nome" value="<?php if(isset($res)){echo $res['ds_nome'];} ?>"
                placeholder="Nome" required>
                  
                <h5>Sexo</h5>
                <div id="opcao"> 
                    <div class="gen-input"> 
                        <input type="radio" name="user" value="M" <?php if(isset($res)){ echo $res["cd_sexo"]=="M"?"checked":"";} ?>/>
                        <label for="masc">Masculino</label>
                    </div>
                    <div class="gen-input">
                        <input type="radio" name="user" value="F" <?php if(isset($res)){ echo $res["cd_sexo"]=="F"?"checked":"";} ?>/>
                        <label for="fem">Feminino</label>
                    </div>
                    <div class="gen-input">
                        <input type="radio" name="user" value="N" <?php if(isset($res)){ echo $res["cd_sexo"]=="N"?"checked":"";} ?>/>
                        <label for="pref">Prefiro não informar</label> 
                    </div>
                </div>                                 

                <h5>Data de nascimento</h5>
                <input type="date" name="daNasc" value="<?php if(isset($res)){echo $res['dt_nasc'];} ?>"
                placeholder="Data de Nascimento" required>
                    
                <h5>Telefone</h5>
                <input type="text" name="telefone" value="<?php if(isset($res)){echo $res['nr_telefone'];} ?>"
                placeholder="Telefone" required>
                    
                <h5>Email</h5>
                <input type="email" name="email" value="<?php if(isset($res)){echo $res['ds_email'];} ?>"
                placeholder="Email" required>
                    
                <button type="submit" value="<?php if(isset($res)){echo "Atualizar";} 
                        else{echo "Cadastrar";} ?>">
                Salvar</button>
            
            </form>

            <table id="tabela">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Sexo</th>
                        <th>Nascimento</th>
                        <th>Telefone</th>
                        <th colspan="2">Email</th>
                    </tr>
                </thead>
                <tbody>
            <?php
                $dados = $p->buscarDados();
                if(count($dados) > 0) {
                    for ($i=0; $i < count($dados); $i++) { 
                        echo "<tr>";
                        foreach ($dados[$i] as $k => $v) {
                            if ($k != "id_pessoa") {
                                echo "<td>".$v."</td>";
                            }
                        }
            ?>
                    <td>
                        <a href="view.php?id_up=<?php echo $dados[$i]['id_pessoa']?>">Editar</a>
                        <a href="view.php?id=<?php echo $dados[$i]['id_pessoa'];?>">Excluir</a>
                    </td>
            <?php
                        echo "</tr>";
                    }
                } else {
                    echo "Ainda não há pessoas cadastradas!";
                }
            ?>         
                    </tr>
                </tbody>
            </table>
 

        </div>
        
    </div>
</body>
</html>

<?php 

    if(isset($_GET['id'])) {
        $id_pessoa = addslashes($_GET['id']);
        $p->excluirPessoa($id_pessoa);
        header("location: view.php");
    }

?>