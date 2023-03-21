<?php
    //estudar pois o arq CSS não está atualizando o conteúdo, necessitando fechar e abrir o browser:
    //(verif. se poderá impactar nas variáveis de seção por ex.)
    //header("Cache-Control: no-cache"); 
    
    header("Cache-Control: no-cache"); // Ok, funcionou, não necessitou fechar e abrir o browser
    echo "<header>"; // cabeçalho das páginas
    echo "Entrar";
    echo "<header>";
?>