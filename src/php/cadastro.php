<?php
require_once "conexao.php";

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

// Criptografar a senha
$senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

// Database connection
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO usuario(nome, sexo, dataNasc, email, senha, cpf, tel, cep, cidade, bairro, rua, numeroCasa) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }
    $stmt->bind_param("ssssssssssss", $nome, $sexo, $dataNasc, $email, $senha_criptografada, $cpf, $tel, $cep, $cidade, $bairro, $rua, $numeroCasa);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: ../../index.php?errorMessage=Registrado com Sucesso!');
    exit();
}
?>