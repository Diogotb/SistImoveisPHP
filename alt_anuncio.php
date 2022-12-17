<?php
require_once 'conectaBD.php';

session_start();

if (empty($_SESSION)) {
  // Significa que as variáveis de SESSAO não foram definidas.
  // Não poderia acessar aqui.
  header("Location: index.php?msgErro=Você precisa se autenticar no sistema.");
  die();
}

$result = array();

// Verificar se está chegando a informação (id_anuncio) pelo $_GET
if (!empty($_GET['id_anuncio'])) {

    // Buscar as informações do anúncio a ser alterado (no banco de dados)
  $sql = "SELECT * FROM anuncio WHERE email_usuario = :email AND id = :id";
  try {
    $stmt = $pdo->prepare($sql);

    $stmt->execute(array(':email' => $_SESSION['email'], ':id' => $_GET['id_anuncio']));

    // Verificar se o usuário logado pode acessar/alterar as informações desse registro (id_anuncio)
    if ($stmt->rowCount() == 1) {
      // Registro obtido no banco de dados
      $result = $stmt->fetchAll();
      $result = $result[0]; // Informações do registro a ser alterado

    }
    else {
      //die("Não foi encontrado nenhum registro para id_anuncio = " . $_GET['id_anuncio'] . " e e-mail = " . $_SESSION['email']);
      header("Location: index_logado.php?msgErro=Você não tem permissão para acessar esta página");
      die();
    }

  } catch (PDOException $e) {
    header("Location: index_logado.php?msgErro=Falha ao obter registro no banco de dados.");
    //die($e->getMessage());

  }
}
else {
  // Se entrar aqui, significa que $_GET['id_anuncio'] está vazio
  header("Location: index_logado.php?msgErro=Você não tem permissão para acessar esta página");
  die();
}

  // Redirecionar (permissão)

?>
<html lang="pt-br”>
<head>
<meta charset=" utf-8">
<title>Cadastrar Novo Anúncio de Imóvel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-
+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>

<body>
<?php
  require 'header.php';
  ?>
    <!--
Título - type name
Tipo de Imóvel - Casa, Apartamento, Chácara
Tipo de Operação: Venda , Aluguel
Tamanho: m²
Descrição: 
Valor: R$
Foto: type file

-->
    <div class="container">
        <h1>Cadastrar Novo Anúncio de Imóvel</h1>
        <form action="processa_anuncio.php" method="post" enctype="multipart/form-data">
            <div class="col-4">
                <label for="titulo">Título</label>
                <input type="text" class=" form-control" name="titulo" id="titulo" value="<?php echo $result['titulo']; ?>">
            </div>
            <div class="col-4">
                <label for="tipoOP">Tipo de Operação</label>
                <select class="form-select" name="tipoOp" id="tipoOp">
                    <option selected>Selecione o tipo de Operação</option>
                    <option value="A">Aluguel</option>
                    <option value="V">Venda</option>
                </select>
            </div>
            <div class="col-4">
                <label for="tipoIm">Tipo de Imóvel</label>
                <select class="form-select" name="tipoIm" id="tipoIm">
                    <option selected>Selecione o tipo de Imóvel</option>
                    <option value="A">Apartamento</option>
                    <option value="C">Casa</option>
                    <option value="R">Rural</option>
                </select>
            </div>
            <div class="col-4">
                <label for="tamanho">Metragem do Imóvel</label>
                <input type="text" name="tamanho" id="tamanho" class="form-control">
            </div>
            <div class="col-4">
                <label for="cidade">local/Cidade</label>
                <input type="text" name="cidade" id="cidade" class="form-control">
            </div>
            <div class="col-4">
                <label for="valor">Valor do Imóvel</label>
                <input type="text" name="valor" id="valor" class="form-control">
            </div>
            <div class="col-4">
                <label for="descricao">Descrição</label>
                <textarea name="descricao" class="form-control" id="descricao" rows="3"></textarea>
            </div>
            <div class="col-4">
                <label for="foto">Enviar Foto do Imóvel</label>
                <input type="file" class="form-control" name="foto1" required="true">
                <input type="file" class="form-control" name="foto2" required="true">
                <span style="color:red; font-size:12px;">Apenas jpg / jpeg/ png /gif formatos permitidos.</span>
            </div>
            <br />
            <button type="submit" name="enviarDados" class="btn btn-primary" value="CAD">Cadastrar</button>
            <a href="index_logado_corretor.php" class="btn btn-danger">Cancelar</a>
        </form>
    </div>
</body>

</html>