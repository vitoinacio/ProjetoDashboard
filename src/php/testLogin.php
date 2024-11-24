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
            $row = $result->fetch_assoc();

            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['senha'] = $row['senha'];
            $logado = $_SESSION['email'];
            if($row['adm'] == 1)
            {
                header('Location: ../pages/admin.php');
            }
            else
            header('Location: ../pages/dashboard.php');
        }
        elseif(mysqli_num_rows($result) < 1)
        {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            unset($_SESSION['id']);
            header('location: ../../index.php?errorMessage=Ocorreu um erro ao fazer o login! por favor, tente novamente.');
        }
    
    else
    {
        //Não Acessa
        header('Location:../../index.php?errorMessage=Ocorreu um erro ao fazer o login! por favor, tente novamente.');
    }
}
?>
