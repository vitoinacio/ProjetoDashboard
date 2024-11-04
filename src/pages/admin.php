<?php
  session_start();
  include_once('../php/conexao.php');
  print_r($_SESSION['email']);
  if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
  {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: ../../index.html');
  }
  $logado = $_SESSION['email'];

  $sql = "SELECT * FROM usuario ORDER BY id DESC";

  $result = $conexao->query($sql);

//   print_r($result);
  
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style.css" />
    <script
      src="https://kit.fontawesome.com/7414161b6e.js"
      crossorigin="anonymous"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    <script type="module" src="src/js/script.js" defer></script>
    <title>Admin</title>
  </head>
  <body>
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
        <img src="../img/perfil.png" alt="foto-perfil" />
      </div>
    </header>
    <!-- FIM HEADER -->

    <!-- INICIO MAIN -->
    <section class="main">
        <br>
      <div class="listaUsuarios">
        <table style="background-color: rgba(0, 0, 0, 0.3);border-radius: 15px; border: 1px solid; font-size: 14px; margin: 1px; align-items: center; ">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Data Nascimento</th>
                    <th scope="col">Email</th>
                    <th scope="col">Senha</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Cep</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Bairro</th>
                    <th scope="col">Rua</th>
                    <th scope="col">Numero casa</th>
                    <th scope="col">Data Criação</th>
                    <th scope="col">...</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($user_data = mysqli_fetch_assoc($result))
                    {
                        echo "<tr>";
                        echo "<td>" . $user_data['id']."</td>";
                        echo "<td>" . $user_data['nome']."</td>";
                        echo "<td>" . $user_data['sexo']."</td>";
                        echo "<td>" . $user_data['dataNasc']."</td>";
                        echo "<td>" . $user_data['email']."</td>";
                        echo "<td>" . $user_data['senha']."</td>";
                        echo "<td>" . $user_data['cpf']."</td>";
                        echo "<td>" . $user_data['tel']."</td>";
                        echo "<td>" . $user_data['cep']."</td>";
                        echo "<td>" . $user_data['cidade']."</td>";
                        echo "<td>" . $user_data['bairro']."</td>";
                        echo "<td>" . $user_data['rua']."</td>";
                        echo "<td>" . $user_data['numeroCasa']."</td>";
                        echo "<td>" . $user_data['dtCriacao']."</td>";
                        echo "<td>Acões</td>";
                        echo "</tr>";
                    }
                ?>

            </tbody>
        </table>
      </div>
    </section>
    <!-- FIM MAIN -->
  </body>
</html>