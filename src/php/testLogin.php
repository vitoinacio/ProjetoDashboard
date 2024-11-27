<?php
session_start();
include_once('./conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se o usuário existe no banco de dados
    $sql = "SELECT id, email FROM usuario WHERE email = ? AND senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['senha'] = $senha; // Adicionando senha na sessão para verificação
        header('Location: ../pages/dashboard.php');
        exit();
    } else {
        // Usuário não encontrado ou senha incorreta
        header('Location: ../../index.php');
        exit();
    }
}
?>