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
    <style>
      .twofa {
        display: inline-block;
        margin-right: 20px;
        margin-bottom: 15px;
      }

      .twofa::after {
        content: '';
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.2rem;
        width: 20px;
        height: 20px;
        padding: 5px;
        border-radius: 5px;
        background-color: #fff;
        border: 1px solid #121d77;
        color: white;
      }

      .twofa:checked::after {
        content: '✔';
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.2rem;
        width: 20px;
        height: 20px;
        padding: 5px;
        border-radius: 5px;
        background-color: #121d77;
        color: white;
      }

    </style>
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
              <Button><a href="config.php"><i class="fa-solid fa-gear"></i></a></Button>
              <button><a href="../php/sair.php"><i class="fa-solid fa-power-off"></i></a></button>
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
          <div class="divConfig">
            <label class="nomeConfig" for="2fa">Autenticação de 2 Fatores</label>
              <input style="padding: 100px;" type="checkbox" class="twofa" id="2fa" <?php echo $adm == 1 ? 'checked' : ''; ?>>
          </div>
        </div>
      </div>
    </section>
    <!-- FIM MAIN -->
  </body>
</html>