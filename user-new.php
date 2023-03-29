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
        <title>Cadastrar novo usuário</title>
    </head>
    <body>
        <div id="corpo">
            <?php
                // se você não tiver logado como administrador:
                if(!is_admin()){
                    echo msg_erro("Área restrita! Você não é administrdor");
                }else{
                    // se vc for administrador e não foi configurado o envio do parâmetro "usuario" via post:
                    if(!isset($_POST['usuario'])){
                        // será montado o formulário:
                        require_once "user-new-form.php";
                    }else{
                        // vc é admin. e há conf. de recebimento de parâmetro usuário, portanto, estes
                        // parâmetros serão armazenados em variáveis 
                        $usuario = $_POST['usuario'] ?? null;
                        $nome = $_POST['nome'] ?? null;
                        $senha1 = $_POST['senha1'] ?? null;
                        $senha2 = $_POST['senha2'] ?? null;
                        $tipo = $_POST['tipo'] ?? null;

                        if($senha1 === $senha2){
                            echo msg_sucesso("Tudo certo para gravar");
                        }else{
                            echo msg_erro("Senhas não conferem. Repita o processo");
                        }
                    }
                }
                echo iconeVoltar();
            ?>
        </div>
    </body>
</html>