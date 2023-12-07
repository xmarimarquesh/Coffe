<?php

session_start();

// Verifique se o user_id está definido
if (!isset($_SESSION['user_id'])) {
    die("User ID não está definido na sessão.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Verificar se o usuário é um administrador
$sqlVerificarAdm = "SELECT adm FROM usuarios WHERE id = $user_id";
$resultVerificarAdm = $conn->query($sqlVerificarAdm);


if (isset($_GET['finalizarPedido'])) {
    $idPedido = isset($_GET['finalizarPedido']) ? intval($_GET['finalizarPedido']) : 0;

    if ($idPedido > 0) {
        // Excluir registros relacionados na tabela produtos_pedido
        $sqlDeleteProdutosPedido = "DELETE FROM produtos_pedido WHERE id_pedido = $idPedido";
        $conn->query($sqlDeleteProdutosPedido);
    
        // Excluir o próprio pedido na tabela pedidos
        $sqlDeletePedido = "DELETE FROM pedidos WHERE id_pedido = $idPedido";
        $conn->query($sqlDeletePedido);;

    // Pode retornar uma resposta em JSON se necessário
    echo json_encode(['success' => true]);
    exit;
}
}


if ($resultVerificarAdm === false) {
    die("Erro na consulta SQL: " . $conn->error);
}

$isAdmin = false;

if ($resultVerificarAdm->num_rows > 0) {
    $row = $resultVerificarAdm->fetch_assoc();
    $isAdmin = $row['adm'] == 'admin';
}

$isAdmin = isset($_GET['isAdmin']) && $_GET['isAdmin'] === 'true';


if ($isAdmin) {
    // Se o usuário for um administrador, buscar todos os pedidos
    $sqlPedidos = "SELECT pedidos.id_pedido, pedidos.valor_total, pedidos.rua, pedidos.pagamento, pedidos.id_usuario,
    pedidos.numero_casa, pedidos.whatsapp, usuarios.nome, pedidos.obs, pedidos.troco, pedidos.data_pedido
FROM pedidos
JOIN usuarios ON pedidos.id_usuario = usuarios.id
ORDER BY pedidos.id_pedido DESC
LIMIT 5";
} else {
    // Se o usuário não for um administrador, buscar apenas os pedidos do usuário atual
    $sqlPedidos = "SELECT id_pedido, valor_total, rua, pagamento
    FROM pedidos
    WHERE id_usuario = $user_id
    ORDER BY id_pedido DESC
    LIMIT 5";
}

$resultPedidos = $conn->query($sqlPedidos);

if ($resultPedidos === false) {
    die("Erro na consulta SQL: " . $conn->error);
}

$data = array();

if ($resultPedidos->num_rows > 0) {
    while ($pedido = $resultPedidos->fetch_assoc()) {
        $idPedido = $pedido['id_pedido'];

        $sqlProdutos = "SELECT produtos.preco,produtos.nome_produto, produtos.foto_produto, produtos_pedido.quantidade
                        FROM produtos_pedido
                        JOIN produtos ON produtos_pedido.id_produto = produtos.id_produto
                        WHERE produtos_pedido.id_pedido = $idPedido";

        $resultProdutos = $conn->query($sqlProdutos);

        $produtos = array();
        if ($resultProdutos->num_rows > 0) {
            while ($produto = $resultProdutos->fetch_assoc()) {
                $produtos[] = $produto;
            }
        }

        $data[] = array(
            'id_pedido' => $idPedido,
            'preco_total' => $pedido['valor_total'],
            'rua' => $pedido['rua'],
            'metodo_pagamento' => $pedido['pagamento'],
            'numero_casa' => isset($pedido['numero_casa']) ? $pedido['numero_casa'] : null,
            'whatsapp' => isset($pedido['whatsapp']) ? $pedido['whatsapp'] : null,
            'nome_usuario' => isset($pedido['nome']) ? $pedido['nome'] : null,
            'obs' => isset($pedido['obs']) ? $pedido['obs'] : null,
            'troco' => isset($pedido['troco']) ? $pedido['troco'] : null,
            'data_pedido' => isset($pedido['data_pedido']) ? $pedido['data_pedido'] : null,
            'produtos' => $produtos
        );
    }
} else {
    echo "Nenhum pedido encontrado para o usuário.";
}

$conn->close();

echo json_encode($data);
