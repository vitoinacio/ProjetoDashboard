<?php
session_start();
include_once('../php/conexao.php');
if ($_SESSION['email'] !== null) {
  $emailComplete = $_SESSION['email'];
};
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css" />
  <script src="https://kit.fontawesome.com/7414161b6e.js" crossorigin="anonymous"></script>
  <title>Autenticação</title>
  <style>
    body{
      overflow-x: hidden;
      display: flex;
      flex-direction: column;
      align-items: center;  
    }

    .container-cadastro {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 70vh;
      width: 500px;
      box-shadow: none;
      margin-left: 100px;
    }

    .title{
      display: flex;
      margin-right: 100px;
      margin-bottom: 20px;
      color: #121d77;
    }

    .formInfoPessoais{
      display: flex;
      flex-direction: column;
      width: 400px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.7);
      padding: 40px;
      gap: 10px;
      border-radius: 2px;
    }
  </style>
</head>

<body>
  <!-- INICIO HEADER -->
  <header class="header-nav cadastro-header">
    <div class="logo-nav">
      <h2>
        <i class="fa-solid fa-chart-line"></i>Smart<strong>Wallet</strong>
      </h2>
    </div>
  </header>
    <!-- FIM HEADER -->
    <!-- INICIO MAIN -->
    <div class="container-cadastro">
      <h2 class="title">Preencha os campos abaixo</h2>
        <div class="form-cadastro pessoais" style="width: 500px;">
            <form class="formInfoPessoais" method="post" action="../php/test2faa.php">
                <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $emailComplete?>" required>
                <?php
                $pergunta = rand(1, 3);
                if ($pergunta == 1) {
                    echo '<p style="margin-top: 5px;">Qual sua data de nascimento?</p>';
                    echo '<input type="date" name="dataNasc" id="dataNasc">';
                } else if ($pergunta == 2) {
                    echo '<p style="margin-top: 5px;">Qual seu CEP?</p>';
                    echo '<input type="text" name="cep" id="cep" placeholder="CEP">';
                } else {
                    echo '<p style="margin-top: 5px;">Qual seu CPF?</p>';
                    echo '<input type="text" name="cpf" id="cpf" placeholder="CPF">';
                }

                ?>
                <script>
                  const form = document.querySelector('.formInfoPessoais');
                  const input = form[1];

                  // Função para aplicar máscara de CPF
                  function maskCPF(value) {
                    return value
                      .replace(/\D/g, '') // Remove caracteres não numéricos
                      .replace(/(\d{3})(\d)/, '$1.$2') // Adiciona ponto após os primeiros 3 dígitos
                      .replace(/(\d{3})(\d)/, '$1.$2') // Adiciona ponto após os próximos 3 dígitos
                      .replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Adiciona hífen antes dos últimos 2 dígitos
                  }

                  // Função para aplicar máscara de CEP
                  function maskCEP(value) {
                    return value
                      .replace(/\D/g, '') // Remove caracteres não numéricos
                      .replace(/(\d{5})(\d)/, '$1-$2'); // Adiciona hífen após os primeiros 5 dígitos
                  }

                  // Adiciona evento de input para aplicar a máscara
                  document.getElementById('cpf')?.addEventListener('input', function (e) {
                    e.target.value = maskCPF(e.target.value);
                  });

                  document.getElementById('cep')?.addEventListener('input', function (e) {
                    e.target.value = maskCEP(e.target.value);
                  });
    
                </script>
                <br>
                <div class="btn">
                    <button type="submit" id="btnCadastro">Enviar</button>
                </div>
            </form>
        </div>
    </div>