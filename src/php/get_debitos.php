<?php
require_once "conexao.php";
session_start();

$id_usuario = $_SESSION['id'];

$sql = "SELECT valor_deb, data_venc FROM debito WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

$debitos = [];
while ($row = $result->fetch_assoc()) {
    $debitos[] = $row;
}

echo json_encode($debitos);
?>