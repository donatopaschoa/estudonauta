<?php
    //estudar pois o arq CSS não está atualizando o conteúdo, necessitando fechar e abrir o browser:
    //(verif. se poderá impactar nas variáveis de seção por ex.)
    //header("Cache-Control: no-cache"); 
    
    echo "<header>"; // cabeçalho das páginas

    // se a variável de sessão estiver vazia:
    if( empty($_SESSION['user']) ) {
        echo "<a href='user-login.php'>Entrar</a>";
    }else{
        echo "Olá, <strong>". $_SESSION['nome'] ."</strong> | ";
        echo "<a href='user-logout.php' >Sair</a>";
    }

    echo "</header>";
?>