<?php
session_start();

require_once('classes/Usuario.php');
require_once('conexao/conexao.php');

$database = new Conexao();
$db = $database->getConnection();
$classUsuario = new Usuario($db);

$produtosDestaque = [];

$queryDestaque = "SELECT * FROM produtos WHERE destaque = 1";
$resultDestaque = $db->query($queryDestaque);
if ($resultDestaque->rowCount() > 0) {

    while ($row = $resultDestaque->fetch(PDO::FETCH_ASSOC)) {
        $produtosDestaque[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Galada&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <link rel="stylesheet" href="teste.css">
    <link rel="shortcut icon" href="img/lin.png">
    <title>Coffe's Garden</title>
</head>

<body>
    <?php include_once('view/header.php'); ?>
    <section id="corpo">
        <img src="img/wallpaper.webp" alt="" id="slide">
        <h1 id="titulo">Coffe's Garden</h1>
        <section id="container">
            <div id="frase">Onde café e flores se unem para criar um verdadeiro paraíso.</div>

            <div class="slider">
                <div class="slides">
                    <input type="radio" name="radio-btn" id="radio1">
                    <input type="radio" name="radio-btn" id="radio2">
                    <input type="radio" name="radio-btn" id="radio3">
                    <input type="radio" name="radio-btn" id="radio4">

                    <div class="slide first">
                        <img src="img/radio1.png" alt="img1">
                        <div class="ver1" style="margin-top:-200px">
                            <a href="um-produto.php?id_produto=7">Veja mais!</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="img/radi2.png" alt="img2">
                        <div class="ver1" style="margin-top:-130px">
                            <a href="https://www.instagram.com/coffes_garden/?utm_source=ig_web_button_share_sheet&igshid=OGQ5ZDc2ODk2ZA==">Veja mais!</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="img/radi3.png" alt="img3">
                        <div class="ver2" style="margin-top:-300px">
                            <a href="um-produto.php?id_produto=16">Veja mais!</a>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="img/radi4.png" alt="img4">
                        <div class="ver2" style="margin-top:-400px">
                            <a href="sobre.php#scrollDown">Veja mais!</a>
                        </div>
                    </div>

                    <div class="navigation-auto">
                        <div class="auto-btn1"></div>
                        <div class="auto-btn2"></div>
                        <div class="auto-btn3"></div>
                        <div class="auto-btn4"></div>
                    </div>
                </div>
                <div class="manual-navigation">
                    <label for="radio1" class="manual-btn"></label>
                    <label for="radio2" class="manual-btn"></label>
                    <label for="radio3" class="manual-btn"></label>
                    <label for="radio4" class="manual-btn"></label>
                </div>

            </div>

            <div class="cont">
                <div class="row destaque">
                    <div class="col-md-12 destaque">
                        <h2>Produtos em Destaque</h2>
                    </div>
                    <?php
                    foreach ($produtosDestaque as $produto) {
                        echo '<div class="col-md-3 product-card ">';
                        echo '<div class="card shadow">';
                        echo '<div class="cinza">';
                        echo '<img src="' . $produto["foto_produto"] . '" alt="' . $produto["nome_produto"] . '" class="card-img-top">';
                        echo '</div>';
                        echo '<div class="card-body">';
                        echo '<h2 class="card-title">' . $produto["nome_produto"] . '</h2>';
                        echo '<p class="card-text">' . $produto["descricao"] . '</p>';
                        echo '<div class="d-flex justify-content-around">';
                        echo '<a href="um-produto.php?id_produto=' . $produto["id_produto"] . '" name="add" class=" btn btn-primary preco">R$ ' . number_format($produto['preco'], 2, ',', '.') . '</a>';
                        echo '<a href="um-produto.php?id_produto=' . $produto["id_produto"] . '" name="add" class=" btn btn-secondary confira shadow-sm">Confira!</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <section id="servicos">
                    <h2>Explore nosso jardim de delícias!</h2>
                    <div>
                        <img src="img/p1.png" alt="Camera">
                        <h3><strong>Arranjos</strong> Florais Exclusivos</h3>
                        <p>Descubra a beleza única em cada buquê, elaborado artesanalmente para momentos especiais ou
                            para iluminar seu dia com frescor e elegância.</p>
                    </div>
                    <div>
                        <img src="img/p2.png" alt="Video">
                        <h3>Cafeteria <strong>Aconchegante</strong></h3>
                        <p>Delicie-se em nossa cafeteria envolvente, onde o aroma fresco do café se entrelaça, 
                            proporcionando uma experiência sensorial única.</p>
                    </div>
                    <div>
                        <img src="img/p4.png" alt="Restauração">
                        <h3><strong>Experiências</strong> Sensoriais Personalizadas</h3>
                        <p>Crie momentos memoráveis com experiências personalizadas que vão além de eventos especiais. 
                            Personalizamos cada experiência para despertar seus sentidos.</p>
                    </div>
                    <div>
                        <img src="img/p3.png" alt="Filmagem">
                        <h3>Compromisso <strong>Sustentável</strong></h3>
                        <p>Produtos que refletem nosso compromisso com a sustentabilidade,
                             contribuindo para um planeta mais saudável.</p>
                    </div>

                </section>
                <DIV class="r">
                    <?php include_once('view/rodape.php'); ?>
                </DIV>
        </section>



    </section>

    <script src="script.js"></script>
    <script>
        // Adicione um ouvinte de evento ao link
        document.getElementById('scrollLink').addEventListener('click', function() {
            // Adicione um parâmetro à URL para indicar que deve rolar para baixo
            window.location.href = "sobre.php#scrollDown";
        });
    </script>
</body>




</html>