<?php
  session_start();
  include_once('../php/conexao.php');
  print_r($_SESSION['email']);
  print_r($_SESSION['id']);


  if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
  {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: ../../index.html');
  }
  $logado = $_SESSION['email'];
  $usuario_id = $_SESSION['id'];

//Visualizar débitos adicionados  
$sql = "SELECT * FROM debito WHERE fk_id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$debitos = $result->fetch_all(MYSQLI_ASSOC);

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
        <h3>SmartWallet</h3>
      </div>
    </div>
    <div class="info-header">
      <a href="notificacoes.php"><i class="fa-solid fa-bell"></i></a>
      <a href="config.php"><i class="fa-solid fa-gear"></i></a>
      <div class="dropdown-menu">
        <div class="perfil-menu">
          <img  id="fotoPerfil" src="../img/perfil.jpg" alt="Perfil Usuario" />
          <div class="info-perfil">
            <h4 id="NomeUsuario">Usuario</h4>
            <h5>Plano Completo</h5>
          </div>
        </div>
        <hr />
        <div class="logout">
          <img id="fotoPerfil" src="../img/perfil.jpg" alt="Perfil Usuario" />
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
      <a href="dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
      <a href="#"><i class="fa-solid fa-clipboard-list"></i> Planejamento</a>
      <a href="user.php"><i class="fa-regular fa-circle-user"></i> User</a>
      <a href="config.php" class="mobile"><i class="fa-solid fa-gear"></i> Configurações</a>
      <a href="notificacoes.php" class="mobile"><i class="fa-solid fa-bell"></i> Notficações</a>
      <a href="../php/sair.php" class="mobile"><i class="fa-solid fa-power-off"></i> Logout</a>
      <hr />
    </div>
    <!-- CONTENT -->
    <div class="content planejamento">
      <div class="info-planejamento">
        <div class="entrada-salario">
          <h2>Salário bruto total</h2>
          <form id="formSalario" method="POST">
            <p>R$ <input type="text" name="entradaSalario" id="entradaSalario" placeholder=" 0,00"></p>
            <button type="submit">Adicionar</button>
          </form>
        </div>
        <div class="gastos-totais">
          <h2>Gastos Totais</h2>
          <p>R$ <input type="text" id="totaisGastos" placeholder=" 00.00" disabled></p>
        </div>
      </div>
      <div class="containertodo">
        <div class="containerLista desktop">
          <h2>Adicione seus debitos</h2>
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
              <p>Vencimento </p><input class="vencimento" type="text" name="data_venc" id="vencimento" placeholder="DD / MM / AAAA" maxlength="10" minlength="10" required>
            </span>
            <span class="notf">
              <p>Notificação <br>de Vencimento</p>
              <select name="notficacao" id="notficacao" required>
                <option value="" selected disabled></option>
                <option value="Sim">Sim</option>
                <option value="Não">Não</option>
              </select>
            </span>
            
            <div class="btnAdd"><button type="submit">Adicionar<i class="fa-solid fa-plus"></i></button></div>
          </form>
        </div>
        <div class="containerListaMobile">
          <h2>Adicione seus debitos</h2>
          <form id="formPlanejamentoMobile" class="formPLanejamento mobile" method="POST">
            <div class="">
              <input class="identificacao" name="ident_deb" type="text" placeholder="Identificaçao" maxlength="15" required>
              <input class="observacao" name="obs_deb" type="text" placeholder="Observaçao" maxlength="100">
            </div>
            <div>
              <input class="valor" name="valor_deb" type="text" placeholder="Valor R$" max="15" required>
              <input class="vencimento" type="text" name="data_venc" id="vencimento" placeholder="DD / MM / AAAA" maxlength="10" minlength="10" required>
            </div>
            <select name="notficacao" id="notficacao" required>
              <option value="" selected disabled>Notficação</option>
              <option value="sim">Sim</option>
              <option value="nao">Não</option>
            </select>
            <div><button type="submit">adicionar<i class="fa-solid fa-plus"></i></button></div>
            
            <script>
              document.getElementById('formPlanejamento').addEventListener('submit', addfetch)
              document.getElementById('formPlanejamentoMobile').addEventListener('submit', addfetch)
              
              
              function addfetch(event) {
                event.preventDefault(); // Impede o envio padrão do formulário
  
              const formData = new FormData(this);
  
              fetch('../php/processa_planejamento.php', {
                  method: 'POST',
                  body: formData
              })
              .then(response => response.text())
    .then(data => {
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Seu débito foi adicionado com sucesso!',
        showConfirmButton: false,
        timer: 1500
      });
      // Aqui você pode adicionar código para atualizar a lista de débitos na página, se necessário
    })
    .catch(error => Swal.fire({
      position: 'bottom-end',
      icon: 'error',
      title: 'Erro: ' + error,
      showConfirmButton: false,
      timer: 1500
    }));
          };
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
            <h3 class="obstodo">Observação<h3>
              <h3 class="precotodo">Preço</h3>
              <h3 class="vencimentotodo">Vencimento</h3>
                <h3 class="notftodo">Notificações</h3>
                <h3 class="btnstodo"></h3>
          </li>
          <?php foreach ($debitos as $debito): ?>
          <li class="todo">
            <h3 class="identif"><?php echo $debito['ident_deb']; ?></h3>
            <h3 class="obstodo"><?php echo $debito['obs_deb']; ?><h3>
            <h3 class="precotodo"><?php echo $debito['valor_deb']; ?></h3>
            <h3 class="vencimentotodo"><?php echo $debito['data_venc']; ?></h3>
            <h3 class="notftodo"><?php echo $debito['notifi']; ?></h3>
            <div class="btnstodo">
              <button class="btncheck"> Pago <i class="fa-solid fa-check"></i> </button>
              <button class="btntrash"> Excluir <i class="fa-solid fa-trash"></i> </button>
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
