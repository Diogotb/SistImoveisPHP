<?php
require_once 'conectaBD.php';
session_start();
$anuncios = array();
$sql = "SELECT * FROM anuncio ORDER BY id ASC";
try {
  $stmt = $pdo->prepare($sql);
  if ($stmt->execute()) {
    // Execução da SQL Ok!!
    $anuncios = $stmt->fetchAll();
  } else {
    die("Falha ao executar a SQL.. #1");
  }
} catch (PDOException $e) {
  die($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página Inicial</title>
  
</head>

<body>
  <?php
  require 'header.php';
  ?>
  <?php if (!empty($anuncios)) { ?>
    <!-- Aqui que será montada o Cards com a relação de anúncios!!-->
    <div class="container">
      <div class="row">
        <?php foreach ($anuncios as $a) { ?>
          <div class="card" style="width: 18rem;">
            <?php
            $caminho = $a['foto'];
            $img = glob($caminho . "*.{jpg,png,gif,webp,jfif}", GLOB_BRACE);
            //for($i=0;$i< count($img);$i++){
            // foreach ($img as $img){  
            echo "<img src=" . $img[0] . " />";
            //}
            ?>
            <div class="card-body">
              <h5 class="card-title"><?php echo $a['titulo']; ?></h5>
              <?php if ($a['operacao'] == 'A') {
                echo "Aluguel";
              } else {
                echo "Venda";
              } ?></td>
              <p class="card-text"><?php echo $a['descricao']; ?></p>
              <p class="card-text"><?php echo $a['tamanho'] . 'm²'; ?></p>
              <p class="card-text"><?php echo 'R$ ' . $a['valor']; ?></p>
              <a href="ver_anuncio.php?id=<?php echo $a['id']; ?>" class="btn btn-primary">Ver Anúncio</a>
            </div>
          </div>

        <?php } ?>
      </div>
    </div>
  <?php } ?>


</body>

</html>