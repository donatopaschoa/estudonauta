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
                // Se um administrador c/a senha vencida tentar cadastrar diretamente:
                }elseif($_SESSION['senhaExpirada'] == true){
                    echo msg_erro("Favor alterar sua senha pois está expirada! <a href='user-edit.php'>Clique aqui</a>");
                }
                else{
                    // se vc for administrador e não foi configurado o envio do parâmetro "usuario" via post:
                    if(!isset($_POST['usuario'])){
                        // será montado o formulário:
                        require_once "user-new-form.php";
                    }else{
                        // vc é administrador e há configuração de recebimento do parâmetro
                        // "usuario", portanto, todos os parâmetros serão armazenados em variáveis 
                        $usuario = $_POST['usuario'] ?? null;
                        $nome = $_POST['nome'] ?? null;
                        $senha1 = $_POST['senha1'] ?? null;
                        $senha2 = $_POST['senha2'] ?? null;
                        $tipo = $_POST['tipo'] ?? null;

                            if(validaUsuario($usuario) === true){
                                if(validaNome($nome) === true){
                                    if($senha1 === $senha2){
                                        if(validaSenha($senha1, 4, 10) === true){
                                            //Formulário preenchido corretamente, pode salvar no banco de dados:
                                            $senha = gerarHash($senha1);
                                            $q = "insert into usuarios (usuario, nome, senha, tipo, dtStatus, dtSenha, atividade) ";
                                            $q .= "values('$usuario', '$nome', '$senha', '$tipo', now(), now(), '". historicoCadastro($_SESSION['user'], $_SESSION['nome'], $usuario, $nome, $senha, $tipo) ."') ";
                
                                            if($banco->query($q)){
                                                echo msg_sucesso("Usuário $usuario cadastrado com sucesso!");
                                            }else{
                                                //print_r($q);
                                                echo msg_erro("Não foi possível cadastrar o usuário <strong>$usuario</strong>, favor ". voltar() . " e usar <strong>outro usuário</strong>");
                                            }
                                        }else{
                                            echo msg_erro(validaSenha($senha1, 4, 10));
                                        }
                                    }else{
                                        echo msg_erro("As senhas não conferem, favor ". voltar() ." e corrigir");
                                    }
                                }else{
                                    echo msg_erro(validaNome($nome));
                                }
                            }else{
                                echo msg_erro(validaUsuario($usuario));
                            }
                        }
                    }
                
                echo iconeVoltar();
            ?>
        </div>
        <?php require_once "rodape.php"; ?>
    </body>
</html>