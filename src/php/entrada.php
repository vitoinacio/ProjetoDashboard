<?php
require_once "conexao.php";
session_start();
print_r($_SESSION['email']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST["entradaSalario"])) {
        $id = $_SESSION['id'];
        $entradaSalario = htmlspecialchars(trim($_POST["entradaSalario"]));
        $entradaSalaraio = str_replace(",",".", $entradaSalario); //Converte a virgula para ponto decimal

        $stmt = $conn->prepare("INSERT INTO ent_financeira (valor_ent, fk_id_usuario ) VALUES (?,?)");
        $stmt->bind_param("si", $entradaSalario, $id);
        
        if ($stmt->execute()) {
            echo "Valor inserido com sucesso!";
        } else {
            echo "Erro: " . $stmt->error;
        }
        $stmt ->close();
    }
}

