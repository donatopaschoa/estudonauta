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
        <title>Histórico</title>
    </head>
    <body>
        <div id="corpo">
        <h1>Histórico:</h1>
            <?php
                $q = "select atividade from usuarios where usuario = '". $_SESSION['user'] ."'";
                
                $busca = $banco->query($q);
                $reg = $busca->fetch_object();
                echo $reg->atividade;
                
                echo "<hr>". iconeVoltar();
            ?>
        </div>
        <?php require_once "rodape.php"; ?>
    </body>
</html>