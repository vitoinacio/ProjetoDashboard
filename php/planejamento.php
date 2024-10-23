<?php


    function sanitize($data){
        return htmlspecialchars(stripslashes(trim($data)));
    }
    //Entrada Financeira
    $valor_ent = sanitize($_POST["valor_ent"]);
    //$id_entrada = $_POST["id_entrada"];
    //$fk_id_usuario = $_POST["fk_id_usuario"];
    //$descricao = sanitize($_POST["descricao"]);
    $data_ent = sanitize($_POST["data_ent"]);


    //Débitos
    $ident_deb = sanitize($_POST["ident_deb"]);
    $data_venc = sanitize($_POST["data_venc"]);
    $obs_deb = sanitize($_POST["obs_deb"]);
    $valor_deb = sanitize($_POST["valor_deb"]);





    //Conexão com o banco de dados.

    $conn = new mysqli ('localhost', 'root', '123456', 'dashboard');
    if ($conn->connect_error){
        die('Falha na Conexão : '.$conn->connect_error);
    } else {
        //Inserção da Entrada Financeira
        $stmt = $conn->prepare("INSERT INTO ent_financeira (valor_ent, data_ent, ) values (?,?)");
        $stmt -> bind_param("sss", $valor_ent,$data_ent, );
        $stmt -> execute();
        echo 'Valor de entrada registrado com sucesso';
        $stmt -> close();
        $conn -> close();
        

        //Inserção de Débitos
        $stmt = $conn -> prepare("INSERT INTO debito (ident_deb, data_venc, obs_deb, valor_deb) values (?,?,?,?)");
        $stmt ->bind_param("ssss", $ident_deb, $data_venc, $obs_deb, $valor_deb);
        $stmt -> execute();
        echo 'Débito registrado!';
        $stmt ->close();

        $conn -> close();

        
    }


?>