<?php
session_start();
require_once '../php/conexao.php';
require_once "../php/phpmailer/PHPMailer.php";
require_once "../php/phpmailer/SMTP.php";
require_once "../php/phpmailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
    header('Location: ../../index.php?errorMessage=Faça login para acessar esta página');
    exit();
}

$email = $_SESSION['email'];
$id['id'] = $_SESSION['id'];

if (!isset($_SESSION['codigo_2fa'])) {
    $codigo = rand(100000, 999999); // Gerar um código de 6 dígitos
    $_SESSION['codigo_2fa'] = $codigo;
    enviarCodigoAutenticacao($email, $codigo);
}

if (!isset($_SESSION['tentativas_2fa'])) {
    $_SESSION['tentativas_2fa'] = 0;
}

function enviarCodigoAutenticacao($email, $codigo) {
  $mail = new PHPMailer(true);
  try {
    // Configurações do servidor
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'contatosmartwallet@gmail.com'; // E-mail do remetente
    $mail->Password = 'xrwp xeqi tjfj nthx'; // Senha de aplicativo do Gmail
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Configurações de codificação
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    // Remetente e destinatário
    $mail->setFrom('contatosmartwallet@gmail.com', 'SmartWallet'); // E-mail do remetente
    $mail->addAddress($email); // E-mail do destinatário (usuário logado)

    // Conteúdo do e-mail
    $mail->isHTML(true);
    $mail->Subject = 'Código de Autenticação de Dois Fatores';
    $mail->Body    = "
      <div style='background-color: #003; padding: 20px; text-align: center; color: white;'>
        <h1>SmartWallet</h1>
      </div>
      <div style='background-color: #f8f9fa; padding: 20px; color: #343a40; text-align: center;'>
        <p style='font-size: 18px;'>Olá,</p>
        <p style='font-size: 16px;'>Seu código de autenticação é:</p>
        <p style='font-size: 20px;'><strong>" . htmlspecialchars($codigo) . "</strong></p>
        <p style='font-size: 16px;'>Por favor, insira este código no campo de verificação para completar o processo de login.</p>
      </div>
      <div style='background-color: #003; padding: 20px; text-align: center; color: white;'>
        <p style='font-size: 14px;'>SmartWallet - Gerencie suas finanças de forma inteligente.</p>
        <p style='font-size: 14px;'>Contato: contato@smartwallet.com</p>
        <p style='font-size: 14px;'>Telefone: (21) 12345-6789</p>
      </div>
    ";

    $mail->send();
  } catch (Exception $e) {
    error_log("Falha ao enviar e-mail para $email. Erro: {$mail->ErrorInfo}");
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $codigo_inserido = $_POST['codigo'];

  if ($codigo_inserido == $_SESSION['codigo_2fa']) {
      $_SESSION['2fa'] = true; // Marcar que a 2FA foi concluída
      $_SESSION['tentativas_2fa'] = 0; // Resetar tentativas
      unset($_SESSION['codigo_2fa']); // Remover o código da sessão após a verificação bem-sucedida
      header('Location: dashboard.php');
      exit();
  } else {
      $_SESSION['tentativas_2fa'] += 1;

      if ($_SESSION['tentativas_2fa'] >= 3) {
          $_SESSION['tentativas_2fa'] = 0; // Resetar tentativas
          unset($_SESSION['codigo_2fa']); // Remover o código da sessão após exceder o número de tentativas
          header('Location: ../../index.php?errorMessage=Código incorreto. Você excedeu o número de tentativas.');
          exit();
      } else {
          header('Location: autenticacao.php?errorMessage=Código incorreto. Tentativas restantes: ' . (3 - $_SESSION['tentativas_2fa']));
          exit();
      }
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
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

    .caixa{
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

    form{
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      gap: 10px;
      width: 100%;
    }

    input {
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 2px;
      width: 100%;
    }

    button {
      width: 100%;
      cursor: pointer;
    }
  </style>
    <title>Verificação de Dois Fatores</title>
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
    <!-- INICIO MAIN -->
    <div class="container-cadastro">
      <h2 class="title">Preencha os campos abaixo</h2>
        <div class="form-cadastro pessoais" style="width: 500px;">
          <div class="caixa">
            <h2>Verificação de Dois Fatores</h2>
            <?php if (isset($_GET['errorMessage'])): ?>
              <p style="color: red;"><?php echo htmlspecialchars($_GET['errorMessage']); ?></p>
            <?php endif; ?>
            <form method="POST">
              <label for="codigo">Digite o codigo enviado pelo email:</label>
              <input type="text" id="codigo" name="codigo" required maxlength="6" placeholder="Código de Verificação">
              <button type="submit">Verificar</button>
            </form>
          </div>
        </div>
    </div>
</body>
</html>