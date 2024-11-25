<?php
require_once "conexao.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $allowedFields = ['nome', 'email', 'senha', 'data_nascimento']; // Campos permitidos para atualização
    $updates = [];

    foreach ($allowedFields as $field) {
        if (isset($_POST[$field])) {
            $value = htmlspecialchars(trim($_POST[$field]));
            $updates[$field] = $value;
        }
    }

    // Verifica se há um arquivo de foto enviado
    if (isset($_FILES["fotoPerfilInput"]) && $_FILES["fotoPerfilInput"]["error"] == UPLOAD_ERR_OK) {
        $foto = $_FILES["fotoPerfilInput"];
        $uploadDir = "../uploads/";
        $uploadFile = $uploadDir . basename($foto["name"]);

        // Verifica se o arquivo é uma imagem
        $check = getimagesize($foto["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($foto["tmp_name"], $uploadFile)) {
                $updates['foto'] = $uploadFile;
            } else {
                echo "error";
                exit();
            }
        } else {
            echo "error";
            exit();
        }
    }

    if (!empty($updates)) {
        $setClause = [];
        $params = [];
        $types = '';

        foreach ($updates as $field => $value) {
            $setClause[] = "$field = ?";
            $params[] = $value;
            $types .= 's'; // Assumindo que todos os campos são strings
        }

        $params[] = $id;
        $types .= 'i';

        $sql = "UPDATE usuario SET " . implode(', ', $setClause) . " WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }

        $stmt->close();
    } else {
        echo "No valid fields to update";
    }
}
?>