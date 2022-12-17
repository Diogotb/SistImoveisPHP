<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Cadastrar Novo(a) Cliente(a)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-
+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>

<body>
    <!--
Nome Completo
Data de Nascimento
Telefone
E-mail
Senha
-->
<?php
  require 'header.php';
  ?>
    <div class="container">
        <h1>Cadastrar Novo(a) Cliente</h1>
        <form action="processa_cliente.php" method="post">
            <div class="col-4">
                <label for="nome">Nome Completo</label>
                <input type="text" name="cliNome" id="nome" class="form-control">
            </div>
            <div class="col-4">
                <label for="dataNascimento">Data de Nascimento</label>
                <input type="date" name="cliDataNascimento" id="dataNascimento" class="form-control" value="2000-01-01">
            </div>
            <div class="col-4">
                <label for="telefone">Telefone para Contato</label>
                <input type="tel" name="cliTelefone" id="telefone" class="form-control">
            </div>
            <div class="col-4">
                <label for="cidade">Qual sua Cidade?</label>
                <input type="text" name="cliCidade" id="cidade" class="form-control">
            </div>
            <div class="col-4">
                <label for="email">E-mail</label>
                <input type="email" name="cliEmail" id="email" class="form-control">
            </div>
            <div class="col-4">
                <label for="senha">Senha</label>
                <input type="password" name="cliSenha" id="senha" class="form-control">
            </div><br>
            <button type="submit" name="enviarDados" class="btn btn-primary">Cadastrar</button>
            <a href="index.php" class="btn btn-danger">Cancelar</a>
        </form>
    </div>
</body>

</html>