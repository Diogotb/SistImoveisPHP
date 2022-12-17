<?php
require_once 'conectaBD.php';
// Definir o BD (e a tabela)
// Conectar ao BD (com o PHP)
session_start();
if (empty($_SESSION)) {
    // Significa que as variáveis de SESSAO não foram definidas.
    // Não poderia acessar aqui.
    header("Location: index.php?msgErro=Você precisa se autenticar no sistema.");
    die();
}
if (!empty($_POST)) {
    // Está chegando dados por POST e então posso tentar inserir no banco
    // Obter as informações do formulário ($_POST)
    // Verificar se estou tentando INSERIR (CAD) /
    if ($_POST['enviarDados'] == 'CAD') { // CADASTRAR!!!
        try {
            // Preparar as informações
            // Montar a SQL (pgsql)
            $sql = "INSERT INTO anuncio
    (titulo, operacao, imovel, tamanho, descricao, valor,
     cidade, foto, email_corretor)
    VALUES
    (:titulo, :operacao, :imovel, :tamanho, :descricao, :valor,
     :cidade, :foto, :email_corretor)";
            // Preparar a SQL (pdo)
            $stmt = $pdo->prepare($sql);
            // Definir/organizar os dados p/ SQL
            $nome_arquivo1 = $_FILES['foto1']['name'];//pega o nome do arquivo
            $nome_arquivo2 = $_FILES['foto2']['name'];
            //$extensao = strtolower(substr($_FILES['foto']['name'], -4)); //pega a extensao do arquivo
            $extensao1 = strtolower(pathinfo($nome_arquivo1,PATHINFO_EXTENSION));//pega a extensao do arquivo outra forma melhor
            $extensao2 = strtolower(pathinfo($nome_arquivo2,PATHINFO_EXTENSION));
            //$novo_nome = md5($nome_arquivo.time()) . ".". $extensao; //define o nome do arquivo
            $diretorio = "foto/".md5(time())."/"; //define o diretorio para onde enviaremos o arquivo
            mkdir($diretorio, 0777, true);
            move_uploaded_file($_FILES['foto1']['tmp_name'], $diretorio."1.".$extensao1); //efetua o upload
            move_uploaded_file($_FILES['foto2']['tmp_name'], $diretorio."2.".$extensao2);
            //tmp_name
            $dados = array(
                ':titulo' => $_POST['titulo'],
                ':operacao' => $_POST['tipoOp'],
                ':imovel' => $_POST['tipoIm'],
                ':tamanho' => $_POST['tamanho'],
                ':valor' => $_POST['valor'],
                ':descricao' => $_POST['descricao'],
                ':cidade' => $_POST['cidade'],
                ':foto' => $diretorio,
                ':email_corretor' => $_SESSION['email']
            );
            
            // Realizar a inserção das informações no BD (com o PHP)   
            if ($stmt->execute($dados)) {
                header("Location: index_logado_corretor.php?msgSucesso=Anúncio cadastrado com sucesso!");
            }
        } catch (PDOException $e) {
            die($e->getMessage());
            header("Location: index_logado_corretor.php?msgErro=Falha ao cadastrar anúncio..");
        }
    }
    elseif ($_POST['enviarDados'] == 'ALT') { // ALTERAR!!!
        /* Implementação do update aqui.. */
        // Construir SQL para update
        try {
          $sql = "UPDATE
                    anuncio
                  SET
                    fase = :fase,
                    tipo = :tipo,
                    porte = :porte,
                    pelagem_cor = :pelagem_cor,
                    raca = :raca,
                    sexo = :sexo,
                    observacao = :observacao
                  WHERE
                    id = :id_anuncio AND
                    email_usuario = :email";
    
          // Definir dados para SQL
          $dados = array(
            ':id_anuncio' => $_POST['id_anuncio'],
            ':fase' => $_POST['fase'],
            ':tipo' => $_POST['tipo'],
            ':porte' => $_POST['porte'],
            ':pelagem_cor' => $_POST['pelagemCor'],
            ':raca' => $_POST['raca'],
            ':sexo' => $_POST['sexo'],
            ':observacao' => $_POST['observacao'],
            ':email' => $_SESSION['email']
          );
    
          $stmt = $pdo->prepare($sql);
    
          // Executar SQL
          if ($stmt->execute($dados)) {
            header("Location: index_logado.php?msgSucesso=Alteração realizada com sucesso!!");
          }
          else {
            header("Location: index_logado.php?msgErro=Falha ao ALTERAR anúncio..");
          }
        } catch (PDOException $e) {
          //die($e->getMessage());
          header("Location: index_logado.php?msgErro=Falha ao ALTERAR anúncio..");
        }
    
      }
      elseif ($_POST['enviarDados'] == 'DEL') { // EXCLUIR!!!
        /** Implementação do excluir aqui.. */
        // id_anuncio ok
        // e-mail usuário logado ok
        try {
          $sql = "DELETE FROM anuncio WHERE id = :id_anuncio AND email_usuario = :email";
          $stmt = $pdo->prepare($sql);
    
          $dados = array(':id_anuncio' => $_POST['id_anuncio'], ':email' => $_SESSION['email']);
    
          if ($stmt->execute($dados)) {
            header("Location: index_logado.php?msgSucesso=Anúncio excluído com sucesso!!");
          }
          else {
            header("Location: index_logado.php?msgSucesso=Falha ao EXCLUIR anúncio..");
          }
        } catch (PDOException $e) {
          //die($e->getMessage());
          header("Location: index_logado.php?msgSucesso=Falha ao EXCLUIR anúncio..");
        }
      }
    
    else {
        header("Location: index_logado.php?msgErro=Erro de acesso (Operação não definida).");
    }
} else {
    header("Location: index_logado.php?msgErro=Erro de acesso.");
}
die();
    // Redirecionar para a página inicial (index_logado) c/ mensagem erro/sucesso