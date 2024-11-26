<?php
session_start();
include_once('../php/conexao.php');

if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
  unset($_SESSION['email']);
  unset($_SESSION['senha']);
  header('Location: ../../index.html');
  exit();
}

$logado = isset($_SESSION['email']) ? $_SESSION['email'] : null;
$id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

if ($id === null) {
    // Redirecionar ou lidar com o caso onde o id não está definido
    header('Location: ../../index.html');
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

function buscarNotificacoes($conn, $id) {
  $sql = "SELECT ident_deb, data_venc, valor_deb FROM debito WHERE fk_id_usuario = ? AND DATEDIFF(data_venc, CURDATE()) <= 10 AND DATEDIFF(data_venc, CURDATE()) >= 0 AND notifi = 1";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  $notificacoes = [];
  while ($row = $result->fetch_assoc()) {
      $notificacoes[] = $row;
  }

  return $notificacoes;
}

// Debug: Verificar se há notificações
if (buscarNotificacoes($conn, $id) === null) {
    echo "Nenhuma notificação encontrada.";
} else {
    $notificacoes = buscarNotificacoes($conn, $id);
}

$dadosUsuario = buscarDadosUsuario($conn, $id);
$nome = explode(' ', $dadosUsuario['nome'])[0] . ' ' . explode(' ', $dadosUsuario['nome'])[1];
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
        <i class="fa-solid fa-bell"></i>
        <a href="config.php"><i class="fa-solid fa-gear"></i></a>
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
        <a href="#" class="mobile"
          ><i class="fa-solid fa-bell"></i> Notificações</a
        >
        <a href="../php/sair.php" class="mobile"
          ><i class="fa-solid fa-power-off"></i> Logout</a
        >
        <hr />
      </div>
      <!-- CONTENT -->
      <div class="content notfy">
        <div class="containerNotfi">
          <h4 class="tituloNotfi">Notificaçoes</h4>
          <div class="notficacoesContainer" style="justify-content: initial; align-items: initial; flex-direction: column;">
          <?php if (empty($notificacoes)): ?>
            <p class="semNofi">Sem Notificações</p>
          <?php else: ?>
            <ul>
              <?php foreach ($notificacoes as $notificacao): ?>
                <li>
                  <p>Seu débito <strong><?php echo htmlspecialchars($notificacao['ident_deb']); ?></strong> no valor de <strong>R$ <?php echo number_format($notificacao['valor_deb'], 2, ',', '.'); ?></strong> está próximo do vencimento em <strong><?php echo date('d/m/Y', strtotime($notificacao['data_venc'])); ?></strong>.</p>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
    <!-- FIM MAIN -->
  </body>
</html>