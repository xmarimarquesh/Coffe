<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_usuario = $_SESSION['user_id'];
$sql = "SELECT c.id_produto, c.quantidade, p.preco FROM carrinho c JOIN produtos p ON c.id_produto = p.id_produto WHERE c.id_usuario = $id_usuario";
$result = $conn->query($sql);

$forma_pagamento = $_POST['forma_pagamento'];
$observacoes = $_POST['observacoes'];
$whatsapp = $_POST['whatsapp'];
$cep = $_POST['cep'];
$rua = $_POST['rua'];
$numero_casa = $_POST['numero_casa'];
$troco = $_POST['troco'];

$total = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total += $row['quantidade'] * $row['preco'];
    }

    $sql_pedido = "INSERT INTO pedidos (id_usuario, pagamento, obs, whatsapp, cep, rua, numero_casa, troco, valor_total) VALUES ($id_usuario, '$forma_pagamento', '$observacoes', '$whatsapp', '$cep', '$rua', '$numero_casa', '$troco', $total)";
    $conn->query($sql_pedido);

    $id_pedido = $conn->insert_id;

    $result->data_seek(0); // Voltar ao início do resultado

    while ($row = $result->fetch_assoc()) {
        $id_produto = $row['id_produto'];
        $quantidade = $row['quantidade'];

        $sql_produto_pedido = "INSERT INTO produtos_pedido (id_pedido, id_produto, quantidade) VALUES ($id_pedido, $id_produto, $quantidade)";
        $conn->query($sql_produto_pedido);
    }

    $mensagem = "Seu pedido foi recebido!\n";

    $sql_limpar_carrinho = "DELETE FROM carrinho WHERE id_usuario = $id_usuario";
    $conn->query($sql_limpar_carrinho);

    $sql_produtos_pedido = "SELECT p.nome_produto, pp.quantidade FROM produtos_pedido pp JOIN produtos p ON pp.id_produto = p.id_produto WHERE pp.id_pedido = $id_pedido";
    $result_produtos_pedido = $conn->query($sql_produtos_pedido);

    while ($row = $result_produtos_pedido->fetch_assoc()) {
        $mensagem .= $row['quantidade'] . "x " . $row['nome_produto'] . "\n";
    }

} else {
    echo "Carrinho vazio!";
}

$conn->close();
?>