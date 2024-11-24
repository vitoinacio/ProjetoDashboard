<?php
    include_once('../php/conexao.php');
  session_start();
  // print_r($_SESSION['email']);
  // print_r($_SESSION['id']);
  if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
  {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: ../../index.html');
  }
  $logado = $_SESSION['email'];


  if(!empty($_SESSION['id'])){

    $id = $_SESSION['id'];

    $sqlSelect = "SELECT * FROM usuario where id = $id";

    $result = $conn->query($sqlSelect);

    $pessoa = array();

    if($result->num_rows > 0)
    {
      $user_data = mysqli_fetch_assoc($result);

      foreach($user_data as $key => $value){
        $pessoa[$key] = $value;
        // echo $key . '<br><br>';
      }

      // while($user_data = mysqli_fetch_assoc($result))
      // {
      //   $pessoa['nome'] = $user_data["nome"];
      //   $pessoa['sexo'] = $user_data["sexo"];
      //   $pessoa['dataNasc'] = $user_data["dataNasc"];
      //   $pessoa['email'] = $user_data["email"];
      //   $pessoa['senha'] = $user_data["senha"];
      //   $pessoa['cpf'] = $user_data["cpf"];
      //   $pessoa['tel'] = $user_data["tel"];
      //   $pessoa['cep'] = $user_data["cep"];
      //   $pessoa['cidade'] = $user_data["cidade"];
      //   $pessoa['bairro'] = $user_data["bairro"];
      //   $pessoa['rua'] = $user_data["rua"];
      //   $pessoa['numeroCasa'] = $user_data["numeroCasa"];
      // }
    }
    else
    {
      header('Location:admin.php');
    }
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
  <script type="module" src="../js/script.js" defer></script>
  <title>User</title>
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
      <a href="dashboard.php">
        <i class="fa-solid fa-chart-line"></i> Dashboard</a>
      <a href="planejamento.php"><i class="fa-solid fa-clipboard-list"></i> Planejamento</a>
      <a href="user.php"><i class="fa-regular fa-circle-user"></i> User</a>
      <a href="config.php" class="mobile"><i class="fa-solid fa-gear"></i> Configurações</a>
      <a href="notificacoes.php" class="mobile"><i class="fa-solid fa-bell"></i> Notficações</a>
      <a href="../php/sair.php" class="mobile"><i class="fa-solid fa-power-off"></i> Logout</a>
      <hr />
    </div>
    <!-- CONTENT -->
    <div class="content user">
      <div class="userPerfil">
        <img src="../img/perfil.jpg" alt="Foto de Perfil" id="fotoPerfil">
        <label class="labelFotoPerfil" for="fotoPerfilInput">Editar foto <i class="fa-solid fa-user-plus"></i></label>
        <input type="file" id="fotoPerfilInput" name="fotoPerfilInput" accept="image/*" placeholder="">
      </div>
      <div class="userInfo">
        <div class="tituloUser">
          <h2>Perfil</h2><a href="editUser.php?id=<?php echo $_SESSION['id']; ?>" class="editUser"><i class="fa-solid fa-pen"></i></a>
        </div>
        <form class="formUser" onsubmit="event.preventDefault()">
          <label for="name">Nome:
            <div>
              <input disabled type="text" id="nome" minlength="10" maxlength="50" value="<?php echo (isset($pessoa['nome']) && !empty($pessoa['nome'])) ? $pessoa['nome'] : ''; ?>">
            </div>
          </label>
          <label for="cpf">Cpf:
            <div><input disabled type="text" id="cpf" value="<?php echo (isset($pessoa['cpf']) && !empty($pessoa['cpf'])) ? $pessoa['cpf'] : ''; ?>"></div>
          </label>
          <label for="emailUser">Email:
            <div>
              <input disabled type="email" id="emailUser" value="<?php echo (isset($pessoa['email']) && !empty($pessoa['email'])) ? $pessoa['email'] : ''; ?>">
            </div>
          </label>
          <label for="nascimento">Nascimento:
            <div>
              <input disabled type="text" id="dataNasc" minlength="10" maxlength="10" oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{2})(\d)/, '$1/$2').replace(/(\d{2})(\d)/, '$1/$2').slice(0, 10)" value="<?php echo (isset($pessoa['dataNasc']) && !empty($pessoa['dataNasc'])) ? $pessoa['dataNasc'] : ''; ?>">
            </div>
          </label>
          <label for="sexo">Sexo:
            <div>
              <input disabled type="text" id="sexo" value="<?php echo (isset($pessoa['sexo']) && !empty($pessoa['sexo'])) ? $pessoa['sexo'] : ''; ?>">
            </div>
          </label>
          <label for="telefone">Telefone:
            <div>
              <input disabled type="text" id="telefone" value="<?php echo (isset($pessoa['tel']) && !empty($pessoa['tel'])) ? $pessoa['tel'] : ''; ?>">
            </div>
          </label>
          <label for="Senha">Senha:
            <div>
              <input disabled type="password" id="senha" value="<?php echo (isset($pessoa['senha']) && !empty($pessoa['senha'])) ? $pessoa['senha'] : ''; ?>">
            </div>
          </label>
          <label for="cep">Cep:
            <div>
              <input disabled type="text" id="cep" value="<?php echo (isset($pessoa['cep']) && !empty($pessoa['cep'])) ? $pessoa['cep'] : ''; ?>">
            </div>
          </label>
          <label for="cidade">Cidade:
            <div>
              <input disabled type="text" id="cidade" value="<?php echo (isset($pessoa['cidade']) && !empty($pessoa['cidade'])) ? $pessoa['cidade'] : ''; ?>">
            </div>
          </label>
          <label for="bairro">Bairro:
            <div>
              <input disabled type="text" id="bairro" value="<?php echo (isset($pessoa['bairro']) && !empty($pessoa['bairro'])) ? $pessoa['bairro'] : ''; ?>">
            </div>
          </label>
          <label for="rua">Rua:
            <div>
              <input disabled type="text" id="rua" value="<?php echo (isset($pessoa['rua']) && !empty($pessoa['rua'])) ? $pessoa['rua'] : ''; ?>">
            </div>
          </label>
          <label for="numero">Número:
            <div>
              <input disabled type="text" id="endNum" value="<?php echo (isset($pessoa['numeroCasa']) && !empty($pessoa['numeroCasa'])) ? $pessoa['numeroCasa'] : ''; ?>">
            </div>
          </label>
        </form>
      </div>
    </div>
  </section>
  <!-- FIM MAIN -->
</body>

</html>