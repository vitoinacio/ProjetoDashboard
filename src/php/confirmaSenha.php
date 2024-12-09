<?php
session_start();
include_once('../php/conexao.php');

if (isset($_POST['update'])) {
    $email = $_SESSION['email'];
    $senha = $_POST["senha"];
    $confirmaSenha = $_POST["confirmSenha"];

    // Verificar se a senha e a confirmação da senha são iguais
    if ($senha === $confirmaSenha) {
        // Hash da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Buscar o ID do usuário com base no email
        $sqlSelect = "SELECT id FROM usuario WHERE email = ?";
        $stmt = $conn->prepare($sqlSelect);
        if ($stmt === false) {
            die('Erro na preparação da consulta: ' . $conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $id = $row['id'];

        // Atualizar a senha no banco de dados
        $sqlUpdate = "UPDATE usuario SET senha = ? WHERE id = ?";
        $stmt = $conn->prepare($sqlUpdate);
        if ($stmt === false) {
            die('Erro na preparação da consulta: ' . $conn->error);
        }
        $stmt->bind_param("si", $senhaHash, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['errorMessage'] = 'Senha atualizada com sucesso';
            header('Location: ../../index.php?errorMessage=Senha atualizada com sucesso');
            exit();
        } else {
            $_SESSION['errorMessage'] = 'Erro ao atualizar a senha. Nenhuma linha foi afetada.';
            header('Location: ../pages/trocaSenha.php');
            exit();
        }
    } else {
        $_SESSION['errorMessage'] = 'As senhas não coincidem';
        header('Location: ../pages/trocaSenha.php');
        exit();
    }
} else {
    $_SESSION['errorMessage'] = 'Erro ao atualizar senha';
    header('Location: ../pages/trocaSenha.php');
    exit();
}
?>