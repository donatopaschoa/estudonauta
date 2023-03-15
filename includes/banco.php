<pre>
    <?php
    
        //Podemosusar o arroba para ocultar possíveis erros retornado pelo PHP "@$banco"
        // localhost: servidor, a empresa de hospedagem irá te fornecer p/ substituir
        // Idem p/ usuário, senha e bco de dados
        $banco = new mysqli("localhost", "root", "", "bd_games");
    
        /*Como o banco é um obj, ele possue atributos e métodos, logo, se gerarmos um
        erro ao conectar, segue uma boa prática p/ mostrar uma mensagem personalizada: */
    
        /* PHP V8:
        //if ($banco->connect_errno){
        if ($banco->connect_error){
            echo "<p>Encontrei um erro $banco->connect_errno -->  $banco->connect_error</p>";
            die(); // mata o processo
        }
        */
    
        // PHP V7: igual do prof: Personalização do erro de conexão com o banco de dados:
        if ($banco->connect_errno){
            echo "<p>Encontrei um erro $banco->errno -->  $banco->connect_error</p>";
            die(); // mata o processo
        }
        // Configurando acentuação e simbologia dos resultados das querys - UTF8:
        $banco->query("SET NAMES 'utf8'");
        $banco->query("SET character_set_connection=utf8");
        $banco->query("SET character_set_client=utf8");
        $banco->query("SET character_set_results=utf8");
    
        $busca = $banco->query("select * from generos");
        if(!$busca){ // Personalização de erro de execução de uma query:
            echo "<p>Falha na busca --> $banco->error</p>";
        }else{
            // Mét. "fetch_object()" transfere todos os dados de um obj p/ outro objeto
            while($reg = $busca->fetch_object()){ // Enquanto não ler todos os registros
                print_r($reg);
            }
        }
    
    ?>
</pre>