<?php
session_start();
include_once('conexao.php');

if (!isset($_SESSION['id'])) {
  echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
  exit();
}

$id = $_SESSION['id'];
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['twoFa'])) {
  echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
  exit();
}

$twoFa = $data['twoFa'] ? 1 : 0; // Converter para 1 (true) ou 0 (false)

$sql = "UPDATE usuario SET twoFa = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $twoFa, $id);

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o banco de dados']);
}

$stmt->close();
$conn->close();
?>