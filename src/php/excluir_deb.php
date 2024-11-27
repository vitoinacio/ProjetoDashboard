<?php
require 'conexao.php';
session_start();

// Verificar se o ID foi passado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if(isset($_POST['id_deb'])) {
    $id = $_SESSION['id'];
    $id_deb = $_POST['id_deb'];

    // Preparar a declaração SQL para excluir o registro
    $sql = "DELETE FROM debito WHERE id_deb = ? AND fk_id_usuario = ?";

    // Preparar a declaração
    if ($stmt = $conn->prepare($sql)) {
        // Vincular parâmetros
        $stmt->bind_param("ii", $id_deb, $id);

        // Executar a declaração
        if ($stmt->execute()) {
            echo "Registro excluído com sucesso.";
        } else {
            echo "Erro ao excluir o registro: " . $stmt->error;
        }

        // Fechar a declaração
        $stmt->close();
    } else {
        echo "Erro ao preparar a declaração: " . $conn->error;
    }
} else {
    echo "ID não fornecido.";
}

}
require_once "enviar_notificacoes.php";
// Fechar a conexão
$conn->close();
?>