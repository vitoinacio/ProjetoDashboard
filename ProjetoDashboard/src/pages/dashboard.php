<?php
  session_start();
  print_r($_SESSION['email']);
  if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
  {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: ../../index.html');
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
    <script type="module" src="../js/script.js" defer></script>
    <title>Dashboard</title>
  </head>
  <body>
    <!-- INICIO HEADER -->
    <header>
      <div class="info-header">
        <div class="logo">
          <div class="contentMenuMobile">
            <span class="menuMobile"></span>
            <span class="menuMobile"></span>
            <span class="menuMobile"></span>
          </div>
          <h3>SmartWallet</h3>
        </div>
      </div>
      <div class="info-header">
        <a href="notificacoes.php"><i class="fa-solid fa-bell"></i></a>
        <a href="config.php"><i class="fa-solid fa-gear"></i></a>
        <div class="dropdown-menu">
          <div class="perfil-menu">
            <img id="fotoPerfil" src="../img/perfil.jpg" alt="Perfil Usuario">
            <div class="info-perfil">
              <h4 id="NomeUsuario">Usuario</h4>
              <h5>Plano Completo</h5>
            </div>
          </div>
          <hr>
          <div class="logout">
            <img id="fotoPerfil" src="../img/perfil.jpg" alt="Perfil Usuario">
            <div class="login">
              <p>Logado como:</p>
              <h5><?php print_r($_SESSION['email'])?></h5>
            </div>
            <div class="buttons-menu">
              <Button><a href="config.php"><i class="fa-solid fa-gear"></i></a></Button>
              <button><a href="../php/sair.php"><i class="fa-solid fa-power-off"></i></a></button>
            </div>
          </div>
        </div>
        <img class="menu-config" id="fotoPerfil" src="../img/perfil.jpg" alt="foto-perfil" />
      </div>
    </header>
    <!-- FIM HEADER -->

    <!-- INICIO MAIN -->
    <section class="main">
      <!-- SIDEBAR -->
      <div class="sidebar">
        <h3>Home</h3>
        <a href="dashboard.php"
          ><i class="fa-solid fa-chart-line"></i> Dashboard</a
        >
        <a href="planejamento.php"><i class="fa-solid fa-clipboard-list"></i> Planejamento</a>
        <a href="user.php"><i class="fa-regular fa-circle-user"></i> User</a>
        <a href="config.php" class="mobile"
          ><i class="fa-solid fa-gear"></i> Configurações</a
        >
        <a href="notificacoes.php" class="mobile"
          ><i class="fa-solid fa-bell"></i> Notficações</a
        >
        <a href="../php/sair.php" class="mobile"
          ><i class="fa-solid fa-power-off"></i> Logout</a
        >
        <hr />
      </div>
      <!-- CONTENT -->
      <div class="content">
        <div class="info-cash">
          <div
            class="info-cash-box"
            onload="handleTheme()"
          >
            <div class="info-text">
              <h3>Entrada total</h3>
              <p>R$ 000,00</p>
            </div>
            <i class="fa-solid fa-money-bills"></i>
          </div>
          <div
            class="info-cash-box"
          >
            <div class="info-text">
              <h3>Debitos totais</h3>
              <p>R$ 000,00</p>
            </div>
            <i class="fa-solid fa-receipt"></i>
          </div>
          <div
            class="info-cash-box"
          >
            <div class="info-text">
              <h3>Restante</h3>
              <p>R$ 000,00</p>
            </div>
            <i class="fa-solid fa-coins"></i>
          </div>
        </div>
        <div class="info-graficos">
          <div class="grafico-box">
            <canvas id="graficoDeBarra"></canvas>
          </div>
          <div class="grafico-box">
            <canvas id="graficoCircular"></canvas>
          </div>
        </div>
      </div>
    </section>
    <!-- FIM MAIN -->
  </body>
</html>
