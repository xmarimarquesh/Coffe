<?php
session_start();
include_once('classes/Usuario.php');
include_once('conexao/conexao.php');  // Certifique-se de corrigir o caminho para o arquivo de conexão.

// Crie uma instância da classe Conexao
$conexao = new Conexao();
$db = $conexao->getConnection();

$usuario = new Usuario($db);
$usuario_id = $_SESSION['user_id'];  // Você já tem o ID do usuário na sessão.

// Consulta SQL para obter o CEP do usuário logado
$consulta = "SELECT cep, rua, numero_casa FROM usuarios WHERE id = $usuario_id";
$stmt = $db->prepare($consulta);
$stmt->execute();

// Verifica se a consulta foi bem-sucedida
if ($stmt) {
    $dados_usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    $cep = $dados_usuario['cep'];
    $rua = $dados_usuario['rua'];
    $numero_casa = $dados_usuario['numero_casa'];
} else {
    // Lidar com erros de consulta, se necessário
    $cep = '';
    $rua = '';
    $numero_casa = '';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Galada&family=Josefin+Sans:wght@300;400&family=Josefin+Slab&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Finalizar Compra</title>
    <link rel="stylesheet" href="css/finalizar_compra.css">
</head>

<body>


    <form action="" method="POST">
        <div id="form-pagamento">

            <h1>Finalizar Pedido</h1>
            <label><strong>Confirmar endereço</strong></label>
            <input id="cep" type="text" name="cep" value="<?php echo htmlspecialchars($cep); ?>">
            <input id="rua" type="text" name="rua" value="<?php echo htmlspecialchars($rua); ?>">
            <input id="numero_casa" type="text" name="numero_casa" value="<?php echo htmlspecialchars($numero_casa); ?>">

            <select id="forma-pagamento" name="pagamento" onchange="mostrarTroco()">
            <option value="#">Selecione a forma de pagamento</option>
                <option value="debito">Débito</option>
                <option value="credito">Crédito</option>
                <option value="pix">PIX</option>
                <option value="dinheiro">Dinheiro</option>
            </select>
            <p style="color:red; font-size:.9em; margin-top:2%;">***O pagamento é efetuado apenas através do ENTREGADOR</p>
            

            <div id="campo-troco" style="display:none;">
                <label for="troco"><strong>Troco para:</strong></label>
                <input type="number" id="troco" name="troco" placeholder="Nota para troco">
            </div>

            <label><strong>Seu WhatsApp:</strong></label>
            <input type="text" id="whatsapp" name="whatsapp" placeholder="Digite seu número de WhatsApp">

            <label for="observacoes"><strong>Observações:</strong></label>
            <input type="text" id="observacoes" name="obs" placeholder="exemplos (sem chantilly, entrega perto do mercado Açaí...)">

            <button onclick="finalizarCompra()">Finalizar Compra</button>
            <a href="index.php">Voltar</a>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function mostrarTroco() {
            var formaPagamento = document.getElementById("forma-pagamento");
            var campoTroco = document.getElementById("campo-troco");

            if (formaPagamento.value === "dinheiro") {
                campoTroco.style.display = "block";
            } else {
                campoTroco.style.display = "none";
            }
        }



        function finalizarCompra() {
            var formaPagamento = document.getElementById("forma-pagamento").value;
            var observacoes = document.getElementById("observacoes").value;
            var whatsapp = document.getElementById("whatsapp").value;
            var troco = document.getElementById("troco").value;
            var cep = document.getElementById("cep").value;
            var rua = document.getElementById("rua").value;
            var numero_casa = document.getElementById("numero_casa").value;

            $.ajax({
                type: "POST",
                url: "processarCompra.php",
                data: {

                    forma_pagamento: formaPagamento,
                    whatsapp: whatsapp,
                    observacoes: observacoes,
                    troco: troco,
                    cep: cep,
                    rua: rua,
                    numero_casa: numero_casa
                },
                success: function(response) {
                    // Você pode lidar com a resposta aqui se necessário

                    // Redirecione para a página index.php após o sucesso

                    alert("Pedido realizado com sucesso!");

                    window.location.href = 'index.php';
                }
            });
        }
    </script>

</body>

</html>