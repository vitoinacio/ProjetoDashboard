<?php
require_once "conexao.php";
session_start();

$id_usuario = $_SESSION['id'];

// Verificar se a sessão está ativa
if (!isset($id_usuario)) {
    echo json_encode(['error' => 'Usuário não autenticado']);
    exit();
}

// Buscar débitos
$sqlDebitos = "SELECT valor_deb, data_venc FROM debito WHERE fk_id_usuario = ?";
$stmtDebitos = $conn->prepare($sqlDebitos);
$stmtDebitos->bind_param("i", $id_usuario);
$stmtDebitos->execute();
$resultDebitos = $stmtDebitos->get_result();

$debitos = [];
while ($row = $resultDebitos->fetch_assoc()) {
    $debitos[] = $row;
}

header('Content-Type: application/json');
echo json_encode($debitos);
?>