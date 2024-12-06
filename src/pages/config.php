<?php
session_start();
include_once('../php/conexao.php');

if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
  unset($_SESSION['email']);
  unset($_SESSION['id']);
  header('Location: ../../index.php');
  exit();
}

$logado = isset($_SESSION['email']) ? $_SESSION['email'] : null;
$id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

if ($id === null) {
    // Redirecionar ou lidar com o caso onde o id não está definido
    header('Location: ../../index.php');
    exit();
}

function buscarDadosUsuario($conn, $id) {
  $sql = "SELECT * FROM usuario WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  return $row ? $row : null;
}

$dadosUsuario = buscarDadosUsuario($conn, $id);
$nome = explode(' ', $dadosUsuario['nome'])[0] . ' ' . explode(' ', $dadosUsuario['nome'])[1];
$adm = $dadosUsuario['adm'];
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
            <img id="fotoPerfil" src="<?php echo $dadosUsuario['foto'] ? 'data:image/jpeg;base64,' . base64_encode($dadosUsuario['foto']) : '../img/perfil.jpg'; ?>" alt="Foto de Perfil">
            <div class="info-perfil">
            <h4 id="NomeUsuario"><?php print_r($nome)?></h4>
            </div>
          </div>
          <hr>
          <div class="logout">
            <img id="fotoPerfil" src="<?php echo $dadosUsuario['foto'] ? 'data:image/jpeg;base64,' . base64_encode($dadosUsuario['foto']) : '../img/perfil.jpg'; ?>" alt="Foto de Perfil">
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
        <img id="fotoPerfil" class="menu-config" src="<?php echo $dadosUsuario['foto'] ? 'data:image/jpeg;base64,' . base64_encode($dadosUsuario['foto']) : '../img/perfil.jpg'; ?>" alt="Foto de Perfil">
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
          <div class="div2fa">
            <p class="nomeConfig">Ativar autenticação de 2 Fatores</p>
            <label class="switch">
              <input type="checkbox" id="2fa" <?php echo $adm == 1 ? 'checked' : ''; ?>>
              <span class="slider round"></span>
            </label>
          </div>
        </div>
      </div>
    </section>
    <!-- FIM MAIN -->
  </body>
</html>