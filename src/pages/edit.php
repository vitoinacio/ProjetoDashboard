<?php
  if(!empty($_GET['id']))
  {
    include_once('../php/conexao.php');

    $id = $_GET['id'];

    $sqlSelect = "SELECT * FROM usuario where id = $id";

    $result = $conn->query($sqlSelect);

    if($result->num_rows > 0)
    {
      while($user_data = mysqli_fetch_assoc($result))
      {
        $nome = $user_data["nome"];
        $sexo = $user_data["sexo"];
        $dataNasc =$user_data["dataNasc"];
        $email = $user_data["email"];
        $senha = $user_data["senha"];
        $cpf = $user_data["cpf"];
        $tel = $user_data["tel"];
        $cep = $user_data["cep"];
        $cidade = $user_data["cidade"];
        $bairro = $user_data["bairro"];
        $rua = $user_data["rua"];
        $numeroCasa = $user_data["numeroCasa"];
      }
    }
    else
    {
      header('Location:admin.php');
    }
    
  }
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css" />
  <script src="https://kit.fontawesome.com/7414161b6e.js" crossorigin="anonymous"></script>
  <script type="module" src="../js/script.js" defer></script>
  <title>Cadastro</title>
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
  <a href="admin.php" style="border: solid 0.5px gray;">Voltar</a>

  <main class="main-cadastro">
    
    <section class="section-cadastro infoPessoais">
      <div class="container-cadastro">
        <div class="cadastro-progressBar">
          <i class="fa-regular fa-address-book"></i>
          
          <i class="fa-regular fa-address-card"></i>
        </div>
        <form class="formInfoPessoais" action="saveEdit.php" method="post">
          <div class="form-cadastro pessoais">
            <input type="text" name="name" id="name" placeholder="Nome" minlength="10" maxlength="50" value="<?php echo $nome?>" required>
            <div class="formDiv1">
              <select name="sexo" id="sexo" required>
                <option value="" disabled>Sexo</option>
                <option value="Masculino" <?php $sexo == 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                <option value="Feminino" <?php $sexo == 'Feminino' ? 'selected' : '' ?>>Feminino</option>
                <option value="Transgênero" <?php $sexo == 'Transgênero' ? 'selected' : '' ?>>Transgênero</option>
                <option value="Não-Binário" <?php $sexo == 'Não-Binário' ? 'selected' : '' ?>>Não-binário</option>
                <option value="Outros" <?php $sexo == 'Outros' ? 'selected' : '' ?>>Outros..</option>
              </select>
              <input type="date" name="dataNasc" id="dataNasc" value="<?php echo $dataNasc?>" required>
            </div>
            <div class="formDiv2">
              <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $email?>" required>
              <input type="password" name="senha" id="senha" placeholder="Senha" minlength="8" maxlength="8" value="<?php echo $senha?>" required>
              <input type="password" id="confirmSenha" placeholder="Confirme sua senha" minlength="8" maxlength="8" value="<?php echo $senha?>" required>
            </div>
            <div class="btnETermos">
              <span id="btnAvancarCad">Avançar</span>
              <label for="termos">
                <p id="termosCheckbox"><input type="checkbox" name="Termos" id="termos" checked required> Ao avançar você concorda com nossos <a href="#">Termos de uso</a> e <a href="#">Politica de privacidade</a></p>
              </label>
            </div>
          </div>
          <div class="form-cadastro adicionais">
            <div>
              <input type="text" name="cpf" id="cpf" placeholder="CPF" required minlength="14" maxlength="14" value="<?php echo $cpf?>">
              <input type="text" name="tel" id="celular" placeholder="Tel +55 (99) 99999-9999" minlength="18" maxlength="19" value="<?php echo $tel?>">
              <input type="text" name="cep" id="cep" placeholder="CEP" maxlength="9" minlength="8" value="<?php echo $cep?>">
              <input type="text" name="cidade" id="localidade" placeholder="Cidade" value="<?php echo $cidade?>" required>
              <input type="text" name="bairro" id="bairro" placeholder="Bairro" value="<?php echo $bairro?>" required>
              <div class="endereco">
                <input type="text" name="rua" id="logradouro" placeholder="Rua" value="<?php echo $rua?>" required>
                <input type="text" name="numeroCasa" id="numCasa" placeholder="Numero" maxlength="5" value="<?php echo $numeroCasa?>" required>
              </div>
            </div>
            <input type="hidden" name="id" value="<?php echo $id?>">
            <div class="btn">
              <button type="submit" name="update" id="update">Atualizar</button>
            </div>
          </div>
        </form>
      </div>
    </section>
  </main>
  <!-- FIM MAIN -->