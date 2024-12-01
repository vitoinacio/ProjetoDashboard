<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css" />
  <script src="https://kit.fontawesome.com/7414161b6e.js" crossorigin="anonymous"></script>
  <script type="module" src="../js/script.js" defer></script>
  <title>Troca de Senha</title>
</head>

<body style="overflow-x: hidden;">
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
        <div class="form-cadastro pessoais">
            <form class="formInfoPessoais" method="post" action="../php/test2fa.php">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="text" name="cpf" id="cpf" placeholder="CPF"  minlength="14" maxlength="14" required>
                <br>
                <div class="btn">
                    <button type="submit" id="btnCadastro">Enviar</button>
                </div>
            </form>
        </div>
    </div>