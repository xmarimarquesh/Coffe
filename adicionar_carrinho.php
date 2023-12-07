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

// Função para transferir itens do carrinho temporário para o carrinho do usuário
function transferirCarrinhoTemporario($conn, $id_usuario, $chave_carrinho_temp) {
    $sql_transferir = "UPDATE carrinho SET id_usuario = '$id_usuario' WHERE chave_carrinho_temp = '$chave_carrinho_temp'";
    $conn->query($sql_transferir);
}

// Verificar se o ID do produto foi fornecido
if (isset($_POST['id_produto'])) {
    $id_produto = $_POST['id_produto'];

    if (isset($_SESSION['user_id'])) {
        // Usuário logado
        $id_usuario = $_SESSION['user_id'];

        // Verificar se há um carrinho temporário associado à sessão
        if (isset($_SESSION['chave_carrinho_temp'])) {
            $chave_carrinho_temp = $_SESSION['chave_carrinho_temp'];

            // Transferir itens do carrinho temporário para o carrinho do usuário
            transferirCarrinhoTemporario($conn, $id_usuario, $chave_carrinho_temp);

            // Limpar a chave temporária após a transferência
            unset($_SESSION['chave_carrinho_temp']);
        }

        // Verificar se o produto já está no carrinho do usuário
        $sql_check = "SELECT * FROM carrinho WHERE id_usuario = '$id_usuario' AND id_produto = '$id_produto'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            $row = $result_check->fetch_assoc();
            $quantidade = $row['quantidade'] + 1;

            $sql_update = "UPDATE carrinho SET quantidade = '$quantidade' WHERE id_usuario = '$id_usuario' AND id_produto = '$id_produto'";
            $conn->query($sql_update);
        } else {
            // Se não estiver no carrinho, adiciona ao carrinho do usuário
            $sql_insert = "INSERT INTO carrinho (id_usuario, id_produto, quantidade) VALUES ('$id_usuario', '$id_produto', 1)";
            $conn->query($sql_insert);
        }

        echo "Produto adicionado ao carrinho!";
    } else {
        // Usuário não logado
        if (!isset($_SESSION['chave_carrinho_temp'])) {
            // Se não houver uma chave de carrinho temporário, cria uma
            $_SESSION['chave_carrinho_temp'] = session_id();
        }

        $chave_carrinho_temp = $_SESSION['chave_carrinho_temp'];

        // Verificar se o produto já está no carrinho temporário
        $sql_check_temp = "SELECT * FROM carrinho WHERE chave_carrinho_temp = '$chave_carrinho_temp' AND id_produto = '$id_produto'";
        $result_check_temp = $conn->query($sql_check_temp);

        if ($result_check_temp->num_rows > 0) {
            $row_temp = $result_check_temp->fetch_assoc();
            $quantidade_temp = $row_temp['quantidade'] + 1;

            $sql_update_temp = "UPDATE carrinho SET quantidade = '$quantidade_temp' WHERE chave_carrinho_temp = '$chave_carrinho_temp' AND id_produto = '$id_produto'";
            $conn->query($sql_update_temp);
        } else {
            // Se não estiver no carrinho temporário, adiciona ao carrinho temporário
            $sql_insert_temp = "INSERT INTO carrinho (chave_carrinho_temp, id_produto, quantidade) VALUES ('$chave_carrinho_temp', '$id_produto', 1)";
            $conn->query($sql_insert_temp);
        }

        echo "Produto adicionado ao carrinho (não logado)!";
    }
} else {
    echo "ID do produto não fornecido!";
}

$conn->close();

?>