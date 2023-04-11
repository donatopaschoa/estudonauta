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

    
    function qtdeTempo($dt, $ano_dia = "dia"){
        
        $hoje = getdate(date("U")); // objeto com atributos do dia de hoje
        $dia = substr("0$hoje[mday]", -2, 2); // retorna os 2 últimos caracteres do dia concatenado com "0"
        $mes = substr("0$hoje[mon]", -2, 2);
        $ano = "$hoje[year]";
        $dtHj = date_create("$ano-$mes-$dia");
        $data = date_create(substr($dt, 0, 10));
        
        $diff = date_diff($data, $dtHj); // a diferença c/ a data recebida c/ o dia d hj

        switch($ano_dia){
            // formataç.: %r = mantém o sinal + ou - , %y = ano, %a = dia
            case "ano":
                $qtde = $diff->format("%r%y");
                break;

            case "dia":
                $qtde = $diff->format("%r%a");
                break;

            default:
                $qtde = $diff->format("%r%a");
        }
        return $qtde;
    }

    function historicoCadastro($usuarioCadastrante, $nomeCadastrante, $usuario, $nome, $senha, $tipo){

        $dados = "<hr>Dados cadastrados dia ". date('d/m/Y') .": <br>";
        $dados .= "Usuário cadastrante: $usuarioCadastrante <br>";
        $dados .= "Nome do usuário cadastrante: $nomeCadastrante <br>";
        $dados .= "Usuário cadastrado: $usuario <br>";
        $dados .= "Nome do usuário cadastrado: $nome <br>";
        $dados .= "Senha do usuário cadastrado: $senha <br>";
        $dados .= "Tipo do usuário cadastrado: $tipo <br>";
        $dados .= "dtStatus cadastrado: ". date('Y-m-d') ."<br>";
        $dados .= "dtSenha cadastrada: ". date('Y-m-d') ."<br>";

        return $dados;
    }

    function historicoEdicao($usuario, $nome, $senha, $tipo, $dtStatus, $dtSenha, $atividade){

        $dados = "<hr>Dados cadastrados na base de $usuario: <br>";
        $dados .= "Usuário: $usuario<br>";
        $dados .= "Nome: $nome<br>";
        $dados .= "Senha: $senha <br>";
        $dados .= "Tipo: $tipo <br>";
        $dados .= "dtStatus: $dtStatus<br>";
        $dados .= "dtSenha: $dtSenha<br>";
        $dados .= "$atividade<br>";

        return $dados;
    }

    function validaCampo(){
    /*
        4) Criar validações no preenchimento dos campos de cadastro e/ou edição:
        4.1) Não permitir preenchimento de caracteres q possam causar problemas no banco de dados, ex, "aspas simples"
        4.2) Não permitir que haja mais de um caractere "espaço" consecutivo no meio de uma palavra ou que tenha "espaço" no início e final
    */
    

    }
?>