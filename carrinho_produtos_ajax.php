<?php
session_start();

// Conecta ao banco de dados - substitua pelos seus próprios detalhes de conexão
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        throw new Exception("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Inicializa o ID do usuário e a chave do carrinho temporário como nulos
    $id_usuario = null;
    $chave_carrinho_temp = null;

    // Verifica se o usuário está autenticado
    if (isset($_SESSION['user_id'])) {
        $id_usuario = $_SESSION['user_id']; // Ajuste com o nome correto do seu campo id_usuario
    } elseif (isset($_SESSION['chave_carrinho_temp'])) {
        $chave_carrinho_temp = $_SESSION['chave_carrinho_temp']; // Ajuste com o nome correto do seu campo chave_carrinho_temp
    }

    // Atualiza imediatamente o carrinho após o login
    if ($id_usuario !== null) {
        $conn->query("UPDATE carrinho SET id_usuario = $id_usuario WHERE id_usuario IS NULL");
    } elseif ($chave_carrinho_temp !== null) {
        if ($id_usuario !== null) {
            $updateChaveTemp = "UPDATE carrinho SET id_usuario = $id_usuario WHERE chave_carrinho_temp = ?";
            
            // Prepara a consulta
            $stmt = $conn->prepare($updateChaveTemp);
            
            // Vincula os parâmetros
            $stmt->bind_param("s", $chave_carrinho_temp);
            
            // Executa a consulta preparada
            if (!$stmt->execute()) {
                throw new Exception("Erro na atualização do carrinho temporário: " . $stmt->error);
            }
            
            // Fecha a declaração preparada
            $stmt->close();
        } else {
            // Se o usuário não estiver autenticado, atualize apenas com a chave temporária
            $conn->query("UPDATE carrinho SET id_usuario = NULL WHERE chave_carrinho_temp = '$chave_carrinho_temp'");
        }
    }

    // Adiciona ou remove um item do carrinho
    if (isset($_POST['action']) && isset($_POST['produto_id'])) {
        $produto_id = $_POST['produto_id'];
        $action = $_POST['action'];

        if ($id_usuario !== null) {
            // Lógica do carrinho para usuário autenticado
            if ($action === 'adicionar') {
                $conn->query("UPDATE carrinho SET quantidade = quantidade + 1 WHERE id_usuario = $id_usuario AND id_produto = $produto_id");
            } elseif ($action === 'remover') {
                $conn->query("UPDATE carrinho SET quantidade = quantidade - 1 WHERE id_usuario = $id_usuario AND id_produto = $produto_id");
            } elseif ($action === 'excluir') {
                $conn->query("DELETE FROM carrinho WHERE id_usuario = $id_usuario AND id_produto = $produto_id");
            } elseif ($action === 'atualizar') {
                // Adiciona a lógica para atualizar a quantidade
                $novaQuantidade = isset($_POST['nova_quantidade']) ? $_POST['nova_quantidade'] : 1;
                $conn->query("UPDATE carrinho SET quantidade = $novaQuantidade WHERE id_usuario = $id_usuario AND id_produto = $produto_id");
            }

        } else {
            // Lógica do carrinho para usuário não autenticado
            $chave_carrinho_temp = isset($_SESSION['chave_carrinho_temp']) ? $_SESSION['chave_carrinho_temp'] : null;

            if ($chave_carrinho_temp === null) {
                // Se não houver uma chave temporária, crie uma nova
                $chave_carrinho_temp = uniqid('temp_', true);
                $_SESSION['chave_carrinho_temp'] = $chave_carrinho_temp;

                // Insira o item no carrinho temporário
                $conn->query("INSERT INTO carrinho (chave_carrinho_temp, id_produto, quantidade) VALUES ('$chave_carrinho_temp', $produto_id, 1)");

            } else {
                // Se a chave temporária já existir, atualize o carrinho temporário
                if ($action === 'adicionar') {
                    $conn->query("UPDATE carrinho SET quantidade = quantidade + 1 WHERE chave_carrinho_temp = '$chave_carrinho_temp' AND id_produto = $produto_id");
                } elseif ($action === 'remover') {
                    $conn->query("UPDATE carrinho SET quantidade = quantidade - 1 WHERE chave_carrinho_temp = '$chave_carrinho_temp' AND id_produto = $produto_id");
                } elseif ($action === 'excluir') {
                    $conn->query("DELETE FROM carrinho WHERE chave_carrinho_temp = '$chave_carrinho_temp' AND id_produto = $produto_id");
                } elseif ($action === 'atualizar') {
                    // Adiciona a lógica para atualizar a quantidade
                    $novaQuantidade = isset($_POST['nova_quantidade']) ? $_POST['nova_quantidade'] : 1;
                    $conn->query("UPDATE carrinho SET quantidade = $novaQuantidade WHERE chave_carrinho_temp = '$chave_carrinho_temp' AND id_produto = $produto_id");
                }
            }
        }
    }

    $sql = "SELECT produtos.foto_produto, produtos.nome_produto AS nome_produto, produtos.preco, carrinho.quantidade, carrinho.id_produto
            FROM carrinho
            INNER JOIN produtos ON carrinho.id_produto = produtos.id_produto";

    // Se o usuário estiver autenticado, adiciona a condição para o ID do usuário
    if ($id_usuario !== null) {
        $sql .= " WHERE carrinho.id_usuario = $id_usuario";
    }

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Erro na execução da consulta: " . $conn->error);
    }

    // Constrói um array com os resultados
    $produtos = array();
    while ($row = $result->fetch_assoc()) {
        $produtos[] = $row;
    }

    // Fecha a conexão com o banco de dados
    $conn->close();

    // Retorna o array como JSON
    header('Content-Type: application/json');
    echo json_encode($produtos);

    // Verifica se é uma ação de logout e esvazia o carrinho
    if (isset($_POST['action']) && $_POST['action'] === 'logout') {
        // Limpa as variáveis de sessão relacionadas ao carrinho
        unset($_SESSION['user_id']);
        unset($_SESSION['chave_carrinho_temp']);

        // Esvazia o carrinho no banco de dados
        $conn->query("DELETE FROM carrinho WHERE id_usuario IS NULL AND chave_carrinho_temp IS NULL");
    }

} catch (Exception $e) {
    echo json_encode(array('erro' => $e->getMessage()));
}
?>