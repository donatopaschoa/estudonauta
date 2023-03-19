<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title> Título da Página</title>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" href="estilos/estilo.css">
</head>
<body>
    <?php
        require_once "includes/banco.php";
        require_once "includes/funcoes.php";
    ?>
	<div id="corpo">
        <?php
            $c = $_GET['cod'] ?? 0; // Somente após V7, se OK >> "$c = $_GET['cod']", senão, "$c = 0"
        ?>
		<h1>Detalhes do jogo</h1>
        <table class='detalhes'>
            <tr><td rowspan='3'>Foto
                <td>Nome do jogo
                <tr><td>Descrição
                <tr><td>Adm
        </table>
	</div>
</body>
</html>