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
                // (qdo um esperto q não tiver logado e tentar acessar diretamente "user-edit.php"):
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

                        // implementando: 
                        // - verificar se a nova senha é igual a senha anterior
                        // - inserir atividades realizadas pelo usuário
                        $qs = "select usuario, nome, senha, tipo, dtStatus, dtSenha, atividade from usuarios where usuario = '$usuario'";
                        $busca = $banco->query($qs);
                        $reg = $busca->fetch_object();

                        $dados = historicoEdicao($reg->usuario, $reg->nome, $reg->senha, $reg->tipo, $reg->dtStatus, $reg->dtSenha, $reg->atividade);

                        // alterando somente o nome e a senha (usuario e tipo não permite alteração):
                        $q = "update usuarios set ";
                        $q .= "nome = '$nome' ";
                        $q .= ", dtStatus = now() ";
                        $q .= ", atividade = '$dados'";

                        // campo senha1 e senha2 não foram preenchidas:
                        if( (empty($senha1) || is_null($senha1)) && (empty($senha2) || is_null($senha2)) ){
                            if ($_SESSION['senhaExpirada'] == false){
                                echo msg_aviso("Sua senha antiga foi mantida");
                                }else{
                                echo msg_aviso("Sua senha antiga foi mantida mas está EXPIRADA, favor fazer login e alterar para uma senha DIFERENTE");
                            }
                            
                        }else{
                            // os campos das senhas foram preenchidos:
                            if($senha1 === $senha2){
                                // implementação: consulta se a senha digitada é igual a antiga e atualiza a dtSenha:
                                if(testarHash($senha1, $reg->senha)){
                                    echo msg_erro("Favor digitar outra senha pois você está repetindo a senha antiga (fazer login pela senha antiga e recadastrar novamente)");
                                }else{
                                    $q .= ", senha = '". gerarHash($senha1) . "'";
                                    $q .= ", dtSenha = now() ";

                                    // a senha foi alterada, deixou de expirar:
                                    $_SESSION['senhaExpirada'] = false;
                                }
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
                if(($_SESSION['senhaExpirada'] == false)){ // se a senha NÃo estiver expirada, o link será apresentado
                    echo iconeVoltar();
                }
            ?>
        </div>
        <?php include_once "rodape.php"; // rodapé com fechamento do banco de dados ?>
    </body>
</html>