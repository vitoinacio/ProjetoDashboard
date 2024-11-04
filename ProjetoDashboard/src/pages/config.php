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
    <script type="module" src="../js/script.js" defer></script>
    <title>Configurações</title>
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
        <i class="fa-solid fa-gear"></i>
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
              <Button><a href="#"><i class="fa-solid fa-gear"></i></a></Button>
              <Button><i class="fa-solid fa-power-off"></i></Button>
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
        <a href="dashboard.php">
          <i class="fa-solid fa-chart-line"></i> Dashboard</a
        >
        <a href="planejamento.php"><i class="fa-solid fa-clipboard-list"></i> Planejamento</a>
        <a href="user.php"><i class="fa-regular fa-circle-user"></i> User</a>
        <a href="config.php" class="mobile"
          ><i class="fa-solid fa-gear"></i> Configurações</a
        >
        <a href="notificacoes.php" class="mobile"
          ><i class="fa-solid fa-bell"></i> Notficações</a
        >
        <a href="../php/sair.php" class="mobile" id="btnlogout"
          ><i class="fa-solid fa-power-off"></i> Logout</a
        >
        <hr />
      </div>
      <!-- CONTENT -->
      <div class="content">
        <div class="containerConfigs">
          <div class="divConfig">
            <p class="nomeConfig">Mudar Tema</p>
            <span class="themeContent"><button id="theme"></button></span>
          </div>
          <div class="divConfig">
            <p class="nomeConfig">Tamanho da Fonte</p>
            <input id="fontSizeConfig" type="number" placeholder="Tamanho da Fonte" min="18" max="30">
          </div>
        </div>
      </div>
    </section>
    <!-- FIM MAIN -->
  </body>
</html>