<?php
session_start();
include_once('conexao.php');

// Inicializa a variável de tentativas na sessão, se não estiver definida
if (!isset($_SESSION['tentativas'])) {
    $_SESSION['tentativas'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $cpf = isset($_POST['cpf']) ? preg_replace('/\D/', '', $_POST['cpf']) : null;
    $dataNasc = isset($_POST['dataNasc']) ? $_POST['dataNasc'] : null;
    $cep = isset($_POST['cep']) ? preg_replace('/\D/', '', $_POST['cep']) : null;

    // Construir a consulta SQL dinamicamente
    $sql = "SELECT * FROM usuario WHERE email = ?";
    $params = [$email];
    $types = "s";

    if ($cpf) {
        $sql .= " AND cpf = ?";
        $params[] = $cpf;
        $types .= "s";
    }
    if ($dataNasc) {
        $sql .= " AND dataNasc = ?";
        $params[] = $dataNasc;
        $types .= "s";
    }
    if ($cep) {
        $sql .= " AND cep = ?";
        $params[] = $cep;
        $types .= "s";
    }

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $row['id'];
        $_SESSION['tentativas'] = 0; // Resetar tentativas em caso de sucesso
        header('Location:../pages/dashboard.php');
    } else {
        $_SESSION['tentativas'] += 1;
        if ($_SESSION['tentativas'] >= 3) {
            $_SESSION['tentativas'] = 0; // Resetar tentativas após redirecionamento
            session_destroy(); // Destruir a sessão
            header('Location: ../../index.php?errorMessage=Maximo de tentativa excedida');
            exit();
        } else {
            header('Location:../pages/2fa.php');
        }
    }
}
?>