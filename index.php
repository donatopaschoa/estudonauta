<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Listagem de jogos</title>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" href="estilos/estilo.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
	<?php
		require_once "includes/banco.php";		// conexão c/ bco de dados
		require_once "includes/funcoes.php";
		$ordem = $_GET['o'] ?? 'n'; // n = ordenação por nome
		$chave = $_GET["c"] ?? ""; // c = campo de "Busca" da caixa de texto
	?>
	<div id="corpo">
		<?php include_once "topo.php"; // link "Entrar" p/ adm ou editores ?>
		<h1>Escolha o seu jogo</h1>

		<?php 
			echo msg_sucesso('Arquivo aberto com sucesso'); 
			echo msg_aviso('Você esqueceu de colocar o nome');
			echo msg_erro('Falha no cadastro do jogo');
		?>



		<form action="index.php" id="busca" method="get">

			Ordenar: 
			<a href="index.php?o=n&c=<?php echo $chave;?>">Nome</a> | 
			<a href="index.php?o=p&c=<?php echo $chave;?>">Produtora</a> | 
			<a href="index.php?o=n1&c=<?php echo $chave;?>">Nota alta</a> | 
			<a href="index.php?o=n2&c=<?php echo $chave;?>">Nota baixa</a> | 
			<a href="index.php?o=g&c=<?php echo $chave;?>">Gênero</a> |
			<a href="index.php">Mostrar Todos</a> |

			Buscar: <input type="text" name="c" size="10" maxlength="40"/> <input type="submit" value="OK"/>
		</form>

		<table class="listagem">
			<?php
				$q = "select j.cod, j.nota, j.nome, g.genero, p.produtora, j.capa ";
				$q .= "from jogos j join generos g on j.genero = g.cod ";
				$q .= "join produtoras p on j.produtora = p.cod ";

				if( !empty($chave) ) { // se a campo NÃO estiver vazio:
					$q .= " where j.nome like '%$chave%' ";
					$q .= " or j.nota like '%$chave%' ";
					$q .= " or g.genero like '%$chave%' ";
					$q .= " or p.produtora like '%$chave%' ";
				}

				switch($ordem){
					
					case "p":
						$q .= " order by p.produtora";
						break;

					case "n1":
						$q .= " order by j.nota desc";
						break;

					case "n2":
						$q .= " order by j.nota asc";
						break;

					case "g":
						$q .= " order by g.genero";
						break;

					default:
						$q .= " order by j.nome"; // outras opções, será ordenado por nome 
				}

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
							echo " [$reg->genero] <br> $reg->produtora - nota " . number_format($reg->nota, 1); 
							echo "<td>Adm";
						}
					}
				}
			?>
		</table>
	</div>
	<?php include_once "rodape.php"; // rodapé com fechamento do banco de dados ?>
</body>
</html>