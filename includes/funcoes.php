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

    function voltar(){
        return "<a href='javascript:history.go(-1)'> voltar</a>";
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

    function ajustandoCampo($frase){
    /*
        4) Criar validações no preenchimento dos campos de cadastro e/ou edição:
        4.1) Não permitir preenchimento de caracteres q possam causar problemas no banco de dados, ex, "aspas simples"
        4.2) Não permitir que haja mais de um caractere "espaço" consecutivo no meio de uma palavra ou que tenha "espaço" no início e final
    */
        // Removendo "espaços" no início e final de uma variável:
        $frase = trim($frase, " ");

        // Removendo "aspas simples":
        $frase = str_replace("'", "", $frase);

        // Removendo "<", ">":
        $frase = str_replace("<", " ", $frase);
        $frase = str_replace(">", " ", $frase);


        // Substituindo os espaços consecutivos dentro de uma frase por um único espaço:
        $tamanho = strlen($frase);

        for($i=$tamanho; $i>=1; $i--){
            $espaco = "          "; // 10 caracteres espaços
            $espaco1 = substr($espaco, -$i, $i); // separa os i últimos espaços
            $frase = str_replace($espaco1, " ", $frase);
        }
        return $frase;
    }

    function validaNome($nome){
        $nome1 = $nome;
        $nome = ajustandoCampo($nome);
        $tamanho1 = strlen($nome1);
        $tamanho = strlen($nome);

        if($tamanho1 <> $tamanho){
            return "Você digitou no campo <strong>Nome</strong> com caracteres não permitidos<br>Favor ". voltar() ." e digitar entre 4 a 30 caracteres corretamenre!<br>";
        }

        if( $tamanho == 0 ){
            return "Você <strong>não preencheu</strong> o campo <strong>Nome</strong><br> Favor ". voltar() ." e digitar seu nome corretamente<br>";
        }elseif( !(4 <= $tamanho && $tamanho <=30) ){
            return "Você digitou '$nome' no campo <strong>Nome</strong><br> Favor ". voltar() ." e digitar de 4 a 30 caracteres corretamente!<br>";
        }else{
            return true;
        }
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

    function verificaCaracteresProibidos($caractere){
        $tamanho = strlen($caractere);
        $saida = true;

        for($i=0; $i<$tamanho; $i++){ // Tab. ASCII: "'" (39), "<" (60), "=" (61), ">" (62)
            if( (39 == ord($caractere[$i])) || ((60 <= ord($caractere[$i]) && ord($caractere[$i]) <= 62)) ) {
                $saida = false;
                break;
            }
        }
        return $saida;
    }

    function validaUsuario($user){
        $user1 = $user;
        $user = ajustandoCampo($user);

        $tamanho1 = strlen($user1);
        $tamanho = strlen(($user));
        $flag = true;

        if($tamanho1 <> $tamanho){
            return "Você digitou no campo <strong>Usuário</strong> com caracteres não permitidos<br> Favor ". voltar() ." e digitar entre 4 a 10 caracteres com letras e/ou números sem acentuações<br>";
        }

        if( !(4 <= $tamanho && $tamanho <= 10) ){
            return "Você digitou '$user' no campo <strong>Usuário</strong><br>Favor ". voltar()." e digitar entre 4 a 10 caracteres com letras e/ou números (acentuações não são permitidas)<br>";
        }else{
            // Fazer varredura num "loop for" caractere por caractere:
            for($i=0; $i<$tamanho; $i++){
                // Se não for número e simultaneamente tb não for letra, retorna "false":
                if( !( verificaLetra($user[$i]) || verificaNumero($user[$i]) ) ){
                    $flag = false;
                    break;
                }
            }
            if($flag == false){
                return "Você digitou '$user' no campo <strong>Usuário</strong><br>Favor ". voltar() ." e digitar letras e/ou números (acentuações não são permitidas)<br>";
            }else{
                return true;
            }
        }
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

    function validaSenha($senha, $min, $max){
        /*
        A senha deve ter um tamanho mínimo e máximo
        Sem caraceres tipo espaço ou aspas simples
        Tem que ter letras e números
        Não pode ter sequência de dígitos repetitivos ou sequenciais
        */

        $tamanho = strlen($senha);
        if( !($min <= $tamanho && $tamanho <= $max) ){
            return "<strong>Senha inadequada</strong>, favor ". voltar() . " e digitar outra <strong>entre $min e $max dígitos!</strong><br>";
        }else{
            $senha = str_replace(" ", "", $senha);
            if($tamanho <> strlen($senha)){
                return "Sua senha contém caracteres proibidos tipo 'espaço', favor ". voltar() . " e fazer outra!<br>";
            }else{
                $senha = str_replace("'", "", $senha);
                if($tamanho <> strlen($senha)){
                    return "Sua senha contém caracteres proibidos tipo 'aspas', favor ". voltar() . " e fazer outra!<br>";
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
                                return "Sua senha contém uma <strong>sequencia de valores consecutivos</strong>, favor ". voltar() ." e digitar outra que não seja uma sequencia!<br>";
                            }else{
                                return true;
                            }
                        }else{
                            return "Sua senha contém uma <strong>sequência de valores repetitivos</strong>, favor ". voltar() ." e digitar outra!<br>";
                        }
                    }else{
                        return "Sua senha contém caracteres <strong>diferente</strong> de números ou letras, favor". voltar() .", rever e digitar outra! (<strong>acentuações não são permitidas</strong>)<br>";
                    }
                }
            }
        }
    }
?>  