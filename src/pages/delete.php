<?php
    if(!empty($_GET['id']))
    {
        include_once('../php/conexao.php');

        $id = $_GET['id'];

        $sqlSelect = "SELECT * FROM usuario where id = $id";

        $result = $conn->query($sqlSelect);

        if($result->num_rows > 0)
        {
        while($user_data = mysqli_fetch_assoc($result))
            {
                $sqlDelete = "DELETE FROM usuario WHERE id = $id";
                $resultDelete = $conn->query($sqlDelete);
            }
        }
    }
    header('Location: admin.php')   
?>