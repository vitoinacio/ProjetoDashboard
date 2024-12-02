<?php
require_once "conexao.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $allowedFields = ['nome', 'email', 'dataNasc', 'tel', 'senha', 'cep', 'cidade', 'bairro', 'rua', 'numeroCasa']; // Campos permitidos para atualização
    $updates = [];

    foreach ($allowedFields as $field) {
        if (isset($_POST[$field])) {
            $value = htmlspecialchars(trim($_POST[$field]));
            if ($field === 'senha') {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }
            $updates[$field] = $value;
        }
    }

    // Verifica se há um arquivo de foto enviado
    if (isset($_FILES["fotoPerfilInput"]) && $_FILES["fotoPerfilInput"]["error"] == UPLOAD_ERR_OK) {
        $foto = $_FILES["fotoPerfilInput"];
        $fotoData = file_get_contents($foto["tmp_name"]);

        // Adiciona os dados binários da foto ao array de atualizações
        $updates['foto'] = $fotoData;
    }

    if (!empty($updates)) {
        $setClause = [];
        $params = [];
        $types = '';

        foreach ($updates as $field => $value) {
            $setClause[] = "$field = ?";
            $params[] = $value;
            $types .= ($field === 'foto') ? 'b' : 's'; // 'b' para BLOB, 's' para string
        }

        $params[] = $id;
        $types .= 'i';

        $sql = "UPDATE usuario SET " . implode(', ', $setClause) . " WHERE id = ?";
        $stmt = $conn->prepare($sql);

        // Vincula os parâmetros, incluindo o BLOB
        $stmt->bind_param($types, ...$params);

        // Vincula o BLOB separadamente
        if (isset($updates['foto'])) {
            $stmt->send_long_data(array_search('foto', array_keys($updates)), $updates['foto']);
        }

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Erro ao atualizar o banco de dados: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Nenhum campo válido para atualizar.";
    }
}
?>