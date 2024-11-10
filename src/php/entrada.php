<?php
require_once "conexao.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST["entradaSalario"])) {
        $entradaSalario = htmlspecialchars(trim($_POST["entradaSalario"]));
        $entradaSalaraio = str_replace(",",".", $entradaSalario); //Converte a virgula para ponto decimal

        $stmt = $conn->prepare("INSERT INTO ent_financeira (valor_ent) VALUES (?)");
        $stmt->bind_param("s", $entradaSalario);
        
        if ($stmt->execute()) {
            echo "Valor inserido com sucesso!";
        } else {
            echo "Erro: " . $stmt->error;
        }
        $stmt ->close();
    }
}

