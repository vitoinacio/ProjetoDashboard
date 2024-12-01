<?php
session_start();
include_once('../php/conexao.php');

if (!isset($_SESSION['email'])) {
  unset($_SESSION['email']);
  
 
  exit();
}

$logado = isset($_SESSION['email']) ? $_SESSION['email'] : null;
$id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
// print_r($id);

if ($id === null) {
    // Redirecionar ou lidar com o caso onde o id não está definido
    header('Location: ../../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css" />
  <script src="https://kit.fontawesome.com/7414161b6e.js" crossorigin="anonymous"></script>
  <script type="module" src="../js/script.js" defer></script>
  <title>Troca de Senha</title>
</head>

<body style="overflow-x: hidden;">
  <!-- INICIO HEADER -->
  <header class="header-nav cadastro-header">
    <div class="logo-nav">
      <h2>
        <i class="fa-solid fa-chart-line"></i>Smart<strong>Wallet</strong>
      </h2>
    </div>
  </header>
    <!-- FIM HEADER -->
    <!-- INICIO MAIN -->
    <div class="container-cadastro">
        <div class="form-cadastro pessoais">
            <form class="formInfoPessoais" method="post" action="../php/confirmaSenha.php">
            <input type="password" name="senha" id="senha" placeholder="Senha" minlength="8" maxlength="8" required>
            <input type="password" id="confirmSenha" placeholder="Confirme sua senha" minlength="8" maxlength="8" required>
                <br>
                <div class="btn">
                <input type="hidden" name="id" value="<?php echo $id?>">
                    <button type="submit" name="update" id="update">Enviar</button>
                </div>
            </form>
        </div>
    </div>