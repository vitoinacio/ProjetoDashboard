<?php
session_start();
include_once('conexao.php');
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
    
        // Verificar se o usuário existe no banco de dados
        $sql = "SELECT id, email FROM usuario WHERE email = ? AND cpf = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $cpf);
        $stmt->execute();
        $result = $stmt->get_result();
        print_r($result);

        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $row['id'];
            $_SESSION['cpf'] = $cpf;
            header('Location: ../pages/trocaSenha.php');
        }
        else {
            header('Location: ../pages/2fa.php?errorMessage=Não tem conta com esse email e cpf!');
        }
    }



?>