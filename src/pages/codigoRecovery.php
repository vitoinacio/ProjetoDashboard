<?php
session_start();
include_once('../php/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['emailCodigo'];

    // Verificar se o email existe na tabela usuario
    $sql = "SELECT * FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email existe, definir na sessão e redirecionar para recovery.php
        $_SESSION['email'] = $email;
        header('Location: recovery.php');
        exit();
    } else {
        // Email não existe, redirecionar com mensagem de erro
        header('Location: codigoRecovery.php?errorMessage=Email não encontrado.');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css" />
  <script src="https://kit.fontawesome.com/7414161b6e.js" crossorigin="anonymous"></script>
  <title>Verificação do email</title>
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
      justify-content: center;
      align-items: center;
      width: 400px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.7);
      padding: 40px;
      gap: 10px;
      border-radius: 2px;
    }

    input{
      width: 100%;
      padding: 8px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }

    button{
      width: 100%;
      padding: 8px;
      border-radius: 4px;
      border: none;
      color: white;
      background-color: #121d77;
      cursor: pointer;
      font-weight: bold;
    }

    button:hover{
      background-color: #0d1544;
    }
  </style>
</head>

<body>
  <!-- INICIO HEADER -->
  <header class="header-nav cadastro-header">
    <div class="logo-nav">
      <h2>
        <i class="fa-solid fa-chart-line"></i>Smart<strong>Wallet</strong>
      </h2>
    </div>
  </header>
    <!-- FIM HEADER -->
    <div class="container-cadastro">
      <h2 class="title">Recuperação de Senha</h2>
      <div class="form-cadastro pessoais" style="width: 500px;">
        <form method="POST" class="formInfoPessoais" action="codigoRecovery.php">
            <label for="emailCodigo">Digite seu Email:</label>
            <input type="text" id="emailCodigo" name="emailCodigo" required placeholder="Email">
            <?php if (isset($_GET['errorMessage'])): ?>
              <p id="errorMessage" style="color: red; width:100% ;text-align: start; font-size: 14px;"><?php echo htmlspecialchars($_GET['errorMessage']); ?></p>
            <?php endif; ?>
            <button type="submit">Enviar Codigo</button>
        </form>
      </div>
    </div>
    <script>
      const errorMessage = document.querySelector('#errorMessage');
      const emailCodigo = document.querySelector('#emailCodigo');
      emailCodigo.addEventListener('input', () => {
        if (errorMessage) {
          errorMessage.style.display = 'none';
        }
      });
    </script>
</body>
</html>