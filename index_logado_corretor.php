<?php
require_once 'conectaBD.php';
session_start();
if (empty($_SESSION)) {
    // Significa que as variáveis de SESSAO não foram definidas.
    // Não pode acessar aqui. o sistema manda voltar para a pagina de login
    header("Location: login_corretor.php?msgErro=Você precisa se autenticar no sistema.");
    die();
}
$anuncios = array();
if (!empty($_GET['meus_anuncios']) && $_GET['meus_anuncios'] == 1) {
    // Obter somente os anúncios cadastrados pelo(a) usuário(a) logado(a).
    $sql = "SELECT * FROM anuncio WHERE email_corretor = :email ORDER BY id ASC";
    $dados = array(':email_corretor' => $_SESSION['email']);
    try {
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute($dados)) {
            // Execução da SQL Ok!!
            $anuncios = $stmt->fetchAll();
        } else {
            die("Falha ao executar a SQL.. #1");
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
} else {
    $sql = "SELECT * FROM anuncio ORDER BY id ASC";
    try {
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            // Execução da SQL Ok!!
            $anuncios = $stmt->fetchAll();
        } else {
            die("Falha ao executar a SQL.. #2");
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Página Inicial - Ambiente Logado Corretor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-
+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>

<body>
<?php
  require 'header.php';
  ?>
    <div class="container">
        <?php if (!empty($_GET['msgErro'])) { ?>
            <div class="alert alert-warning" role="alert">
                <?php echo $_GET['msgErro']; ?>
            </div>
        <?php } ?>
        <?php if (!empty($_GET['msgSucesso'])) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_GET['msgSucesso']; ?>
            </div>
        <?php } ?>
    </div>
    <div class="container">
        <div class="col-md-11">
            <h2 class="title">Olá <i><?php echo $_SESSION['nome']; ?></i>, seja bem-vindo(a)!</h2>
        </div>
    </div>
    <div class="container">
        <a href="cad_anuncio.php" class="btn btn-primary">Novo Anúncio</a>
        <a href="index_logado_corretor.php?meus_anuncios=1" class="btn btn-success">Meus Anúncios</a>
        <a href="index_logado_corretor.php?meus_anuncios=0" class="btn btn-info">Todos Anúncios</a>
        <a href="logout_corretor.php" class="btn btn-dark">Sair</a>
    </div>

    <?php if (!empty($anuncios)) { ?>
        <!-- Aqui que será montada a tabela com a relação de anúncios!!-->
        <div class="container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Título</th>
                        <th scope="col">Operação</th>
                        <th scope="col">Imóvel</th>
                        <th scope="col">Cidade</th>
                        <th scope="col">Tamanho</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($anuncios as $a) { ?>
                        <tr>
                            <th scope="row"><?php echo $a['id']; ?></th>
                            <td><?php echo $a['titulo']; ?></td>
                            <td><?php if ($a['operacao'] == 'A') {
                                    echo "Aluguel";
                                } else {
                                    echo "Venda";
                                } ?></td>
                            <td><?php if ($a['imovel'] == 'A') {
                                    echo "Apartamento";
                                } elseif ($a['imovel'] == 'C') {
                                    echo "Casa";
                                } else {
                                    echo 'Rural';
                                } ?></td>
                            <td><?php echo $a['cidade']; ?></td>
                            <td><?php echo $a['tamanho']; ?></td>
                            <td><?php echo $a['descricao']; ?></td>
                            <td><?php echo $a['valor']; ?></td>
                            <td><?php
                                $caminho = $a['foto'];
                                $img = glob($caminho . "*.{jpg,png,gif,webp,jfif}", GLOB_BRACE);
                                echo "<img src=".$img[0]." width="."200"."/>";
                                ?></td>
                            <td>
                                <?php if ($a['email_corretor'] == $_SESSION['email']) { ?>
                                    <a href="alt_anuncio.php?id_anuncio=<?php echo $a['id']; ?>" class="btn btn-warning">Alterar</a>
                                    <a href="del_anuncio.php?id_anuncio=<?php echo $a['id']; ?>" class="btn btn-danger">Excluir</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>

</body>

</html>