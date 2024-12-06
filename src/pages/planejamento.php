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

// Função para buscar os débitos do usuário no banco de dados
function buscarDebitos($conn, $id) {
  $sql = "SELECT * FROM debito WHERE fk_id_usuario = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $debitos = [];
  while ($row = $result->fetch_assoc()) {
      $debitos[] = $row;
  }
  return $debitos;
}

$debitos = buscarDebitos($conn, $id);




?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/style.css" />
  <script src="https://kit.fontawesome.com/7414161b6e.js" crossorigin="anonymous"></script>
  <script type="module" src="../js/script.js" defer></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Planejamento</title>
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
        <hr />
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
      <a href="dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
      <a href="#"><i class="fa-solid fa-clipboard-list"></i> Planejamento</a>
      <a href="user.php"><i class="fa-regular fa-circle-user"></i> User</a>
      <?php if ($dadosUsuario['email'] === "contatosmartwallet@gmail.com"): ?>
          <a href="admin.php"><i class="fa-solid fa-user-cog"></i> Admin</a>
      <?php endif; ?>
      <a href="config.php" class="mobile"><i class="fa-solid fa-gear"></i> Configurações</a>
      <a href="notificacoes.php" class="mobile"><i class="fa-solid fa-bell"></i> Notficações</a>
      <a href="../php/sair.php" class="mobile"><i class="fa-solid fa-power-off"></i> Logout</a>
      <hr />
    </div>
    <!-- CONTENT -->
    <div class="content planejamento">
      <div class="info-planejamento">
        <div class="entrada-salario">
          <h2>Entrada Financeira</h2>
          <form id="formSalario" method="POST">
            <p>R$ <input type="text" name="entradaSalario" id="entradaSalario" placeholder="0,00" value="<?php echo htmlspecialchars($totalEntrada); ?>"></p>
            <button type="submit" style="width: 100%; margin-top: 5px;">Adicionar</button>
          </form>
        </div>
        <div class="gastos-totais">
          <h2>Gastos Totais</h2>
          <p>R$ <input type="text" id="totaisGastos" value="<?php echo number_format($totalDebitos, 2, ',', '.'); ?>" placeholder=" 00.00" disabled></p>
        </div>
      </div>
      <div class="containertodo">
        <div class="containerLista desktop">
          <h2>Adicione seus débitos</h2>
          <form id="formPlanejamento" class="formPLanejamento" method="POST">
            <span class="id">
              <p>Identificação </p><input class="identificacao" name="ident_deb"  type="text" placeholder="Identificação" maxlength="15" required>
            </span>
            <span class="obs">
              <p>Observação </p><input class="observacao" name="obs_deb" type="text" placeholder="Observação" maxlength="100">
            </span>
            <span>
              <p>Valor R$ </p><input class="valor" name="valor_deb" type="text" placeholder="Valor R$" max="15" required>
            </span>
            <span>
              <p>Vencimento </p><input class="vencimento" type="date" name="data_venc" id="vencimento" placeholder="DD / MM / AAAA" maxlength="10" minlength="10" required>
            </span>
            <span class="notf">
              <p>Notificação <br>de Vencimento</p>
              <select name="notficacao" id="notficacao" required>
                <option value="" selected disabled></option>
                <option value="1">Sim</option>
                <option value="0">Não</option>
              </select>
            </span>
            
            <div class="btnAdd"><button type="submit">Adicionar<i class="fa-solid fa-plus"></i></button></div>
          </form>
        </div>
        <div class="containerListaMobile">
          <h2>Adicione seus debitos</h2>
          <form id="formPlanejamentoMobile" class="mobile formPLanejamento" method="POST">
            <div style="display: flex;width:75%; flex-direction:column; gap:7px;">
              <input style="width:100%; padding:8px; border: none; border-bottom:1px solid #555;" class="identificacao" name="ident_deb" type="text" placeholder="Identificaçao" maxlength="15" required>
              <input style="width:100%; padding:8px; border: none; border-bottom:1px solid #555;" class="observacao" name="obs_deb" type="text" placeholder="Observaçao" maxlength="100">
            </div>
            <div style="display: flex; width:75%; flex-direction:column; gap:7px;">
              <input style="width:100%; padding:8px; border: none; border-bottom:1px solid #555;" class="valor" name="valor_deb" type="text" placeholder="Valor R$" max="15" required>
              <input style="width:100%; padding:8px; border: none; border-bottom:1px solid #555;" class="vencimento" type="date" name="data_venc" id="vencimento" placeholder="DD / MM / AAAA" maxlength="10" minlength="10" required>
            </div>
            <select style="width:75%; padding:8px;" name="notficacao" id="notficacao" required>
              <option value="" selected disabled>Notficação</option>
              <option value="1">Sim</option>
              <option value="0">Não</option>
            </select>
            <div style="display: flex; width:75%; flex-direction:column; gap:7px;"><button style="width:100%; padding:8px; height:60px; border:1px solid var(--cor2); border-radius: 10px; color: var(--cor1); font-weight: bold;" type="submit">adicionar<i class="fa-solid fa-plus"></i></button></div>
            
            <script>
              document.getElementById('formPlanejamento').addEventListener('submit', addfetch);
              document.getElementById('formPlanejamentoMobile').addEventListener('submit', addfetch);

              function addfetch(event) {
                  event.preventDefault(); // Impede o envio padrão do formulário

                  const form = event.target;
                  const formData = new FormData(this);

                  const valorField = form.querySelector('input[name="valor_deb"]');
                  const valor = valorField.value.replace(/[^\d,]/g, '').replace(',', '.');
                  formData.set('valor_deb', valor);

                  fetch('../php/processa_planejamento.php', {
                      method: 'POST',
                      body: formData
                  })
                  .then(response => response.text())
                  .then(data => {
                      Swal.fire({
                          icon: 'success',
                          title: 'Débito adicionado com sucesso!',
                          showConfirmButton: false,
                          timer: 1500
                      });
                      // Aqui você pode adicionar código para atualizar a página, se necessário
                  })
                  .catch(error => Swal.fire({
                      position: 'bottom-end',
                      icon: 'error',
                      title: 'Erro: ' + error,
                      showConfirmButton: false,
                      timer: 1500
                  }));
              }
          </script>
  
          <script>
            document.getElementById('formSalario').addEventListener('submit', function(event) {
              event.preventDefault(); // Impede o envio padrão do formulário

            const formData = new FormData(this);

            fetch('../php/entrada.php', {
                method: 'POST',
                body: formData
              })
              .then(response => response.text())
              .then(data => {
                Swal.fire({
                  icon: 'success',
                  title: 'Seu salário foi adicionado com sucesso!',
                  showConfirmButton: false,
                  timer: 1500
                });
                // Aqui você pode adicionar código para atualizar a página, se necessário
              })
              .catch(error => Swal.fire({
                position: 'bottom-end',
                icon: 'error',
                title: 'Erro: ' + error,
                showConfirmButton: false,
                timer: 1500
              }));
            });
          </script>

        </form>
        </div>
        <ul class="listtodo">
          <li class="todo">
            <h3 class="identif">Identificação</h3>
            <h3 class="obstodo" style="text-align: center;">Observação<h3>
              <h3 class="precotodo" style="margin-left: -40px;">Preço</h3>
              <h3 class="vencimentotodo" style="text-align: center;">Vencimento</h3>
                <h3 class="notftodo" style="text-align: center;">Notificações</h3>
                <h3 class="btnstodo"></h3>
          </li>
          <?php foreach ($debitos as $debito): ?>
            <?php
            $dataVenc = DateTime::createFromFormat('Y-m-d', $debito['data_venc']);
            $hoje = new DateTime();
            $intervalo = $hoje->diff($dataVenc)->days;
            $isProximo = $intervalo <= 10;
            $isPago = $debito['pago'];
            ?>
            <li class="todo" style="<?php echo $isPago ? 'text-decoration: line-through; background-color: #e2dfdf; color: #6e6d6d;' : ($isProximo ? 'background-color: #f7921f;' : ''); ?>">
                <h3 class="identif" style="text-align: center;"><?php echo htmlspecialchars($debito['ident_deb']); ?></h3>
                <h3 class="obstodo"><?php echo htmlspecialchars($debito['obs_deb']); ?></h3>
                <h3 class="precotodo" style="text-align: center;"><?php echo 'R$ '. htmlspecialchars(number_format($debito['valor_deb'], 2, ',', '.')); ?></h3>
                <h3 class="vencimentotodo" style="text-align: center;">
                <?php 
                  echo $dataVenc ? $dataVenc->format('d/m/Y') : 'Data inválida'; 
                ?></h3>
                <?php if ($debito['notifi'] == 1) {
                    echo '<h3 class="notftodo" style="text-align: center;">Sim</h3>';
                } else {
                    echo '<h3 class="notftodo" style="text-align: center;">Não</h3>';
                }
                ?>
                <div class="btnstodo">
                    <button class="btncheck" data-id="<?php echo htmlspecialchars($debito['id_deb']); ?>" <?php echo $isPago ? 'disabled style="background: #504f4f;"' : ''; ?>> Pago <i class="fa-solid fa-check"></i> </button>
                    <button class="btntrash" name="<?php echo htmlspecialchars($debito['id_deb']); ?>"> Excluir <i class="fa-solid fa-trash"></i> </button>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </section>
  <!-- FIM MAIN -->
</body>

</html>
