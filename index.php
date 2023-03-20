<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title> Título da Página</title>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" href="estilos/estilo.css">
</head>
<body>
	<?php
		require_once "includes/banco.php";		// conexão c/ bco de dados
		require_once "includes/funcoes.php";
	?>
	<div id="corpo">
		<h1>Escolha o seu jogo</h1>
		<table class="listagem">
			<?php
				$q = "select j.cod, j.nome, g.genero, p.produtora, j.capa ";
				$q = $q . "from jogos j join generos g on j.genero = g.cod ";
				$q = $q . "join produtoras p on j.produtora = p.cod";

				$busca = $banco->query($q); // >> banco.php
				if(!$busca){
					echo "<tr><td> Infelismente a busca deu errado!";
				}else{
					if($busca->num_rows == 0){
						echo "<tr><td>Nenhum registro encontrado";
					}else{
						while($reg = $busca->fetch_object()){
							$t = thump($reg->capa); // mét. q verf. se o arq. existe >> funcoes.php
							echo "<tr><td><img src='$t' class='mini'>";
							echo "<td><a href='detalhes.php?cod=$reg->cod'>$reg->nome</a>";
							echo " [$reg->genero] <br> $reg->produtora";
							echo "<td>Adm";
						}
					}
				}
			?>
		</table>
	</div>
	<?php $banco->close(); ?>
</body>
</html>