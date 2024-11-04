<?php
    require_once "conexao.php";
//   function inverteData($data){
//     if(count(explode("-",$data)) > 1){
//         return implode("",array_reverse(explode("-",$data)));
//     }elseif(count(explode("",$data)) > 1){
//         return implode("-",array_reverse(explode("",$data)));
//     }
// }
  $nome = $_POST["name"];
  $sexo = $_POST["sexo"];
  $dataNasc =$_POST["dataNasc"];
  $email = $_POST["email"];
  $senha = $_POST["senha"];
  $cpf = $_POST["cpf"];
  $tel = $_POST["tel"];
  $cep = $_POST["cep"];
  $cidade = $_POST["cidade"];
  $bairro = $_POST["bairro"];
  $rua = $_POST["rua"];
  $numeroCasa = $_POST["numeroCasa"];

  //Database connection.
    // $conn = new mysqli('localhost', 'root', '', 'dashboard');
    if ($conn->connect_error){
        die ('Connection Failed  :  '.$conn->connect_error);
    }else {
        $stmt = $conn->prepare("insert into usuario(nome, sexo, dataNasc, email, senha, cpf, tel, cep, cidade, bairro, rua, numeroCasa) values(?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt -> bind_param("ssssssssssss", $nome, $sexo, $dataNasc, $email, $senha, $cpf, $tel, $cep, $cidade, $bairro, $rua, $numeroCasa);
        $stmt -> execute();
        echo 'Registrado com sucesso';
        $stmt -> close();
        $conn -> close();
        header('Location: ../../index.html');
    }


?>