<?php
// require_once "conexao.php";

// // Get values from form
// $nome = $_POST["nome"];
// $sexo = $_POST["sexo"];
// $dataNasc = $_POST["dataNasc"];
// $email = $_POST["email"];
// $senha = $_POST["senha"];
// $cpf = $_POST["cpf"];
// $tel = $_POST["tel"];
// $cep = $_POST["cep"];
// $cidade = $_POST["cidade"];
// $bairro = $_POST["bairro"];
// $rua = $_POST["rua"];
// $numeroCasa = $_POST["numeroCasa"];

// $cpf = str_replace(['.', '-'], '', $cpf);
// $tel = str_replace(['+', '(', ')', '-', ' '], '', $tel);
// $cep = str_replace('-', '', $cep);
//     $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

//   //Database connection.
//     // $conn = new mysqli('localhost', 'root', '', 'dashboard');
//     if ($conn->connect_error){
//         die ('Connection Failed  :  '.$conn->connect_error);
//     }else {
//         $stmt = $conn->prepare("INSERT INTO usuario(nome, sexo, dataNasc, email, senha, cpf, tel, cep, cidade, bairro, rua, numeroCasa) values(?,?,?,?,?,?,?,?,?,?,?,?)");
//         $stmt -> bind_param("ssssssssssss", $nome, $sexo, $dataNasc, $email, $senha_criptografada, $cpf, $tel, $cep, $cidade, $bairro, $rua, $numeroCasa);
//         $stmt -> execute();
//         $stmt -> close();
//         $conn -> close();
        
//     }
//         header('Location: ../../index.php?errorMessage=Registrado com Sucesso!');

require_once "conexao.php";
session_start();

// Get values from form
$nome = $_POST["nome"];
$sexo = $_POST["sexo"];
$dataNasc = $_POST["dataNasc"];
$email = $_POST["email"];
$senha = $_POST["senha"];
$cpf = $_POST["cpf"];
$tel = $_POST["tel"];
$cep = $_POST["cep"];
$cidade = $_POST["cidade"];
$bairro = $_POST["bairro"];
$rua = $_POST["rua"];
$numeroCasa = $_POST["numeroCasa"];

$cpf = str_replace(['.', '-'], '', $cpf);
$tel = str_replace(['+', '(', ')', '-', ' '], '', $tel);
$cep = str_replace('-', '', $cep);
$senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

// Database connection.
if ($conn->connect_error) {
    die('Connection Failed  :  ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO usuario(nome, sexo, dataNasc, email, senha, cpf, tel, cep, cidade, bairro, rua, numeroCasa) values(?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssssssss", $nome, $sexo, $dataNasc, $email, $senha_criptografada, $cpf, $tel, $cep, $cidade, $bairro, $rua, $numeroCasa);
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        // Get the ID of the inserted user
        $userId = $stmt->insert_id;

        // Set session variables
        $_SESSION['id'] = $userId;
        $_SESSION['email'] = $email;

        // Redirect to a logged-in page
        header('Location: ../pages/dashboard.php?message=Registrado com Sucesso!');
    } else {
        // Handle insertion failure
        header('Location: ../../index.php?errorMessage=Falha no cadastro.');
    }

    $stmt->close();
    $conn->close();
}
?>
