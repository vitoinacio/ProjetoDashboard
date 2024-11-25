<?php
require_once "conexao.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ident_deb = htmlspecialchars(trim($_POST["ident_deb"]));
    $obs_deb = htmlspecialchars(trim($_POST["obs_deb"]));
    $valor_deb = str_replace(",", ".", trim(str_replace("R$", "", $_POST["valor_deb"])));
    $data_venc = htmlspecialchars(trim($_POST["data_venc"]));
    $notifi = isset($_POST["notficacao"]) ? intval($_POST["notficacao"]) : 0;
    $id = $_SESSION['id'];

    $stmt = $conn->prepare("INSERT INTO debito (ident_deb, obs_deb, valor_deb, data_venc, notifi, fk_id_usuario) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssis", $ident_deb, $obs_deb, $valor_deb, $data_venc, $notifi, $id);

    if ($stmt->execute()) {
        echo "Débito inserido com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}
?>