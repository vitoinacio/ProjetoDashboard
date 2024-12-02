<?php
session_start();
include_once('./conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se o usuário existe no banco de dados
    $sql = "SELECT id, email, senha FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verificar a senha criptografada
        if (password_verify($senha, $row['senha'])) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['id'] = $row['id'];
            echo "Login bem-sucedido! Redirecionando...";
            header('Location: ../pages/dashboard.php');
            exit();
        } else {
            // Senha incorreta
            echo "Senha incorreta!";
            header('Location: ../../index.php?errorMessage=Senha incorreta!');
            exit();
        }
    } else {
        // Usuário não encontrado
        echo "Usuário não encontrado!";
        header('Location: ../../index.php?errorMessage=Usuário não encontrado!');
        exit();
    }
}
?>