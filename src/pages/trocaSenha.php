<?php
session_start();
include_once('../php/conexao.php');

if (!isset($_SESSION['email'])) {
  unset($_SESSION['email']);
  exit();
}

$logado = isset($_SESSION['email']) ? $_SESSION['email'] : null;
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css" />
  <script src="https://kit.fontawesome.com/7414161b6e.js" crossorigin="anonymous"></script>
  <style>
    body{
      overflow-x: hidden;
      display: flex;
      flex-direction: column;
      align-items: center;  
    }

    .container-cadastro {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 70vh;
      width: 500px;
      box-shadow: none;
      margin-left: 100px;
    }

    .title{
      display: flex;
      margin-right: 100px;
      margin-bottom: 20px;
      color: #121d77;
    }

    .formInfoPessoais{
      display: flex;
      flex-direction: column;
      width: 400px;
      margin-right: 100px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.7);
      padding: 40px;
      gap: 10px;
      border-radius: 2px;
    }
  </style>
  <title>Troca de Senha</title>
</head>

<body style="overflow-x: hidden;">
  <!-- INICIO HEADER -->
  <header class="header-nav cadastro-header">
    <div class="logo-nav">
      <h2>
        <i class="fa-solid fa-chart-line"></i>Smart<strong>Wallet</strong>
      </h2>
    </div>
  </header>
    <!-- FIM HEADER -->
    <!-- INICIO MAIN -->
    <div class="container-cadastro">
    <h2 class="title">Digite sua nova senha</h2>
        <div class="form-cadastro pessoais">
            <form class="formInfoPessoais" method="post" action="../php/confirmaSenha.php">
            <input type="password" name="senha" id="senha" placeholder="Senha" minlength="8" maxlength="8" required>
            <input type="password" id="confirmSenha" name="confirmSenha" placeholder="Confirme sua senha" minlength="8" maxlength="8" required>
            <?php
              if (isset($_SESSION['errorMessage'])) {
                echo '<p id="errorMessage" style="color: red; display:block;">' . htmlspecialchars($_SESSION['errorMessage']) . '</p>';
                unset($_SESSION['errorMessage']);
              } else {
                echo '<p id="errorMessage" style="color: red; display:none;"></p>';
              }
            ?>
              <br>
              <div class="btn">
              <input type="hidden" name="id" value="<?php echo $id?>">
                  <button type="submit" name="update" id="update">Enviar</button>
              </div>
            </form>
        </div>
    </div>
    <script>
      document.querySelector('#confirmSenha').addEventListener('input',()=>{
        document.querySelector('#errorMessage').style.display = 'none';
      })
      document.querySelector('#senha').addEventListener('input',()=>{
        document.querySelector('#errorMessage').style.display = 'none';
      })
    </script>
    <!-- FIM MAIN -->
</body>
</html>