<?php
        session_start();
        /*
        // teste: forçando esvaziamento das variáveis
        // de sessão pois elas acabam ficando (os valores persistem)
        unset($_SESSION['user']);
        unset($_SESSION['nome']);
        unset($_SESSION['tipo']);
        */

        /*
        // teste: preenchendo as variáveis de sessão:
        $_SESSION['user'] = "donato";
        $_SESSION['nome'] = "Donato Pachoa";
        */

    // Se o usuário não tiver configurado, todas as variáveis serão "limpadas":
    if ( !isset($_SESSION['user']) ) { 

        // variáveis de sessão:
        $_SESSION['user'] = "";
        $_SESSION['nome'] = "";
        $_SESSION['tipo'] = "";
    }

    // Criptografia simples: 
    function cripto($senha){
        $c = '';

        for($i=0; $i<strlen($senha); $i++ ){
            $letra = ord($senha[$i]) + 1;   // retorna o caractere numérico +1 da tab. ascii da letra
            $c .= chr($letra);               // faz o contrário
        }
        return $c;
    }

function gerarHash($senha){
    $hash = password_hash(cripto($senha), PASSWORD_DEFAULT);
    return $hash;
}

function testarHash($senha, $hash){
    $tst = password_verify(cripto($senha), $hash);
    return $tst;
}

function logout(){
    // apagando as variáveis de sessão:
    unset($_SESSION['user']);
    unset($_SESSION['nome']);
    unset($_SESSION['tipo']);
}

function is_logado(){
    // vazio = ''
    // nulo = null
    //if(empty($_SESSION['user']) || $_SESSION['user'] == null){ // aluno
    if(empty($_SESSION['user'])) {
        return false;
    } else{
        return true;
    }
}

function is_admin(){
    $t = $_SESSION['tipo'] ?? null;

    if(is_null($t)) {
        return false;
    }else{
        if($t == 'admin'){
            return true;
        }else{
            return false;
        }
    }
}

function is_editor(){
    $t = $_SESSION['tipo'] ?? null;
    
    if(is_null($t)) {
        return false;
    }else{
        if($t == 'editor'){
            return true;
        }else{
            return false;
        }
    }
}

//echo gerarHash('mudar');
//echo gerarHash('229568');
    /*
    echo gerarHash('teste');
    echo "<br>";
    echo cripto('teste');
    echo "<br>";
    echo testarHash('teste','$2y$10$3g06dvSSDd85E0f/hQOB6eS.TOOWqD.wJ7Z7dFmr2wZD.JaVHktY6') ? 'ok' : 'Não OK';
    echo "<br>";
    echo password_verify('uftuf','$2y$10$3g06dvSSDd85E0f/hQOB6eS.TOOWqD.wJ7Z7dFmr2wZD.JaVHktY6');
    */

?>