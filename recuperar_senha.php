<?php

require_once('conexao/conexao.php');


if (isset($_POST['validar-email'])) {

    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro[] = "E-mail inválido";
    }

    $novasenha = substr(md5(time()), 0, 6);

    ini_set("SMTP", "smtp.gmail.com");
    ini_set("smtp_port", "587");
    ini_set("username", "kngvney@gmail.com");
    ini_set("password", "peido123");

    $headers = "From: kngvney@gmail.com" . "\r\n";
    $headers .= "Reply-To: kngvney@gmail.com" . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    $headers .= "Return-Path: kngvney@gmail.com";


    if (mail($email, "Sua nova senha", "Sua nova senha: " . $novasenha)) {

        $sql = "UPDATE usuario SET senha = '$novasenha' WHERE email ='$email'";
        $consulta = $db->prepare($sql);
        $consulta->execute();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<style>
    
</style>

<head>
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../public/css/style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/lin.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="senha.css">
    <title>Recuperar Senha</title>
</head>

<body>
<div class="container">
    <div class="card text-center" style="width: 300px;">
        <div class="card-header h5 text-white">Recuperar senha</div>
        <div class="card-body px-5">
            <p class="text-center">Nos informe seu e-mail cadastrado para redefinir sua senha</p>
            <div class="form-outline">
                <label class="form-label" for="typeEmail">Email</label>
                <input class="form-control" type="email" name="email" placeholder="Digite seu e-mail" required>
                <br>
            </div>
            <a href="#" class="btn btn-primary w-100">Redefinir senha</a>
            <div class="link login-link text-center"><a href="login.php">Voltar</a>
            </div>
        </div>
        </div>


</body>

</html>