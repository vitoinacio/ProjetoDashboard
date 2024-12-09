<?php
  session_start();
  // print_r($_SESSION['email']);
  if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['id']) == true))
  {
    unset($_SESSION['email']);
    unset($_SESSION['id']);
    header('Location: ../../index.php');
  }
  $logado = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style.css" />
    <script
      src="https://kit.fontawesome.com/7414161b6e.js"
      crossorigin="anonymous"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    <script type="module" src="src/js/script.js" defer></script>
    <title>Erro - Dashboard</title>
  </head>
  <body>
    <!-- INICIO HEADER -->
    <header>
      <div class="info-header">
        <div class="logo">
        <h3><a href="../../index.php" style="text-decoration: none; color: inherit;">SmartWallet</a></h3>
        </div>
      </div>
      <div class="info-header">
        <i class="fa-solid fa-bell"></i>
        <i class="fa-solid fa-gear"></i>
        <img src="../img/perfil.png" alt="foto-perfil" />
      </div>
    </header>
    <!-- FIM HEADER -->

    <!-- INICIO MAIN -->
    <section class="main">
      <!-- SIDEBAR -->
      

      <!-- MENSAGEM DE ERRO NO LUGAR DO CONTENT -->
      <div class="">
        <div class="error-message">
          Ocorreu um erro ao carregar as informações. Por favor, tente novamente mais tarde.
        </div>
      </div>
    </section>
    <!-- FIM MAIN -->
  </body>
</html>
