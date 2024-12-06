<?php
session_start();
require_once '../php/conexao.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['id']) || $_SESSION['email'] != 'contatosmartwallet@gmail.com') {
    header('Location: ../../index.php?errorMessage=Acesso negado');
    exit();
}

$logado = $_SESSION['email'];
$id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'todos';

$sql = "SELECT * FROM logs_autenticacao WHERE 1=1";

if ($filter == 'nome') {
    $sql .= " AND nome_usuario LIKE ?";
    $param = "%$search%";
} elseif ($filter == 'cpf') {
    $sql .= " AND cpf LIKE ?";
    $param = "%$search%";
} else {
    $param = "%$search%";
    $sql .= " AND (nome_usuario LIKE ? OR cpf LIKE ?)";
}

$sql .= " ORDER BY data_hora DESC";

$stmt = $conn->prepare($sql);
if ($filter == 'todos') {
    $stmt->bind_param('ss', $param, $param);
} else {
    $stmt->bind_param('s', $param);
}
$stmt->execute();
$result = $stmt->get_result();

function buscarDadosUsuario($conn, $id) {
  $sql = "SELECT * FROM usuario WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  return $row ? $row : null;
}

$dadosUsuario = buscarDadosUsuario($conn, $id);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/7414161b6e.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/style.css" />
  <title>Logs de Autenticação</title>
</head>
<body style="overflow-x: hidden;">
    <!-- INICIO HEADER -->
    <header>
      <div class="info-header">
        <div class="logo">
          <h3>SmartWallet</h3>
        </div>
      </div>
      <div class="info-header">
        <i class="fa-solid fa-bell"></i>
        <i class="fa-solid fa-gear"></i>
        <img id="fotoPerfil" src="<?php echo $dadosUsuario['foto'] ? 'data:image/jpeg;base64,' . base64_encode($dadosUsuario['foto']) : '../img/perfil.jpg'; ?>" alt="Foto de Perfil">
      </div>
    </header>
    <!-- FIM HEADER -->

    <!-- INICIO MAIN -->
    <div style="display: flex; width: 100%; justify-content:space-between; padding: 10px; margin:20px;">
      <a href="../pages/admin.php" style="border: solid 0.5px #121d77; padding: 8px; flex: 10%; text-align:center;">Voltar</a>
      <br>
      <div class="box-search" style="justify-content: center; display:flex; gap:.1%; flex: 90%;">
      <form method="GET" action="logs_autenticacao.php" style="display:flex; width: 80%;">
        <input type="search" style="flex: 60%;" class="form-control w-25" placeholder="Buscar" id="pesquisar" name="search" value="<?php echo htmlspecialchars($search); ?>">
        <select name="filter" style="flex: 10%;" class="form-control w-25">
            <option value="todos" <?php echo $filter == 'todos' ? 'selected' : ''; ?>>Todos</option>
            <option value="nome" <?php echo $filter == 'nome' ? 'selected' : ''; ?>>Nome</option>
            <option value="cpf" <?php echo $filter == 'cpf' ? 'selected' : ''; ?>>CPF</option>
        </select>
        <button type="submit" class="btn btn-primary">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
          </svg>
        </button>
      </form>
      </div>
    </div>

    <h2 style="width: 100%; text-align:center">Logs de Autenticação</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Data e Hora</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Método 2FA</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo date('d/m/Y H:i:s', strtotime($row['data_hora'])); ?></td>
                    <td><?php echo htmlspecialchars($row['nome_usuario']); ?></td>
                    <td><?php echo htmlspecialchars(substr($row['cpf'], 0, 3) . '.***.***-' . substr($row['cpf'], -2)); ?></td>
                    <td><?php echo htmlspecialchars($row['metodo_2fa']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>