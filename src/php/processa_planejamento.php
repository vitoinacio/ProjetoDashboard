<?php
require_once "conexao.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['data'][] = 
    $ident_deb = htmlspecialchars(trim($_POST["ident_deb"]));
    $obs_deb = htmlspecialchars(trim($_POST["obs_deb"]));
    $valor_deb = str_replace(",", ".", trim(str_replace("R$", "", $_POST["valor_deb"])));
    $data_venc = htmlspecialchars(trim($_POST["data_venc"]));
    $notifi = intval(htmlspecialchars(trim($_POST["notficacao"])))
    ;

    $stmt = $conn->prepare("INSERT INTO debito (ident_deb, obs_deb, valor_deb, data_venc, notifi) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdi", $ident_deb, $obs_deb, $valor_deb, $data_venc, $notifi);

    if ($stmt->execute()) {
        echo "Débito inseridos com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }
}

     $stmt->close();
?>
