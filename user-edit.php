<!DOCTYPE html>

<?php
        require_once "includes/banco.php";
        require_once "includes/login.php";
        require_once "includes/funcoes.php";
    ?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="estilos/estilo.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <title>Edição dos dados do Usuário</title>
    </head>
    <body>
        <div id="corpo">
            <?php
                // se não tiver logado 
                // (qdo um esperto q não tiver logado tentar acessar diretamente "user-edit.php"):
                if(!is_logado()){
                    echo msg_erro("Efetue o <a href='user-login.php'>login</a> para editar seus dados");
                }else{
                    // se vc estiver logado mas não foi configurado o envio e recebimento do parâmetro
                    // "usuario" via post, é necessário criar um formulário p/ preenchimento:
                    if(!isset($_POST['usuario'])){
                        include "user-edit-form.php";
                    }else{
                        // usuário está logado e c/ os parâmetros recebidos via POST:
                        $usuario = $_POST['usuario'] ?? null;
                        $nome = $_POST['nome'] ?? null;
                        $tipo = $_POST['tipo'] ?? null;
                        $senha1 = $_POST['senha1'] ?? null;
                        $senha2 = $_POST['senha2'] ?? null;
                        
                        /* // teste:
                        echo msg_sucesso("Dados foram recebidos: <br>Usuário: $usuario<br>Nome: $nome<br>Tipo: $tipo<br>Senha1: $senha1<br>Senha2: $senha2<br>"); */

                        // salvando somente o nome e a senha (usuario e tipo não permite alteração):
                        $q = "update usuarios set ";
                        $q .= "nome = '$nome' ";

                        // campo senha1 e senha2 não foram preenchidas:
                        if( (empty($senha1) || is_null($senha1)) && (empty($senha2) || is_null($senha2)) ){
                            echo msg_aviso("Sua senha antiga foi mantida");
                        }else{
                            // os campos das senhas foram preenchidos:
                            if($senha1 === $senha2){
                                $q .= ", senha = '". gerarHash($senha1) . "'";
                            }else{
                                // o preenchimento das senhas estão diferentes:
                                echo msg_aviso("As senhas não conferem!<br>A senha anterior será mantida");
                            }
                        }
                        $q .= " where usuario = '". $usuario ."' ";
                        //echo $q;

                        // atualizando os dados no banco:
                        if($banco->query($q)){
                            echo msg_sucesso("Usuário alterado com sucesso!");
                            // saindo do sistema:
                            logout();
                            // avisando o usuário se logar novamente:
                            echo msg_aviso("Por questão de segurança, favor fazer o <a href='user-login.php'>login</a> novamente.");
                        }else{
                            echo msg_erro("Não foi possível alterar os dados!");
                        }
                    }
                }

                echo iconeVoltar();
            ?>
        </div>
        <?php include_once "rodape.php"; // rodapé com fechamento do banco de dados ?>
    </body>
</html>