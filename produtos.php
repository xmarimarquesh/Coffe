<?php
session_start();

require_once('classes/Usuario.php');
require_once('conexao/conexao.php');

$database = new Conexao();
$db = $database->getConnection();
$classUsuario = new Usuario($db);

$produtosCafe = [];
$produtosFlores = [];
$produtos = [];


if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $queryCafe = "SELECT * FROM produtos WHERE nome_produto LIKE '%$data%' and tipo = 'cafe'";
    $resultCafe = $db->query($queryCafe);
    $queryFlores = "SELECT * FROM produtos WHERE nome_produto LIKE '%$data%' and tipo = 'flor'";
    $resultFlores = $db->query($queryFlores);

    if (($resultCafe->rowCount() > 0) or ($resultFlores->rowCount() > 0)) {
        while ($row = $resultCafe->fetch(PDO::FETCH_ASSOC)) {
            $produtosCafe[] = $row;
        }
        while ($row = $resultFlores->fetch(PDO::FETCH_ASSOC)) {
            $produtosFlores[] = $row;
        }
    }
} else {
    $queryCafe = "SELECT * FROM produtos WHERE tipo = 'cafe'";
    $resultCafe = $db->query($queryCafe);
    if ($resultCafe->rowCount() > 0) {
        while ($row = $resultCafe->fetch(PDO::FETCH_ASSOC)) {
            $produtosCafe[] = $row;
        }
    }

    $queryFlores = "SELECT * FROM produtos WHERE tipo = 'flor'";
    $resultFlores = $db->query($queryFlores);
    if ($resultFlores->rowCount() > 0) {
        while ($row = $resultFlores->fetch(PDO::FETCH_ASSOC)) {
            $produtosFlores[] = $row;
        }
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
    <link rel="stylesheet" href="produto.css">
    <link rel="shortcut icon" href="img/lin.png">
    <title>Produtos</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<body>
    <div id="searchResults"></div>

    <?php include_once('view/header.php'); ?>
    <section id="corpo">
        <img src="img/nav-produtos.png" alt="" id="slide">
        <section id="container">
            <div class="produto">
                <h1>Produtos</h1>
            </div>
            <div class="box-search">
                <input type="search" placeholder="Pesquisar..." id="pesquisar">
                <button onclick="searchData()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                </button>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 cafe" id="cafeTitle">
                        <h2>Cafés</h2>
                    </div>
                    <?php
                    foreach ($produtosCafe as $produto) {
                        echo '<div class="col-md-3 product-card ">';
                        echo '<div class="card shadow">';
                        echo '<div class="cinza">';
                        if ($produto['destaque']) {
                            echo '<div class = "estrela"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill destaque" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                          </svg></div>';
                        }
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


                    <div class="col-md-12 flores" id="floresTitle">
                        <h2>Flores</h2>
                    </div>
                    <?php
                    foreach ($produtosFlores as $produto) {
                        echo '<div class="col-md-3 product-card ">';
                        echo '<div class="card shadow">';
                        if ($produto['destaque']) {
                            echo '<div class = "estrela"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill destaque" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                          </svg></div>';
                        }
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
            </div>

            <?php include_once('view/rodape.php'); ?>

        </section>



    </section>


</body>
<script>
    var search = document.getElementById('pesquisar');
    var cafeTitle = document.getElementById('cafeTitle');
    var floresTitle = document.getElementById('floresTitle');


    search.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            searchData();
        }
    });

    function searchData() {
        var searchValue = search.value;

        // Exibe ou oculta o título "Cafés" com base nos resultados da pesquisa
        cafeTitle.style.display = floresTitle.style.display = 'none'; // Oculta ambos os títulos por padrão

        // Se a pesquisa estiver vazia, exibe ambos os títulos
        if (searchValue.trim() === '') {
            cafeTitle.style.display = 'block';
            floresTitle.style.display = 'block';
        } else {
            // Realize a lógica de pesquisa e determine se há resultados para cafés e flores
            // Se houver resultados, ajuste os estilos conforme necessário
            // Por exemplo, você pode usar AJAX para verificar os resultados no servidor
        }

        window.location = 'produtos.php?search=' + search.value;
        
        
    }
</script>

</html>