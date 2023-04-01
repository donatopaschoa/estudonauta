<h1>Alteração de Dados: </h1>
<form action="user-edit.php" method="post">
    <table>
        <tr><td>Usuário: <td><input type="text" size="10" maxlength="10" name="usuario" id="usuario">
        <tr><td>Nome: <td><input type="text" size="30" maxlength="30" name="nome" id="nome">
        <tr><td>Tipo: <td><input type="text" readonly name="tipo" id="tipo">
        <tr><td>Senha: <td><input type="password" size="10" maxlength="10" name="senha1" id="senha1">
        <tr><td>Repita a senha: <td><input type="password" size="10" maxlength="10" name="senha2" id="senha2">
        <tr><td><input type="submit" value="Salvar">
    </table>
</form>