<?php
    include_once('../php/conexao.php');

    if(isset($_POST['update']))
    {
        $id = $_POST["id"];
        $senha = $_POST["senha"];
        print_r($id);
        print_r($senha);

         $sqlUpdate = "UPDATE usuario SET senha ='$senha' WHERE id = '$id'";
         $result = $conn->query($sqlUpdate);
         header('Location: ../../index.php?errorMessage=Atualizado com sucesso');
    }
    else
    {
        echo 'Erro ao atualizar';
        // print_r($id);
        // print_r($senha);
    }
    ?>
         
        