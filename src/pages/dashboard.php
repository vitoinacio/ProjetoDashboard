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
// Verificar se o nome possui mais de um nome
$nomePartes = explode(' ', $dadosUsuario['nome']);
if (count($nomePartes) > 1) {
    $nome = $nomePartes[0] . ' ' . $nomePartes[1];
} else {
    $nome = $dadosUsuario['nome'];
}

// Buscar o valor total de entrada do banco de dados
$sql = "SELECT SUM(valor_ent) as total_entrada FROM ent_financeira WHERE fk_id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalEntrada = $row['total_entrada'] ? $row['total_entrada'] : 0;

// Buscar o valor total de débitos do BD
$sql = "SELECT SUM(valor_deb) as total_debitos FROM debito WHERE fk_id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalDebitos = $row['total_debitos'] ? $row['total_debitos'] : 0;

// Calculo do valor restante
$valorRestante = $totalEntrada - $totalDebitos;

if ($totalEntrada === 0) {
  $percentualRestante = 0;
} else {
  $percentualRestante = ($valorRestante / $totalEntrada) * 100;
}


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
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0" defer></script>
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
            <h3><a href="../../index.php" style="text-decoration: none; color: inherit;">SmartWallet</a></h3>
        </div>
      </div>
      <div class="info-header">
        <a href="notificacoes.php"><i class="fa-solid fa-bell"></i></a>
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
        <a href="dashboard.php"
          ><i class="fa-solid fa-chart-line"></i> Dashboard</a
        >
        <a href="planejamento.php"><i class="fa-solid fa-clipboard-list"></i> Planejamento</a>
        <a href="user.php"><i class="fa-regular fa-circle-user"></i> User</a>
        <?php if ($dadosUsuario['email'] === "contatosmartwallet@gmail.com"): ?>
          <a href="admin.php"><i class="fa-solid fa-user-cog"></i> Admin</a>
        <?php endif; ?>
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
          >
            <div class="info-text">
              <h3>Entrada total</h3>
              <p>R$ <?php echo number_format($totalEntrada, 2, ',', '.'); ?> </p>
            </div>
            <i class="fa-solid fa-money-bills"></i>
          </div>
          <div
            class="info-cash-box"
          >
            <div class="info-text">
              <h3>Debitos totais</h3>
              <p>R$ <?php echo number_format($totalDebitos, 2, ',', '.'); ?></p>
            </div>
            <i class="fa-solid fa-receipt"></i>
          </div>
          <div class="info-cash-box" data-percentual-restante="<?php echo $percentualRestante; ?>">
            <div class="info-text">
              <h3>Restante</h3>
              <p>R$ <?php echo number_format($valorRestante, 2, ',','.'); ?></p>
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
    <script>
      document.addEventListener('DOMContentLoaded', handleTheme);
      function handleTheme() {
        const boxInfo = document.querySelectorAll('.info-cash-box');
        if(boxInfo.length){
          const percentualRestante = parseFloat(boxInfo[2].getAttribute('data-percentual-restante'));

          if (sessionStorage.getItem('theme') === 'dark') {
            boxInfo[0].style.background = 'linear-gradient(45deg, rgb(1 1 30), rgb(6 6 126))';
            boxInfo[1].style.background = 'linear-gradient(45deg, rgb(39 29 0), #9b6604)';
            if (percentualRestante < 30) {
              boxInfo[2].style.background = 'linear-gradient(45deg, rgb(41 0 0), rgb(153 0 0))'; // Vermelho
            } else {
              boxInfo[2].style.background = 'linear-gradient(45deg, rgb(0 41 0), rgb(0 153 0))'; // Verde
            }
          } else {
            boxInfo[0].style.background = 'linear-gradient(45deg, rgb(3, 3, 158), blue)';
            boxInfo[1].style.background = 'linear-gradient(45deg, rgb(199, 146, 2), orange)';
            if (percentualRestante < 30) {
              boxInfo[2].style.background = 'linear-gradient(45deg, rgb(156, 2, 2), rgb(221, 3, 3))'; // Vermelho
            } else {
              boxInfo[2].style.background = 'linear-gradient(45deg,rgb(2, 156, 2),rgb(3, 221, 3))'; // Verde
            }
          }
        }
      }
    </script>
  </body>
</html>
