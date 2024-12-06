<?php
session_start();
include_once('../php/conexao.php');

if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
  unset($_SESSION['email']);
  unset($_SESSION['id']);
  header('Location: ../../index.php');
  exit();
}

$logado = $_SESSION['email'];
$id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

if (!empty($_GET['search'])) {
  $data = $_GET['search'];
  $sql = "SELECT * FROM usuario WHERE (id LIKE '%$data%' OR nome LIKE '%$data%' OR email LIKE '%$data%') AND email != 'contatosmartwallet@gmail.com' ORDER BY id DESC";
} else {
  $sql = "SELECT * FROM usuario WHERE email != 'contatosmartwallet@gmail.com' ORDER BY id DESC";
}
$result = $conn->query($sql);

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
  <link rel="stylesheet" href="../css/style.css">
  <script type="module" src="src/js/script.js" defer></script>
  <title>Admin</title>
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
  <div style="display: flex; width: 100%; justify-content:space-between; padding: 10px;">
    <a href="../pages/dashboard.php" style="border: solid 0.5px #121d77; padding: 8px; width: 10%; text-align:center;">Voltar</a>
    <br>
    <div class="box-search" style="justify-content: center; display:flex; gap:.1%; width: 80%;">
      <input type="search" style="width: 40%;" class="form-control w-25" placeholder="Pesquisar" id="pesquisar">
      <button onclick="searchData()" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
        </svg>
      </button>
    </div>
    <a href="../pages/logs_autenticacao.php" style="border: solid 0.5px #121d77; padding: 8px; width: 10%; text-align:center;">Tela de Logs</a>
  </div>
  <section class="main">
    <div class="m-5">
      <table class="table" style="background-color: rgba(0,0,0,0.2); border-radius: 15px 15px 0 0; font-size: 12px; width: 100vw; font-size:11px; margin: 0 0 0 -40px;">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Sexo</th>
            <th scope="col">Data Nascimento</th>
            <th scope="col">Email</th>
            <th scope="col">CPF</th>
            <th scope="col">Telefone</th>
            <th scope="col">CEP</th>
            <th scope="col">Cidade</th>
            <th scope="col">Bairro</th>
            <th scope="col">Rua</th>
            <th scope="col">Numero Casa</th>
            <th scope="col">Data Criação</th>
            <th scope="col">...</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while($user_data = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $user_data['id']."</td>";
            echo "<td>" . $user_data['nome']."</td>";
            echo "<td>" . $user_data['sexo']."</td>";
            echo "<td>" . date('d/m/Y', strtotime($user_data['dataNasc'])) . "</td>";
            echo "<td>" . $user_data['email']."</td>";
            echo "<td>" . $user_data['cpf']."</td>";
            echo "<td>" . $user_data['tel']."</td>";
            echo "<td>" . $user_data['cep']."</td>";
            echo "<td>" . $user_data['cidade']."</td>";
            echo "<td>" . $user_data['bairro']."</td>";
            echo "<td>" . $user_data['rua']."</td>";
            echo "<td>" . $user_data['numeroCasa']."</td>";
            echo "<td>" . $user_data['dtCriacao']."</td>";
            echo "<td>
              <a class='btn btn-sm btn-primary' href='edit.php?id=$user_data[id]'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                  <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325'/>
                </svg>
              </a>
              <a class='btn btn-sm btn-danger' href='delete.php?id=$user_data[id]'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                  <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0'/>
                </svg>
              </a>
            </td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </section>
  <!-- FIM MAIN -->
</body>
<script>
  var search = document.getElementById('pesquisar');

  search.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
      searchData();
    }
  });

  function searchData() {
    window.location = 'admin.php?search=' + search.value;
  }
</script>
</html>