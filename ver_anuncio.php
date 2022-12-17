<?php
require_once 'conectaBD.php';
$result = array();
// Buscar as informações do anúncio a ser alterado (no banco de dados)
$sql = "SELECT * FROM anuncio WHERE id = :id";
try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':id' => $_REQUEST['id']));
  // Registro obtido no banco de dados
  $result = $stmt->fetchAll();
  $result = $result[0];
} catch (PDOException $e) {
  header("Location: index.php?msgErro=Falha ao 
    obter registro no banco de dados.");
  die($e->getMessage());
}
// var_dump($result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Anúncio Listado</title>
  <!-- CSS only -->
</head>

<body>
  <?php
  require 'header.php';
  ?>
  <div class="container">
    <h1>
      <?php echo $result['titulo']; ?>
    </h1>
    <!-- //Carrousel de Imagens -->
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <?php
        $caminho = $result['foto'];
        $img = glob($caminho . "*.{jpg,png,gif,webp,jfif}", GLOB_BRACE);
        for ($i = 0; $i < count($img); $i++) {
          if ($i == 0) {
            $active = "active";
          } else {
            $active = "";
          }
          echo '<div class="carousel-item ' . $active . '">';
          echo '<img style="height: 400px; width: 700px;" src="' . $img[$i] . '" ">';
          echo '</div>';
        }
        ?>

      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>


</html>