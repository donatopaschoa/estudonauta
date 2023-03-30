<?php
    echo "<div style='text-align: center; font-size:10pt'>";
	echo "<p>Acessado por ". $_SERVER['REMOTE_ADDR'] . " em ". date('d/M/Y');
	echo "<br>Desenvolvido por Estudonauta &copy; 2018</p>";
	echo "</div>";
   // $banco->close(); // Fechando a conexão do bco de dados
?>