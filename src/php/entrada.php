<?php
require_once "conexao.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST["entradaSalario"])) {
        $entradaSalario = htmlspecialchars(trim($_POST["entradaSalario"]));
        $entradaSalario = str_replace(",", ".", $entradaSalario); // Converte a vírgula para ponto decimal

        // Verifica se o usuário está logado e obtém o ID do usuário
        if (isset($_SESSION['id'])) {
            $idUsuario = $_SESSION['id'];

            // Prepara a consulta para inserir o valor de entrada financeira
            $stmt = $conn->prepare("INSERT INTO ent_financeira (valor_ent, fk_id_usuario) VALUES (?, ?)");
            $stmt->bind_param("si", $entradaSalario, $idUsuario);

            if ($stmt->execute()) {
                echo "Valor inserido com sucesso!";
            } else {
                echo "Erro: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Usuário não está logado.";
        }
    }
}
?>