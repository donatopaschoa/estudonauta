<?php    
    echo "<header>"; // cabeçalho das páginas

    // se a variável de sessão estiver vazia:
    if( empty($_SESSION['user']) ) {
        echo "<a href='user-login.php'>Entrar</a>";
    }else{
        echo "Olá, <strong>". $_SESSION['nome'] ."</strong> (". $_SESSION['tipo'] .") | ";
        echo "<a href='user-edit.php'>Meus Dados</a> | ";

        if(is_admin() && ($_SESSION['senhaExpirada'] == false)){
            echo "<a href='user-new.php'> Novo usuário</a> | ";
            echo "Novo jogo | ";
        }

        echo "<a href='user-logout.php'>Sair</a>";
    }

    echo "</header>";
?>