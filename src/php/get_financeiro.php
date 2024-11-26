<?php
require_once "conexao.php";
session_start();

$id_usuario = $_SESSION['id'];

// Verificar se a sessão está ativa
if (!isset($id_usuario)) {
    echo json_encode(['error' => 'Usuário não autenticado']);
    exit();
}

// Buscar entradas
$sqlEntradas = "SELECT SUM(valor_ent) as total_entrada FROM ent_financeira WHERE fk_id_usuario = ?";
$stmtEntradas = $conn->prepare($sqlEntradas);
$stmtEntradas->bind_param("i", $id_usuario);
$stmtEntradas->execute();
$resultEntradas = $stmtEntradas->get_result();
$totalEntrada = $resultEntradas->fetch_assoc()['total_entrada'];

// Buscar débitos
$sqlDebitos = "SELECT SUM(valor_deb) as total_debito FROM debito WHERE fk_id_usuario = ?";
$stmtDebitos = $conn->prepare($sqlDebitos);
$stmtDebitos->bind_param("i", $id_usuario);
$stmtDebitos->execute();
$resultDebitos = $stmtDebitos->get_result();
$totalDebito = $resultDebitos->fetch_assoc()['total_debito'];

// Garantir que os valores não sejam nulos
$totalEntrada = $totalEntrada ? $totalEntrada : 0;
$totalDebito = $totalDebito ? $totalDebito : 0;

$response = [
    'total_entrada' => $totalEntrada,
    'total_debito' => $totalDebito,
    'restante' => $totalEntrada - $totalDebito
];

header('Content-Type: application/json');
echo json_encode($response);
?>