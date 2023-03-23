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
?>