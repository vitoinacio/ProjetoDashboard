<!-- Tabela de Exibição de Dados -->
<?php
    require_once "conexao.php";

    // Inserindo dados
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ident_deb = htmlspecialchars(trim($_POST["ident_deb"]));
        $obs_deb = htmlspecialchars(trim($_POST["obs_deb"]));
        $valor_deb = str_replace(",", ".", trim(str_replace("R$", "", $_POST["valor_deb"])));
        $data_venc = htmlspecialchars(trim($_POST["data_venc"]));
        $notifi = intval(htmlspecialchars(trim($_POST["notficacao"])));

        $stmt = $conn->prepare("INSERT INTO debito (ident_deb, obs_deb, valor_deb, data_venc, notifi) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdi", $ident_deb, $obs_deb, $valor_deb, $data_venc, $notifi);

        if (!$stmt->execute()) {
            echo "Erro: " . $stmt->error;
        }
        $stmt->close();
        
        header("Location: ../pages/planejamento.php");
        exit();

        
    }

    