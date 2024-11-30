<?php

    include_once('../php/conexao.php');

    if(isset($_POST['update']))
    {
        $id = $_POST["id"];
        $nome = $_POST["nome"];
        $sexo = $_POST["sexo"];
        $dataNasc = $_POST["dataNasc"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $cpf = $_POST["cpf"];
        $tel = $_POST["tel"];
        $cep = $_POST["cep"];
        $cidade = $_POST["cidade"];
        $bairro = $_POST["bairro"];
        $rua = $_POST["rua"];
        $numeroCasa = $_POST["numeroCasa"];

        $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

        $sqlUpdate = "UPDATE usuario SET nome = '$nome', senha ='$senha', dataNasc = '$dataNasc', email = '$email', senha = '$senha_criptografada',
        cpf = '$cpf', tel = '$tel', cep = '$cep', cidade = '$cidade', bairro = '$bairro', rua = '$rua', numeroCasa = '$numeroCasa'
        WHERE id = '$id'";

        $result = $conn->query($sqlUpdate);
        header('Location: user.php');
    }
    else
    {
        header('Location: user.php');
    }


?>