<?php
session_start();
require_once('classes/Usuario.php');
require_once('conexao/conexao.php');

$database = new Conexao();
$db = $database->getConnection();
$usuario = new Usuario($db);




?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Logar/Registrar</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="shortcut icon" href="img/lin.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<?php

if (isset($_POST['logar'])) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $login = $_POST['email'];

    if ($usuario->logar($email, $senha)) {
        if ($usuario->verificarAdm($email)) {
            $dadosUsuario = $usuario->getDadosUsuario($email);
            $_SESSION['email'] = $login;
            $_SESSION['adm'] = true;
            $_SESSION['nome'] = $dadosUsuario['nome'];
            $_SESSION['user_id'] = $dadosUsuario['id'];
            header("Location: dashboard-admin.php");
            exit();
        } else {
            $dadosUsuario = $usuario->getDadosUsuario($email);
            $_SESSION['user_id'] = $dadosUsuario['id'];
            $_SESSION['email'] = $email;
            $_SESSION['nome'] = $dadosUsuario['nome'];



            header("Location: index.php");
            exit();
        }
    } else {
        print "<script>alert('Login inválido')</script>";
    }
}


if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confSenha = $_POST['confSenha'];
    $cep = $_POST['cep'];
    $rua = $_POST['rua'];
    $numero_casa = $_POST['numero_casa'];


    if ($usuario->cadastrar($nome, $email, $senha, $confSenha, $cep, $rua, $numero_casa)) {
        echo "<p>Cadastro realizado com sucesso!</p>";
    } else {

        echo "Erro ao cadastrar";
    }
}



?>

<body>
    <nav>
        <div class="nav">
            <a href="index.php"><img src="img/logo.png" alt="" id="logo"></a>
        </div>
    </nav>

    <div class="cont">
        <input type="checkbox" id="flip">
        <div class="cover">
            <div class="front">
                <img src="img/Login.png" alt="">
            </div>
            <div class="back">
                <img class="backImg" src="img/Login.png" alt="">
            </div>
        </div>
        <div class="forms">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Logar</div>
                    <form method="POST">
                        <div class="input-boxes">
                            <?php
                            ?>
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input name="email" type="text" placeholder="Seu e-mail" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input name="senha" type="password" placeholder="Sua senha" required>
                            </div>
                            <div class="text"><a href="recuperar_senha.php">Esqueceu sua senha?</a></div>
                            <div class="button input-box">
                                <input name="logar" type="submit" value="Logar">
                            </div>
                            <div class="text sign-up-text">Ainda sem conta? <label for="flip">Registrar</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="signup-form">
                    <div class="title">Registrar</div>
                    <form method="POST">
                        <div class="input-boxes">

                            <div class="input-box">
                                <i class="fas fa-user"></i>
                                <input name="nome" type="text" placeholder="Digite seu nome" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input name="email" type="text" placeholder="Digite seu email" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input name="senha" type="password" placeholder="Digite sua senha" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input name="confSenha" type="password" placeholder="Confirme sua senha" required>
                            </div>


                            <div class="cep-tab">
                                <div class="cep-header">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>Endereço</span>
                                    <i class="toggle-icon fas fa-plus"></i>
                                </div>
                                <div class="cep-content">
                                    <div class="input-box">
                                        <input name="cep" id="cep" type="text" placeholder="CEP" required><span id="botao" class="material-symbols-outlined">
                                            search
                                        </span>

                                    </div>

                                    <div class="input-box">
                                        <input name="rua" id="rua" type="text" placeholder="Rua" required>
                                    </div>
                                    <div class="input-box">
                                        <input name="numero_casa" type="text" placeholder="Número" required>
                                    </div>
                                </div>
                            </div>



                            <div class="button input-box">
                                <input name="cadastrar" type="submit" value="Registrar">
                            </div>
                            <div class="text sign-up-text">Já tem uma conta? <label for="flip">Logar</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cepTab = document.querySelector(".cep-tab");
            const toggleIcon = cepTab.querySelector(".toggle-icon");

            toggleIcon.addEventListener("click", function() {
                cepTab.classList.toggle("open");
                if (cepTab.classList.contains("open")) {
                    toggleIcon.classList.remove("fas", "fa-plus");
                    toggleIcon.classList.add("fas", "fa-minus");
                } else {
                    toggleIcon.classList.remove("fas", "fa-minus");
                    toggleIcon.classList.add("fas", "fa-plus");
                }
            });
        });


        $('#cep').blur(function() {
            // Obtém o valor do CEP
            var cep = $(this).val().replace(/\D/g, '');

            // Verifica se o CEP possui 8 caracteres
            if (cep.length == 8) {
                // Faz a requisição à API ViaCEP
                $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(data) {
                    // Preenche os campos com os dados retornados pela API
                    $('#rua').val(data.logradouro);
                    // Outros campos podem ser preenchidos da mesma forma, conforme necessário
                });
            }
        });
    </script>
</body>

</html>