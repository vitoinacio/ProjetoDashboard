<?php
require_once "conexao.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ident_deb = htmlspecialchars(trim($_POST["ident_deb"]));
    $obs_deb = htmlspecialchars(trim($_POST["obs_deb"]));
    $valor_deb = str_replace(",", ".", trim(str_replace("R$", "", $_POST["valor_deb"])));
    $data_venc = htmlspecialchars(trim($_POST["data_venc"]));
    $notifi = intval(htmlspecialchars(trim($_POST["notficacao"])));
    $id = $_SESSION['id'];


    $stmt = $conn->prepare("INSERT INTO debito (ident_deb, obs_deb, valor_deb, data_venc, notifi, fk_id_usuario) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $ident_deb, $obs_deb, $valor_deb, $data_venc, $notifi, $id);

    if ($stmt->execute()) {
        echo "Débito inserido com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}
?>