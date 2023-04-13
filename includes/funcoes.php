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

    function validaCampo($frase){
    /*
        4) Criar validações no preenchimento dos campos de cadastro e/ou edição:
        4.1) Não permitir preenchimento de caracteres q possam causar problemas no banco de dados, ex, "aspas simples"
        4.2) Não permitir que haja mais de um caractere "espaço" consecutivo no meio de uma palavra ou que tenha "espaço" no início e final
    */
        // Removendo "espaços" no início e final de uma variável:
        $frase = trim($frase, " ");

        // Removendo "aspas simples":
        $frase = str_replace("'", "", $frase);

        // Substituindo os espaços consecutivos dentro de uma frase por um único espaço:
        $tamanho = strlen($frase);

        for($i=$tamanho; $i>=1; $i--){
            $espaco = "          "; // 10 caracteres espaços
            $espaco1 = substr($espaco, -$i, $i); // separa os i últimos espaços
            $frase = str_replace($espaco1, " ", $frase);
        }

        return $frase;
    }

    function verificaLetra($palavra){
        $tamanho = strlen($palavra);
        $maiuscula = strtoupper($palavra);
        $letra = true;

        for($i=0; $i<$tamanho; $i++){
            if( !(65 <= ord($maiuscula[$i]) && ord($maiuscula[$i]) <= 90)){
                $letra = false;
                break;
            }
        }
        return $letra;
    }

    function verificaNumero($numero){
        $tamanho = strlen($numero);
        $saida = true;

        for($i=0; $i<$tamanho; $i++){
            if( !(48 <= ord($numero[$i]) && ord($numero[$i]) <= 57)){
                $saida = false;
                break;
            }
        }
        return $saida;
    }

    function validaSequenciaRepetitiva($sequencia){
        // Se tiver um segmento repetitivo, retorna "true"
        $tamanho = strlen($sequencia);
        $flag = false;
        
        for($i=0; $i<$tamanho; $i++){
            if($i+1 < $tamanho){
                if( ord($sequencia[$i+1]) == ord($sequencia[$i]) ){
                    $flag = true;
                    break;
                }
            }
        }
        return $flag;
    }

    function validaSequenciaCrescenteDecrescente($sequencia){
        $tamanho = strlen($sequencia);
        $flag = false;

        // Se o tamanho da seqência for inferior a 3, retorne false pois
        // é necessário pelo menos 3 elementos p/ comparar entre si
        if($tamanho < 3){
            return false;
        }else{
            // Se tiver sequenciamento crescente ou decrescente de um segmento de valores numéricos da tab ASCII, é uma sequencia:
            for($i=0; $i<$tamanho; $i++){
                if($i+2 < $tamanho){
                    if( (ord($sequencia[$i+2]) - ord($sequencia[$i+1])) == (ord($sequencia[$i+1] ) - ord($sequencia[$i])) ){
                        $flag = true;
                    }
                }
            }
            return $flag;
        }
    }

    function ValidaSenha($senha, $min, $max){
        /*
        A senha deve ter um tamanho mínimo e máximo
        Sem caraceres tipo espaço ou aspas simples
        Tem que ter letras e números
        Não pode ter sequência de dígitos repetitivos ou sequenciais
        */

        $tamanho = strlen($senha);
        if( !($min <= $tamanho && $tamanho <= $max) ){
            return "Tamanho da senha inadequado, favor digitar outra!";
        }else{
            $senha = str_replace(" ", "", $senha);
            if($tamanho <> strlen($senha)){
                return "Sua senha contém caracteres proibidos tipo 'espaço', favor fazer outra!";
            }else{
                $senha = str_replace("'", "", $senha);
                if($tamanho <> strlen($senha)){
                    return "Sua senha contém caracteres proibidos tipo 'aspas', favor fazer outra!";
                }else{
                    
                    $flag = true;

                    // Fazer varredura num "loop for" caractere por caractere:
                    for($i=0; $i<$tamanho; $i++){
                        // Se não for número e simultaneamente tb não for letra, retorna "false":
                        if( !( verificaLetra($senha[$i]) || verificaNumero($senha[$i]) ) ){
                            $flag = false;
                            break;
                        }
                    }
                    // A sequencia tem letras e números:
                    if($flag == true){
                        // Se não tiver sequencia repetitiva:
                        if(!validaSequenciaRepetitiva($senha)){
                            // Para valores q haja pelo menos uma sequencia de 3 elementos:
                            if( validaSequenciaCrescenteDecrescente($senha) ){
                                return "Sua senha contém uma sequencia de valores, favor digitar outra que não seja uma sequencia!";
                            }else{
                                return "Senha OK";
                            }
                        }else{
                            return "Sua senha contém uma sequência repetitiva, favor fazer outra!";
                        }
                    }else{
                        return "Sua senha contém caracteres diferente de números ou letras, favor rever e digitar outra!";
                    }
                }
            }
        }
    }
?>  