<?php

session_start();

require_once('classes/Usuario.php');
require_once('conexao/conexao.php');

$database = new Conexao();
$db = $database->getConnection();
$classUsuario = new Usuario($db);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre nós</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css/sobre.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="shortcut icon" href="img/lin.png">
</head>

<body>

    <?php include_once('view/header.php'); ?>
    <section id="corpo">
        <img src="img/nav-produtos.png" alt="" id="slide">
        <section id="container">
            <div class="sobre">
                <h1>Sobre Nós</h1>
            </div>
            <div class='telas'>
                <div class="texto">
                    <h2>Ambiente</h2>
                    <p>
                        No Coffe's Garden, unimos a paixão pelo café e o amor pelas flores para criar experiências únicas e memoráveis. Fundada por entusiastas do café e
                        amantes das flores, nossa missão é trazer beleza, sabor e inspiração para o seu dia a dia. Selecionamos os melhores grãos de café e flores frescas para
                        proporcionar uma jornada sensorial inesquecível. Nosso compromisso com a sustentabilidade reflete o cuidado que temos com o planeta. Seja para um momento
                        de relaxamento ou uma celebração especial, no Coffe's Garden, a simplicidade e sofisticação se encontram.
                    </p>

                </div>
                <div class="img">
                    <img id="imagem" src="img/coffee-5428480_1280.jpg" alt="">
                </div>
            </div>

            <div class='telas' id="telas2">
                <div class="texto" id="texto2">
                    <h2>Doações</h2>
                    <p>
                        O seu negócio de café tem uma característica única e admirável: além de vender café, também oferece flores. O aspecto mais notável dessa iniciativa é que
                        100% do lucro obtido com a venda das flores é destinado a doações. Esta prática não só diversifica os produtos disponíveis para os clientes, mas também
                        demonstra um forte compromisso social e comunitário. Ao adquirir flores no seu estabelecimento, os clientes têm a oportunidade de desfrutar da beleza e
                        fragrância dessas flores, ao mesmo tempo em que contribuem para uma causa nobre. Este modelo de negócio cria uma experiência única para os clientes, alinhando
                        prazer pessoal com responsabilidade social.
                    </p>

                </div>
                <div class="img">
                    <img id="imagem" src="img/doa.jpg" alt="">
                </div>
            </div>

            <div class="rodape">
                <?php include_once('view/rodape.php'); ?>
            </div>


        </section>


    </section>
    <script>
        // Verifica se há um fragmento na URL e se for '#scrollDown', rola para baixo
        document.addEventListener("DOMContentLoaded", function() {
            if (window.location.hash === "#scrollDown") {
                window.scrollTo(0, document.body.scrollHeight);
            }
        });
    </script>
</body>

</html>