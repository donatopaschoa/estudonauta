<?php

    // Se o arq. não existir, será substituído por um aviso:
    function thump($arquivo){
        $caminho = "fotos/$arquivo";
        if( is_null($arquivo) || !file_exists($caminho) ){
            return "fotos/indisponivel.png";
        }else{
            return $caminho;
        }
    }

    function iconeVoltar(){
        return "<a href='index.php'><span class='material-icons'>arrow_back</span></a>";
    }

    function msg_sucesso($m){
        $resp = "<div class='sucesso'><span class='material-icons'>check_circle</span> $m</div>";
        return $resp;
    }

    function msg_aviso($m){
        $resp = "<div class='aviso'><span class='material-icons'>info</span> $m</div>";
        return $resp;
    }

    function msg_erro($m){
        $resp = "<div class='erro'><span class='material-icons'>error</span> $m</div>";
        return $resp;
    }

?>