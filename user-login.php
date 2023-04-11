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
        <title>Login de Usuário</title>
        <style>
            div#corpo{
                width: 270px;
                font-size: 13px;
            }

            td{  /* está dentro da pág. "user-login-form.php" */
                padding: 6px;
            }
        </style>
    </head>
    <body>
        <div id="corpo">
            <?php

                $u = $_POST['usuario'] ?? null;
                $s = $_POST['senha'] ?? null;

                // se o usuário não estiver logado, será montado o formulário:
                if(is_null($u) || is_null($s)) {
                    require "user-login-form.php";
                // consultando:
                }else{
                    $q = "select usuario, nome, senha, dtSenha, tipo from usuarios ";
                    $q .= " where usuario = '$u' LIMIT 1";
                    $busca = $banco->query($q);
                    if(!$busca){ // erro de conexão c/ bco d dados: 
                        echo msg_erro('Falha ao acessar o banco de dados');
                    }else{ 
                        // se encontrar algum registro:
                        if($busca->num_rows > 0){                        
                            // transferindo os dados de um obj p/ outro
                            $reg = $busca->fetch_object();
                            // Se a senha conferir, será analisada se expirou:
                            if(testarHash($s, $reg->senha)){
                                if(qtdeTempo($reg->dtSenha, "ano") >= 1){ // teste de senha expirada
                                    echo msg_aviso("Sua senha expirou, <a href='user-edit.php'>clique aqui</a> para alterar");
                                    $_SESSION['senhaExpirada'] = true;
                                }else{
                                    $_SESSION['senhaExpirada'] = false;
                                }
                                echo msg_sucesso("Logado com sucesso");
                                // Populando as variáveis de sessão:
                                $_SESSION['user'] = $reg->usuario;
                                $_SESSION['nome'] = $reg->nome;
                                $_SESSION['tipo'] = $reg->tipo;
                            }else{ // senha não confere:
                                echo msg_erro("Senha inválida");
                            }
                        // se não tiver registro:
                        }else{
                            echo msg_erro("Usuário não existe");
                        }
                    }
                }
                    echo iconeVoltar();
            ?>
        </div>
        <?php require_once "rodape.php"; ?>
    </body>
</html>