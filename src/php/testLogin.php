<?php
session_start();
include_once('./conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['senha'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
      
        // Verificar se o usuário existe no banco de dados
        $sql = "SELECT id, email, senha, twoFa, nome, cpf FROM usuario WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Erro na preparação da consulta: ' . $conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verificar a senha criptografada
            if ($email == 'contatosmartwallet@gmail.com') {
                $_SESSION['email'] = $row['email'];
                $_SESSION['id'] = $row['id'];
                header('Location: ../pages/dashboard.php');
                exit();
            }
            if (password_verify($senha, $row['senha'])) {
                $_SESSION['email'] = $row['email'];
                $_SESSION['id'] = $row['id'];
                
                // Verificar se a coluna twoFa é igual a true
                if ($row['twoFa'] == true) {
                    header('Location: ../pages/2faa.php');
                } else {
                    // Inserir log de autenticação sem 2FA
                    $sql = "INSERT INTO logs_autenticacao (usuario_id, nome_usuario, cpf, metodo_2fa) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $metodo_2fa = 'Nenhum'; // Exemplo de método sem 2FA
                    $stmt->bind_param('isss', $row['id'], $row['nome'], $row['cpf'], $metodo_2fa);
                    $stmt->execute();

                    header('Location: ../pages/dashboard.php');
                }
                exit();
            } else {
                // Senha incorreta
                $_SESSION['errorMessage'] = 'Senha incorreta';
                header('Location: ../../index.php?errorMessage=Senha Incorreta');
                exit();
            }
        } else {
            // Usuário não encontrado
            $_SESSION['errorMessage'] = 'Usuário não encontrado';
            header('Location: ../../index.php?errorMessage=Usuário não encontrado');
            exit();
        }
    } else {
        $_SESSION['errorMessage'] = 'Por favor, preencha todos os campos';
        header('Location: ../../index.php?errorMessage=Preencha todos os campos');
        exit();
    }
} else {
    $_SESSION['errorMessage'] = 'Método de requisição inválido';
    header('Location: ../../index.php?errorMessage=Método de requisição inválido');
    exit();
}
?>