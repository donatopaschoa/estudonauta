<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Detalhes do Jogo</title>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" href="estilos/estilo.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <?php
        require_once "includes/banco.php";
        require_once "includes/login.php";
        require_once "includes/funcoes.php";
    ?>
	<div id="corpo">
        <?php
            include_once "topo.php"; // link "Entrar" p/ adm ou editores

            $c = $_GET['cod'] ?? 0; // Somente após V7, se OK >> "$c = $_GET['cod']", senão, "$c = 0"
            $busca = $banco->query("select * from jogos where cod = $c");
        ?>
		<h1>Detalhes do jogo</h1>
        <table class='detalhes'>
            <?php
                if(!$busca){
                    echo "<tr><td>Busca falhou, favor retornar";
                }else{
                    if($busca->num_rows == 1){
                        $reg = $busca->fetch_object();
                        $t = thump($reg->capa); // Verif. e retorna o caminho completo do arq. "funcoes.php"
                        echo "<tr><td rowspan='3'><img src='$t' class='full'>";
                        echo "<td><h2>$reg->nome</h2>";
                        echo "Nota: ". number_format($reg->nota, 1) ."/10 ";

                        if(is_admin()){
                            // ìcone "+":
                            echo "<span class='material-icons'>check_circle</span>";
                            // ícone "editar" (caneta):
                            echo "<span class='material-icons'>edit</span>";
                            // ícone "excluir" (lixeira):
                            echo "<span class='material-icons'>delete</span>";

                        }elseif(is_editor()){
                            // ícone "editar" (caneta):
                            echo "<span class='material-icons'>edit</span>";
                        }

                        echo "<tr><td>$reg->descricao";
                        echo "<tr><td>Adm";
                    }else{
                        echo "<tr><td>Nenhum registro encontrado";
                    }
                }
            ?>
        </table>
        <?php echo iconeVoltar();  // ícone do Google  ?>
	</div>
    <?php include_once "rodape.php"; // rodapé com fechamento do banco de dados ?>
</body>
</html>