<?php

session_start();
include_once('../php/conexao.php');

if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: ../../index.php');
    exit();
}

$logado = $_SESSION['email'];
$id = $_SESSION['id'];

// Função para buscar os dados do usuário no banco de dados
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
$nome = explode(' ', $dadosUsuario['nome'])[0] . ' ' . explode(' ', $dadosUsuario['nome'])[1];
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
  <script type="module" src="../js/script.js" defer></script>
  <title>User</title>
</head>

<body>
  <!-- INICIO HEADER -->
  <header>
    <div class="info-header">
      <div class="logo">
        <div class="contentMenuMobile">
          <span class="menuMobile"></span>
          <span class="menuMobile"></span>
          <span class="menuMobile"></span>
        </div>
        <h3><a href="../../index.php" style="text-decoration: none; color: inherit;">SmartWallet</a></h3>
      </div>
    </div>
    <div class="info-header">
      <a href="notificacoes.php"><i class="fa-solid fa-bell"></i></a>
      <a href="config.php"><i class="fa-solid fa-gear"></i></a>
      <div class="dropdown-menu">
        <div class="perfil-menu">
        <img id="fotoPerfil" src="<?php echo $dadosUsuario['foto'] ? 'data:image/jpeg;base64,' . base64_encode($dadosUsuario['foto']) : '../img/perfil.jpg'; ?>" alt="Foto de Perfil">
          <div class="info-perfil">
          <h4 id="NomeUsuario"><?php print_r($nome)?></h4>
          </div>
        </div>
        <hr>
        <div class="logout">
        <img id="fotoPerfil" src="<?php echo $dadosUsuario['foto'] ? 'data:image/jpeg;base64,' . base64_encode($dadosUsuario['foto']) : '../img/perfil.jpg'; ?>" alt="Foto de Perfil">
          <div class="login">
            <p>Logado como:</p>
            <h5><?php print_r($_SESSION['email'])?></h5>
          </div>
          <div class="buttons-menu">
            <Button><a href="config.php"><i class="fa-solid fa-gear"></i></a></Button>
            <button><a href="../php/sair.php"><i class="fa-solid fa-power-off"></i></a></button>
          </div>
        </div>
      </div>
      <img id="fotoPerfil" class="menu-config" src="<?php echo $dadosUsuario['foto'] ? 'data:image/jpeg;base64,' . base64_encode($dadosUsuario['foto']) : '../img/perfil.jpg'; ?>" alt="Foto de Perfil">
    </div>
  </header>
  <!-- FIM HEADER -->

  <!-- INICIO MAIN -->
  <section class="main">
    <!-- SIDEBAR -->
    <div class="sidebar">
      <h3>Home</h3>
      <a href="dashboard.php">
        <i class="fa-solid fa-chart-line"></i> Dashboard</a>
      <a href="planejamento.php"><i class="fa-solid fa-clipboard-list"></i> Planejamento</a>
      <a href="user.php"><i class="fa-regular fa-circle-user"></i> User</a>
      <?php if ($dadosUsuario['email'] == "contatossmartwallet@gmail.com"): ?>
          <a href="admin.php"><i class="fa-solid fa-user-cog"></i> Admin</a>
        <?php endif; ?>
      <a href="config.php" class="mobile"><i class="fa-solid fa-gear"></i> Configurações</a>
      <a href="notificacoes.php" class="mobile"><i class="fa-solid fa-bell"></i> Notficações</a>
      <a href="../php/sair.php" class="mobile"><i class="fa-solid fa-power-off"></i> Logout</a>
      <hr />
    </div>
    <!-- CONTENT -->
    <div class="content user">
      <div class="userPerfil">
      <img id="fotoPerfil" src="<?php echo $dadosUsuario['foto'] ? 'data:image/jpeg;base64,' . base64_encode($dadosUsuario['foto']) : '../img/perfil.jpg'; ?>" alt="Foto de Perfil">
        <label class="labelFotoPerfil" for="fotoPerfilInput">Editar foto <i class="fa-solid fa-user-plus"></i></label>
        <input type="file" id="fotoPerfilInput" name="fotoPerfilInput" accept="image/*" placeholder="">
      </div>
      <div class="userInfo">
        <div class="tituloUser">
          <h2>Perfil</h2><a href="editUser.php?id=<?php echo $_SESSION['id']; ?>" class="editUser"><i class="fa-solid fa-pen"></i></a>
        </div>
        <form id="userForm" class="formUser" onsubmit="event.preventDefault()">
          <label for="name">Nome:
            <div>
            <input disabled type="text" id="nome" name="nome" minlength="10" maxlength="50" value="<?php echo htmlspecialchars($dadosUsuario['nome']); ?>">
              <button class="editUser"><i class="fa-solid fa-pen"></i></button>
              <button class="cancelEdit"><i class="fa-solid fa-xmark"></i></button>
              <button class="confirmUser"><i class="fa-solid fa-check"></i></button>
            </div>
          </label>
          <label for="cpf">Cpf:
            <div><input disabled type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($dadosUsuario['cpf']); ?>"></div>
          </label>
          <label for="emailUser">Email:
            <div>
              <input disabled type="email" id="emailUser" name="email" value="<?php echo htmlspecialchars($dadosUsuario['email']); ?>">
              <button class="editUser"><i class="fa-solid fa-pen"></i></button>
              <button class="cancelEdit"><i class="fa-solid fa-xmark"></i></button>
              <button class="confirmUser"> <i class="fa-solid fa-check"></i></button>
            </div>
          </label>
          <label for="nascimento">Nascimento:
            <div>
              <input disabled type="text" id="dataNasc" name="dataNasc" minlength="10" maxlength="10" oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{2})(\d)/, '$1/$2').replace(/(\d{2})(\d)/, '$1/$2').slice(0, 10)" value="<?php 
                $dataNasc = DateTime::createFromFormat('Y-m-d', $dadosUsuario['dataNasc']);
                echo htmlspecialchars($dataNasc ? $dataNasc->format('d/m/Y')  : 'Data inválida'); 
              ?>">
              <button class="editUser"><i class="fa-solid fa-pen"></i></button>
              <button class="cancelEdit"><i class="fa-solid fa-xmark"></i></button>
              <button class="confirmUser"><i class="fa-solid fa-check"></i></button>
            </div>
          </label>
          <label for="sexo">Sexo:
            <div>
              <input disabled type="text" id="sexo" name="sexo" value="<?php echo htmlspecialchars($dadosUsuario['sexo']); ?>">
            </div>
          </label>
          <label for="telefone">Telefone:
            <div>
              <input disabled type="text" id="telefone" name="tel" value="<?php echo htmlspecialchars($dadosUsuario['tel']); ?>">
              <button class="editUser"><i class="fa-solid fa-pen"></i></button>
              <button class="cancelEdit"><i class="fa-solid fa-xmark"></i></button>
              <button class="confirmUser"> <i class="fa-solid fa-check"></i></button>
            </div>
          </label>
          <label for="Senha">Senha:
            <div>
              <input disabled type="password" name="senha" id="senha" value="<?php echo htmlspecialchars($dadosUsuario['senha']); ?>">
              <button class="editUser"><i class="fa-solid fa-pen"></i></button>
              <button class="cancelEdit"><i class="fa-solid fa-xmark"></i></button>
              <button class="confirmUser"> <i class="fa-solid fa-check"></i></button>
            </div>
          </label>
          <label for="cep">Cep:
            <div>
              <input disabled type="text" id="cep" name="cep" value="<?php echo htmlspecialchars($dadosUsuario['cep']); ?>">
              <button class="editUser"><i class="fa-solid fa-pen"></i></button>
              <button class="cancelEdit"><i class="fa-solid fa-xmark"></i></button>
              <button class="confirmUser"> <i class="fa-solid fa-check"></i></button>
            </div>
          </label>
          <label for="cidade">Cidade:
            <div>
              <input disabled type="text" id="cidade" name="cidade" value="<?php echo htmlspecialchars($dadosUsuario['cidade']); ?>">
              <button class="editUser"><i class="fa-solid fa-pen"></i></button>
              <button class="cancelEdit"><i class="fa-solid fa-xmark"></i></button>
              <button class="confirmUser"><i class="fa-solid fa-check"></i></button>
            </div>
          </label>
          <label for="bairro">Bairro:
            <div>
              <input disabled type="text" id="bairro" name="bairro" value="<?php echo htmlspecialchars($dadosUsuario['bairro']); ?>">
              <button class="editUser"><i class="fa-solid fa-pen"></i></button>
              <button class="cancelEdit"><i class="fa-solid fa-xmark"></i></button>
              <button class="confirmUser"><i class="fa-solid fa-check"></i></button>
            </div>
          </label>
          <label for="rua">Rua:
            <div>
              <input disabled type="text" id="rua" name="rua" value="<?php echo htmlspecialchars($dadosUsuario['rua']); ?>">
              <button class="editUser"><i class="fa-solid fa-pen"></i></button>
              <button class="cancelEdit"><i class="fa-solid fa-xmark"></i></button>
              <button class="confirmUser"> <i class="fa-solid fa-check"></i></button>
            </div>
          </label>
          <label for="numero">Número:
            <div>
              <input disabled type="text" id="endNum" name="numeroCasa" value="<?php echo htmlspecialchars($dadosUsuario['numeroCasa']); ?>">
              <button class="editUser"><i class="fa-solid fa-pen"></i></button>
              <button class="cancelEdit"><i class="fa-solid fa-xmark"></i></button>
              <button class="confirmUser"><i class="fa-solid fa-check"></i></button>
            </div>
          </label>
        </form>
      </div>
    </div>
  </section>
  <!-- FIM MAIN -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.editUser');
    const cancelButtons = document.querySelectorAll('.cancelEdit');
    const confirmButtons = document.querySelectorAll('.confirmUser');
    const fotoInput = document.getElementById('fotoPerfilInput');
    const form = document.getElementById('userForm');
    const inputs = document.querySelectorAll('#userForm input');
    let originalValues = {};

        // Armazena os valores originais dos inputs
        inputs.forEach(input => {
            originalValues[input.name] = input.value;
        });

        // Habilita o campo de entrada para edição
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                input.disabled = false;
                input.style.background = '#fff';
                input.style.outline = '2px solid var(--cor2)';
                input.focus();
                this.style.display = 'none';
                this.nextElementSibling.style.display = 'inline';
                this.nextElementSibling.nextElementSibling.style.display = 'inline';
            });
        });

        // Restaura o valor original do campo de entrada
        cancelButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling.previousElementSibling;
                if (originalValues.hasOwnProperty(input.name)) {
                    input.value = originalValues[input.name];
                }
                input.disabled = true;
                input.style.background = '#e2dfdf';
                input.style.outline = 'none';
                this.style.display = 'none';
                this.nextElementSibling.style.display = 'none';
                this.previousElementSibling.style.display = 'inline';
                if (input.name === 'senha') {
                    input.type = 'password';
                }
            });
        });

        // Envia os dados atualizados para o servido
        confirmButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling.previousElementSibling.previousElementSibling;
                const newValue = input.value;
                if (newValue !== originalValues[input.name]) {
                    fetch('../php/update_user.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `id=<?php echo $id; ?>&${input.name}=${encodeURIComponent(newValue)}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            originalValues[input.name] = newValue;
                            input.disabled = true;
                            input.style.background = '#e2dfdf';
                            input.style.outline = 'none';
                            this.style.display = 'none';
                            this.previousElementSibling.style.display = 'none';
                            this.previousElementSibling.previousElementSibling.style.display = 'inline';
                            if (input.name === 'senha') {
                              input.type = 'password';
                            }
                        } else {
                            console.error('Erro ao atualizar os dados.');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                    });
                } else {
                    input.disabled = true;
                    input.style.background = '#e2dfdf';
                    input.style.outline = 'none';
                    this.style.display = 'none';
                    this.previousElementSibling.style.display = 'none';
                    this.previousElementSibling.previousElementSibling.style.display = 'inline';
                    if (input.name === 'senha') {
                      input.type = 'password';
                    }
                }
            });
        });
        // Envia a foto para o servidor ao selecionar o arquivo
        fotoInput.addEventListener('change', function() {
            const formData = new FormData();
            const fotoFile = fotoInput.files[0];

            if (fotoFile) {
                formData.append('fotoPerfilInput', fotoFile);
                formData.append('id', '<?php echo $id; ?>');

                fetch('../php/update_user.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    if (data === 'success') {
                        // Atualiza a imagem de perfil exibida
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.querySelectorAll('#fotoPerfil').forEach(img => {
                                img.src = e.target.result;
                            });
                        };
                        reader.readAsDataURL(fotoFile);
                        console.log(data);
                    } else {
                        console.error('Erro ao atualizar a foto: ' + data);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
            } else {
                alert('Por favor, selecione uma foto.');
            }
        });
      });
</script>
</body>

</html>