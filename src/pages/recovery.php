<?php
session_start();
require_once '../php/conexao.php';
require_once "../php/phpmailer/PHPMailer.php";
require_once "../php/phpmailer/SMTP.php";
require_once "../php/phpmailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['email'])) {
    header('Location: ../../index.php?errorMessage=Faça verificação do email para prosseguir');
    exit();
}

$email = $_SESSION['email'];

if (!isset($_SESSION['codigo_2fa'])) {
    $codigo = rand(100000, 999999); // Gerar um código de 6 dígitos
    $_SESSION['codigo_2fa'] = $codigo;
    $_SESSION['codigo_2fa_time'] = time(); // Armazenar o timestamp de quando o código foi gerado
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

  // Verificar se o código expirou
  if (time() - $_SESSION['codigo_2fa_time'] > 300) { // 300 segundos = 5 minutos
      unset($_SESSION['codigo_2fa']);
      unset($_SESSION['codigo_2fa_time']);
      header('Location: recovery.php?errorMessage=Código expirado. Por favor, solicite um novo código.');
      exit();
  }

  if ($codigo_inserido == $_SESSION['codigo_2fa']) {
      $_SESSION['2fa'] = true; // Marcar que a 2FA foi concluída
      $_SESSION['tentativas_2fa'] = 0; // Resetar tentativas
      unset($_SESSION['codigo_2fa']); // Remover o código da sessão após a verificação bem-sucedida
      unset($_SESSION['codigo_2fa_time']); // Remover o timestamp do código
      header('Location: trocaSenha.php');
      exit();
  } else {
      $_SESSION['tentativas_2fa'] += 1;

      if ($_SESSION['tentativas_2fa'] >= 3) {
          $_SESSION['tentativas_2fa'] = 0; // Resetar tentativas
          unset($_SESSION['codigo_2fa']); // Remover o código da sessão após exceder o número de tentativas
          unset($_SESSION['codigo_2fa_time']); // Remover o timestamp do código
          header('Location: ../../index.php?errorMessage=Código incorreto. Você excedeu o número de tentativas.');
          exit();
      } else {
          header('Location: recovery.php?errorMessage=Código incorreto. Tentativas restantes: ' . (3 - $_SESSION['tentativas_2fa']));
          exit();
      }
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
  <title>Troca de Senha</title>
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
      <a href="../../index.php" style="color: white;"><i class="fa-solid fa-chart-line"></i>Smart<strong>Wallet</strong></a>
      </h2>
    </div>
  </header>
    <!-- FIM HEADER -->
    <div class="container-cadastro">
    <h2 class="title">Recuperação de Senha</h2>
      <div class="form-cadastro pessoais" style="width: 500px;">
        <form method="POST" class="formInfoPessoais">
          <label for="codigo">Digite o codigo enviado Por email</label>
          <input type="text" id="codigo" name="codigo" required placeholder="Codigo" maxlength="6">
          <?php if (isset($_GET['errorMessage'])): ?>
              <p id="errorMessage" style="color: red; width:100% ;text-align: start; font-size: 12px;"><?php echo htmlspecialchars($_GET['errorMessage']); ?></p>
          <?php endif; ?>
            <button type="submit">Verificar</button>
        </form>
      </div>
    </div>
    <script>
      const errorMessage = document.querySelector('#errorMessage');
      const emailCodigo = document.querySelector('#codigo');
      emailCodigo.addEventListener('input', () => {
        if (errorMessage) {
          errorMessage.style.display = 'none';
        }
      });
    </script>
</body>
</html>