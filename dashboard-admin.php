<?php

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['adm'] != 1) {
    header("Location: index.php");
    exit();
}


$login = $_SESSION['email'];

require_once('classes/Produto.php');
require_once('conexao/conexao.php');

$database = new Conexao();
$db = $database->getConnection();
$crud = new CrudProduto($db);

// Solicitações do usuário
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'create':
            $crud->create($_POST);
            $rows = $crud->read();
            break;
        case 'read':
            $rows = $crud->read();
            break;
        case 'updateProduct':
            if (isset($_POST['id_produto'])) {
                $rows = $crud->updateProduct($_POST);
            }

            $rows = $crud->read();
            break;
        case 'delete':
            $crud->delete($_GET['id_produto']);
            $rows = $crud->read();
            break;

        default:
            $rows = $crud->read();
            break;
    }
} else {
    $rows = $crud->read();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard ADM</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="a.css">
    <link rel="shortcut icon" href="img/lin.png">
</head>

<body>
    <div class="container mt-5">

        <div class="nav">
            <h1 class="text-center">Painel de Controle</h1>
            <div id="oi">
                <p class="text-center" class="oi">Olá,
                    <?php echo ucfirst($_SESSION['nome']); ?>!
                </p>
                <a href="index.php" class="oi"><i class="material-symbols-outlined">home</i></a>
                <a href="logout.php" class="oi"><i class="material-symbols-outlined">logout</i></a>
            </div>
        </div>


        <table class="table mt-5 tabela-produtos">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome do Produto</th>
                    <th>Tipo</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Destaque</th>
                    <th>Caminho Imagem</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($rows)) {
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['id_produto'] . "</td>";
                        echo "<td>" . $row['nome_produto'] . "</td>";
                        echo "<td>" . $row['tipo'] . "</td>";
                        echo "<td>" . $row['descricao'] . "</td>";
                        echo "<td>" . $row['preco'] . "</td>";
                        echo "<td>" . $row['destaque'] . "</td>";
                        echo "<td>" . $row['foto_produto'] . "</td>";
                        echo "<td>";
                        echo "<div class='add'>";
                        echo "<a class='ad' href='?action=updateProduct&id_produto=" . $row['id_produto'] . "'>Editar</a> ";
                        echo "<a class='ad' href='?action=delete&id_produto=" . $row['id_produto'] . "' onclick='return confirm(\"Tem certeza que quer apagar esse registro?\")' class='delete'>Excluir</a>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Não há registros a serem exibidos.</td></tr>";
                }
                ?>
            </tbody>

        </table>
        <button onclick="toggleForm()" id="adc">+ Adicionar produto</button>
        <?php

        if (isset($_GET['action']) && $_GET['action'] == 'updateProduct' && isset($_GET['id_produto'])) {
            $id_produto = $_GET['id_produto'];
            $result = $crud->readOne($id_produto);

            if (!$result) {
                echo "Registro não encontrado.";
                exit();
            }

            $nome_produto = $result['nome_produto'];
            $descricao = $result['descricao'];
            $tipo = $result['tipo'];
            $preco = $result['preco'];
            $destaque = $result['destaque'];

        ?>
        <div class="corpo">
            <div id="formularios">
                <form action="?action=updateProduct" method="POST" class="mt-5">

                    <div id="updateProduct-form">
                        <h1>Atualizar</h1>
                        <input type="hidden" name="id_produto" value="<?php echo $id_produto ?>">

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select name="tipo" class="form-select">
                                <option value="cafe" <?php echo ($tipo == 'cafe') ? 'selected' : ''; ?>>Café</option>
                                <option value="flor" <?php echo ($tipo == 'flor') ? 'selected' : ''; ?>>Flor</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="destaque" class="form-label">Produto Destaque</label>
                            <select name="destaque" class="form-select">
                                <option value="1" <?php echo ($destaque == '1') ? 'selected' : ''; ?>>Sim</option>
                                <option value="0" <?php echo ($destaque == '0') ? 'selected' : ''; ?>>Não</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nome_produto" class="form-label">Nome do Produto</label>
                            <input type="text" value="<?php echo $nome_produto ?>" name="nome_produto" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" value="<?php echo $descricao ?>" name="descricao" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="preco" class="form-label">Preço do Produto</label>
                            <input type="text" value="<?php echo $preco ?>" name="preco" class="form-control" required>
                        </div>

                        <input type="submit" value="Atualizar" name="enviar" onclick="return confirm('Certeza que deseja atualizar?')">
                        <input id="esc" type="button" value="Fechar" onclick="fecharFormulario()" class="btn btn-secondary float-right">

                    </div>
                </form>


            <?php
        }
    
            ?>

            


                <form method="POST" action="?action=create" enctype="multipart/form-data" class="mt-5">

                    <div id="create-form">
                        <h1>Criar</h1>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select name="tipo" class="form-select">
                                <option value="cafe">Café</option>
                                <option value="flor">Flor</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="destaque" class="form-label">Produto Destaque</label>
                            <select name="destaque" class="form-select">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nome_produto" class="form-label">Nome do Produto</label>
                            <input type="text" name="nome_produto" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" name="descricao" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="preco" class="form-label">Preço do Produto</label>
                            <input type="text" name="preco" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="foto_produto" class="form-label">Foto do Produto</label>
                            <input type="file" name="foto_produto" class="form-control" id="ft">
                        </div>
                        <input type="submit" value="Cadastrar">

                    </div>
                </form>

            </div>


            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.bundle.min.js">

            </script>
            <script>
               

                function fecharFormulario() {
                    var formContainer = document.getElementById("updateProduct-form");
                    formContainer.style.display = "none";
                }


                function toggleForm() {
                    var formCreate = document.getElementById('create-form');

                    if (formCreate.style.display === 'none' || formCreate.style.display === '') {
                        // Se o formulário de criação estiver oculto, exibe-o e oculta o formulário de atualização
                        formCreate.style.display = 'block';

                    } else {
                        // Se o formulário de criação estiver visível, oculta-o e exibe o formulário de atualização
                        formCreate.style.display = 'none';

                    }
                }
            </script>

</body>

</html>