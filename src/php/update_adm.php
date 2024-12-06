<?php
session_start();
include_once('conexao.php');

if (!isset($_SESSION['id'])) {
  echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
  exit();
}

$id = $_SESSION['id'];
$data = json_decode(file_get_contents('php://input'), true);
$adm = isset($data['adm']) ? (int)$data['adm'] : 0;

$sql = "UPDATE usuario SET adm = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $adm, $id);

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o banco de dados']);
}

$stmt->close();
$conn->close();
?>