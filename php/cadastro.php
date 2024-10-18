<?php
//   function inverteData($data){
//     if(count(explode("-",$data)) > 1){
//         return implode("",array_reverse(explode("-",$data)));
//     }elseif(count(explode("",$data)) > 1){
//         return implode("-",array_reverse(explode("",$data)));
//     }
// }
  $nome = $_POST["nome"];
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
  $numCasa = $_POST["numCasa"];

  //Database connection.
    $conn = new mysqli('localhost', 'root', '2706', 'dashboard');
    if ($conn->connect_error){
        die ('Connection Failed  :  '.$conn->connect_error);
    }else {
        $stmt = $conn->prepare("insert into usuario(nome, sexo, dataNasc, email, senha, cpf, tel, cep, cidade, bairro, rua, numeroCasa) values(?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt -> bind_param("ssssssssssss", $nome, $sexo, $dataNasc, $email, $senha, $cpf, $tel, $cep, $cidade, $bairro, $rua, $numCasa);
        $stmt -> execute();
        echo 'Registrado com sucesso';
        $stmt -> close();
        $conn -> close();cd
    }


?>