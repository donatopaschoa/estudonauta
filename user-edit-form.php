<?php
    $q = "select usuario, nome, senha, tipo from usuarios ";
    $q .= "where usuario = '". $_SESSION['user'] ."'";
    
    $busca = $banco->query($q);

    // testando conexão c/ o banco de dados:
    if(!$busca){
        echo msg_erro("Falha ao acessar o banco de dados!");
    }else{
        $qtde = $busca->num_rows;
        // se NÃO encontrar um registro:
        if($qtde == 0){
            echo msg_erro("Nenhum registro encontrado!");
        }
    }
    // cópiando o primeiro e único registro
    $reg = $busca->fetch_object();
?>


<h1>Alteração de Dados: </h1>
<form action="user-edit.php" method="post">
    <table>
        <tr><td>Usuário: <td><input type="text" readonly name="usuario" id="usuario" value="<?php echo $reg->usuario; ?>">
        <tr><td>Nome: <td><input type="text" size="30" maxlength="30" name="nome" id="nome" value="<?php echo $reg->nome; ?>">
        <tr><td>Tipo: <td><input type="text" readonly name="tipo" id="tipo" value="<?php echo $reg->tipo; ?>">
        <tr><td>Senha: <td><input type="password" size="10" maxlength="10" name="senha1" id="senha1">
        <tr><td>Repita a senha: <td><input type="password" size="10" maxlength="10" name="senha2" id="senha2">
        <tr><td><input type="submit" value="Salvar">
    </table>
</form>