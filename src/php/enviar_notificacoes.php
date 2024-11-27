<?php
require_once "../php/conexao.php";
require_once "../php/phpmailer/PHPMailer.php";
require_once "../php/phpmailer/SMTP.php";
require_once "../php/phpmailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarEmailNotificacao($email, $notificacao) {
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
    $mail->Subject = 'Notificação de Débito Próximo ao Vencimento';
    $mail->Body    = "
      <div style='background-color: #003; padding: 20px; text-align: center; color: white;'>
        <h1>SmartWallet</h1>
      </div>
      <div style='background-color: #f8f9fa; padding: 20px; color: #343a40; text-align: center;'>
        <p style='font-size: 18px;'>Olá,</p>
        <p style='font-size: 16px;'>Seu débito <strong>" . htmlspecialchars($notificacao['ident_deb']) . "</strong> no valor de <strong>R$ " . number_format($notificacao['valor_deb'], 2, ',', '.') . "</strong> está próximo do vencimento em <strong>" . date('d/m/Y', strtotime($notificacao['data_venc'])) . "</strong>.</p>
        <p style='font-size: 16px;'>Por favor, certifique-se de efetuar o pagamento antes da data de vencimento para evitar quaisquer encargos adicionais.</p>
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

function buscarNotificacoes($conn) {
  $sql = "SELECT u.email, d.id_deb AS debito_id, d.ident_deb, d.data_venc, d.valor_deb FROM debito d JOIN usuario u ON d.fk_id_usuario = u.id WHERE DATEDIFF(d.data_venc, CURDATE()) <= 10 AND DATEDIFF(d.data_venc, CURDATE()) >= 0 AND d.notifi = 1 AND d.notificacao_enviada = 0";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();

  $notificacoes = [];
  while ($row = $result->fetch_assoc()) {
      $notificacoes[] = $row;
  }

  return $notificacoes;
}

$notificacoes = buscarNotificacoes($conn);

// Verificar se há notificações a serem enviadas
if (!empty($notificacoes)) {
  // Enviar e-mails de notificação
  foreach ($notificacoes as $notificacao) {
    enviarEmailNotificacao($notificacao['email'], $notificacao);

    // Atualizar a coluna notificacao_enviada para evitar envios duplicados
    $sql = "UPDATE debito SET notificacao_enviada = 1 WHERE id_deb = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $notificacao['debito_id']);
    $stmt->execute();
  }
}
?>