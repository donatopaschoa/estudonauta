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
                        echo msg_sucesso("Dados foram recebidos");
                    }
                }

                echo iconeVoltar();
            ?>
        </div>
        <?php include_once "rodape.php"; // rodapé com fechamento do banco de dados ?>
    </body>
</html>