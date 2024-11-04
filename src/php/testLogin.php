<?php
    session_start();
    // print_r($_REQUEST)
    if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha']))
    {
        //Acessa
        include_once('conexao.php');
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // print_r('Email: ' . $email);
        // print_r('Senha: ' . $senha);
        $sql = "SELECT * FROM usuario WHERE email = '$email' and senha = '$senha'";

        $result = $conn->query($sql);

        // print_r($result);
        
        if(mysqli_num_rows($result) > 0)
        {
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            $logado = $_SESSION['email'];
            header('Location: ../pages/planejamento.php');
        }
        elseif(mysqli_num_rows($result) < 1)
        {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('location: ../../index.html');
        }
    }
    else
    {
        //Não Acessa
        header('Location:../../index.html');
    }
?>