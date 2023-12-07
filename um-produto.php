<?php
session_start();

require_once('classes/Usuario.php');
require_once('conexao/conexao.php');

$database = new Conexao();
$db = $database->getConnection();
$classUsuario = new Usuario($db);

$produto = null;


// Verifica se um ID de produto foi passado via GET
if (isset($_GET['id_produto'])) {
    $id_produto = $_GET['id_produto'];

    // Consulta SQL para buscar informações do produto pelo ID
    $sql = "SELECT * FROM produtos WHERE id_produto = :id_produto";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_produto', $id_produto);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Produto não encontrado.";
        exit();
    }
}


$tipo_atual = $produto['tipo'];


$sql_related = "SELECT * FROM produtos WHERE tipo = :tipo AND id_produto != :id_produto LIMIT 8";
$stmt_related = $db->prepare($sql_related);
$stmt_related->bindParam(':tipo', $tipo_atual);
$stmt_related->bindParam(':id_produto', $id_produto);
$stmt_related->execute();

$produtos_relacionados = $stmt_related->fetchAll(PDO::FETCH_ASSOC);




?>

<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Produto</title>
    <!-- Bootstrap CSS and JS for carousel -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="um-produto.css">
    <link rel="shortcut icon" href="img/lin.png">
    
</head>

<body>

    <?php require('view/header.php'); ?>


    <section id="corpo">
        <img src="img/fundo.jpg" alt="" id="slide">
        <section id="container">

            <div class="container" style="height: 850px; ">

                <div class="row g-2 justify-content-around tudo">
                    <div class="col-md-6 d-flex flex-column justify-content-center align-itens-center order-lg-2 texts">
                        <div class="p-3 ">
                            <div class="preco">
                                <h1 class="custom-highlight" style="font-size: 4.7em;">
                                    <?php echo $produto['nome_produto']; ?>
                                </h1>
                            </div>
                        </div>
                        <div class="p-3" style="margin-top: 20px;">
                            <div class="preco">
                                <h3>R$
                                    <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                                </h3>
                                <p class="produto-descricao">
                                    <?php echo $produto['descricao']; ?>
                                    <?php echo '<a name="add_carrinho" type = "submit" class=" add-to-cart btn btn-secondary confira shadow-sm">Adicionar ao carrinho!</a>'; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center align-itens-center order-lg-2">
                        <div class="p-3 imagem">
                            <img src="<?php echo $produto['foto_produto']; ?>" alt="<?php echo $produto['nome_produto']; ?>" class="mx-auto d-block  " width="700" height="auto">
                        </div>
                    </div>
                </div>

                <section id="related-products">
                    <h2 class="text-center">Produtos Relacionados</h2>
                    <div id="relatedCarousel" class="carousel slide" data-bs-ride="carousel">



                        <!-- Conteúdo do Carrossel -->
                        <div class="carousel-inner">
                            <?php foreach (array_chunk($produtos_relacionados, 4) as $key => $four_products) : ?>
                                <div class="carousel-item <?php if ($key == 0)
                                                                echo 'active'; ?>">
                                    <div class="row">
                                        <?php foreach ($four_products as $produto_relacionado) : ?>
                                            <?php
                                            echo '<div class="col-md-3 product-card ">';
                                            echo '<div class="card shadow">';
                                            echo '<div class="cinza">';
                                            echo '<img src="' . $produto_relacionado["foto_produto"] . '" alt="' . $produto_relacionado["nome_produto"] . '" class="card-img-top">';
                                            echo '</div>';
                                            echo '<div class="card-body">';
                                            echo '<h2 class="card-title">' . $produto_relacionado["nome_produto"] . '</h2>';
                                            echo '<p class="card-text">' . $produto_relacionado["descricao"] . '</p>';
                                            echo '<div class="d-flex justify-content-around">';
                                            echo '<a href="um-produto.php?id_produto=' . $produto_relacionado["id_produto"] . '" name="add" style="padding-bottom: 0rem;" class=" btn btn-primary preco">R$ ' . number_format($produto['preco'], 2, ',', '.') . '</a>';
                                            echo '<a href="um-produto.php?id_produto=' . $produto_relacionado["id_produto"] . '" name="add" class=" btn btn-secondary confira shadow-sm">Confira!</a>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!-- Botões de controle -->
                            <a class="carousel-control-prev" href="#relatedCarousel" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span id="bt" class="visually-hidden">Anterior</span>
                            </a>
                            <a class="carousel-control-next" href="#relatedCarousel" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span id="bt" class="visually-hidden">Próximo</span>
                            </a>
                        </div>





                    </div>
                </section>

            </div>
            <?php include_once('view/rodape.php'); ?>
        </section>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="cart.js"></script>

    <script>
        $(document).ready(function() {
            $('a[name="add_carrinho"]').click(function(e) {
                e.preventDefault();

                // Obtenha o ID do produto
                var idProduto = <?php echo $produto['id_produto']; ?>;

                // Faça a chamada AJAX para adicionar ao carrinho
                $.ajax({
                    type: 'POST',
                    url: 'adicionar_carrinho.php',
                    data: {
                        id_produto: idProduto
                    },
                    success: function(response) {
                        // Atualizar o contador do carrinho
                        atualizarContadorForaAjax();
                        atualizarCarrinho();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>


</body>

</html>