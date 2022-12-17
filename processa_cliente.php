<?php
require_once 'conectaBD.php';
// Definir o BD (e a tabela)
// Conectar ao BD (com o PHP)
if (!empty($_POST)) {
    // Está chegando dados por POST e então posso tentar inserir no banco
    // Obter as informações do formulário ($_POST)
    try {
        // Preparar as informações
        // Montar a SQL (pgsql)
        $sql = "INSERT INTO clientes
(nome, data_nascimento, telefone, email, senha, cidade)
VALUES
(:nome, :dataNascimento, :telefone, :email, :senha, :cidade)";
        // Preparar a SQL (pdo)
        $stmt = $pdo->prepare($sql);
        // Definir/organizar os dados p/ SQL
        $dadosCliente = array(
            ':nome' => $_POST['cliNome'],
            ':dataNascimento' => $_POST['cliDataNascimento'],
            ':telefone' => $_POST['cliTelefone'],
            ':email' => $_POST['cliEmail'],
            ':senha' => md5($_POST['cliSenha']), //md5 é um padrão de criptografia,
            ':cidade' => $_POST['cliCidade']
        );
        // Tentar Executar a SQL (INSERT)
        // Realizar a inserção das informações no BD (com o PHP)
        if ($stmt->execute($dadosCliente)) {
            header("Location: login_cliente.php?msgSucesso=Cadastro realizado com sucesso!");
        }
    } catch (PDOException $e) {
        //die($e->getMessage());
        header("Location: login_cliente.php?msgErro=Falha ao cadastrar...");
    }
} else {
    header("Location: login_cliente.php?msgErro=Erro de acesso.");
}
die();
// Redirecionar para a página inicial (login) c/ mensagem erro/sucesso
