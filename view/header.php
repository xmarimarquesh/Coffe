<style>
    @import url('https://fonts.googleapis.com/css2?family=Galada&family=Italianno&family=Josefin+Slab&display=swap');

    * {
        font-family: 'Josefin Slab', serif;
        margin: 0;
    }

    #ola {
        color: rgb(204, 204, 204);
        font-size: 1.5em;
    }

    #nav1 {
        color: #c9c692;
    }

    #log,
    #lo,
    #pessoa,
    #not {
        color: #c9c692;
        font-size: 1.5em;
        margin: 1EM;
    }

    .collapse {
        --bs-navbar-nav-link-padding-x: 3em;
    }

    .collapse a {
        color: white;
    }

    .titulo {
        margin: 0;
    }

    #nav1 {
        background: rgb(255, 255, 255);
        background: linear-gradient(0deg, rgba(255, 255, 255, 0) 0%, rgba(21, 13, 0, 1) 100%);
    }

    #carrinho-produtos li img {
        width: 10%;
        height: auto;
    }

    .mb-3 {
        position: relative;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
    }

    #botao {
        position: absolute;
        top: 50%;
        right: 50rem;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .modal-footer btn-primary {
        background-color: #7C573E !important;
        color: white !important;
    }

    .modal-footer btn-secondary {
        background-color: white !important;
        color: #7C573E !important;
    }



    .modal-footer button:hover {

        background-color: #b78c6f !important;
        color: white !important;
    }

    #carrinho-produtos td img {
        width: 70%;
    }

    .car {
        display: flex;
        align-items: center;
        width: 55PX;
        font-weight: bold;
    }



    .car button {
        font-family: 'Josefin Slab', serif;
        text-decoration: none;
        background-color: #7C573E;
        margin: 10%;
        color: white;
        font-weight: bold;
        border: none;
        width: 55%;
        align-items: center;
        justify-content: center;
        display: flex;
    }

    .prod {
        display: flex;
        align-items: center;
        width: 100%;
        font-size: 1.3em;
    }

    .prod td {
        margin: 2%;
    }

    #excluir {
        background-color: transparent;
        text-decoration: none;
        border: none;
        color: red;
    }

    #ad {
        border-radius: 50% 0 0 50%;
    }

    #re {
        border-radius: 0 50% 50% 0;
    }

    .linha-divisao {
        border: none;
        /* Remove a borda padrão da linha */
        height: 2px;
        /* Cor de fundo da linha */
    }

    form button {
        float: right;
        margin: 1%;
    }

    .detalhesPedido #mostrar_prod {
        background-color: #DED4BD;
        padding: 5px;
        width: 100%;
        font-weight: bold;
    }

    .detalhesPedido {
        font-size: 1.2em;
    }

    .produtu {
        margin-top: 1%;
        display: flex;
        flex-direction: column;
    }



    .produtu img {
        width: 20% !important;
        height: auto !important;
    }

    #fim-prod{
        color: red;
        border: none;
        font-size: 1em;

    }

    .final-pedido{
        display: flex;
        justify-content: flex-end;
    }
</style>

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>




<header>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top " id="nav1">

        <div class="container">

            <a class="navbar-brand " href="index.php">
                <img src="img/logo.png" alt="Bootstrap" width="80" height="80">
            </a>
            <div class="collapse navbar-collapse pl-5" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 fs-5">
                    <li class="nav-item">
                        <a id="inicio" class=" nav-link " href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a id="produtos" class="  nav-link" href="produtos.php">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a id="sobre" class=" nav-link" href="sobre.php">Sobre nós</a>
                    </li>
                </ul>

            </div>

            <div class="icons">



                <?php
                include_once('classes/Usuario.php');
                $crud = new Usuario($db);

                if (isset($_GET['action']) && $_GET['action'] == 'updateUser') {
                    if (isset($_POST['id'])) {
                        $crud->updateUser($_POST);
                    }
                }


                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }



                if (!empty($_SESSION['email'])) {
                    $usuario = new Usuario($db);
                    $userData = $usuario->readOne($_SESSION['user_id']);
                    // Verifica se os dados do usuário foram obtidos
                    if ($userData) {
                        $id = isset($userData['id']) ? $userData['id'] : '';
                        $nome = $userData['nome'];
                        $email = $userData['email'];
                        $cep = $userData['cep'];
                        $rua = $userData['rua'];
                        $numero_casa = $userData['numero_casa'];
                    }

                    $login = $_SESSION['email'];
                    $usuario = new Usuario($db);
                    $isAdmin = $usuario->verificarAdm($login);
                    $id = $_SESSION['user_id'];

                    if ($isAdmin) {

                ?>
                        <a id="ola">
                            <?php echo 'Olá, ' . ucfirst($_SESSION['nome']) . '!'; ?>
                        </a>
                        <a class="navbar-brand " id="not" href="">
                            <i class="material-symbols-outlined">notifications</i></a>
                        <a class="navbar-brand " id="lo" href="dashboard-admin.php">
                            <i class="material-symbols-outlined">settings</i></a>
                        <a class="navbar-brand " id="lo" href="logout.php">
                            <i class="material-symbols-outlined">logout</i></a>
                    <?php

                    } else if (!$isAdmin) {
                    ?>
                        <a id="ola">
                            <?php echo 'Olá, ' . ucfirst($_SESSION['nome']) . '!'; ?>
                        </a>

                        <a class="navbar-brand " id="pessoa" href="?action=updateUser&id= . $id">
                            <i class="material-symbols-outlined">person</i></a>
                        <a class="navbar-brand " id="not" href="">
                            <i class="material-symbols-outlined">notifications</i></a>
                        <a class="navbar-brand" id="carrinho-btn" href="#" style="color: #c9c692; margin: 1EM;"> <span id="carrinho-contador">0</span>
                            <i class="material-icons">shopping_cart</i></a>
                        <a class="navbar-brand " id="lo" href="logout.php">
                            <i class="material-symbols-outlined">logout</i></a>

                    <?php
                    }
                } else { ?>
                    <a class="navbar-brand " href="login.php">
                        <i class="material-symbols-outlined" id="log">person</i></a>
                    <a class="navbar-brand" id="carrinho-btn" href="#" style="color: #c9c692; margin: 1EM;"> <span id="carrinho-contador">0</span>
                        <i class="material-icons">shopping_cart</i>
                    </a>
                <?php
                }

                ?>



            </div>
        </div>
    </nav>


    <div class="modal fade" id="carrinhoModal" tabindex="-1" aria-labelledby="carrinhoModalLabel" aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="carrinhoModalLabel">Carrinho de Compras</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <!-- Aqui você pode exibir os itens do carrinho -->
                    <!-- Exemplo: -->
                    <ul id="carrinho-produtos">

                        <!-- ... Adicione dinamicamente os itens do carrinho aqui ... -->
                    </ul>
                </div>

                <div class="modal-footer">
                    <div id="mensagemAviso" style="display: none; background-color: #EAEAEA; color: #333; padding: 10px; 
border-radius: 10px;
 ">
                        <p>Você precisa estar logado para finalizar o pedido. <a href="login.php">Ir para o Login</a></p>
                    </div>
                    <div id="mensagemAviso2" style="display: none; background-color: #EAEAEA; color: #333; padding: 10px; 
border-radius: 10px;">
                        <p>Não há produtos para finalizar este pedido. <a href="produtos.php">Ver produtos</a></p>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Finalizar Compra</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="pedidoModal" tabindex="-1" aria-labelledby="pedidoModalLabel" aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="pedidoModalLabel">Seus Pedidos</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <div id="detalhesPedido">
                        <p>Não há pedidos no momento...</p>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="window.location.href='https://wa.me/5541997504019?text=Ol%C3%A1%21'">Entre em contato</button>
                </div>
            </div>
        </div>
    </div>

    <?php


    if (isset($_POST['enviar']) && $_POST['enviar'] == 'Atualizar') {
        $postValues = array(
            'id' => $_POST['id'],
            'nome' => $_POST['nome'],
            'email' => $_POST['email'],
            'cep' => $_POST['cep'],
            'rua' => $_POST['rua'],
            'numero_casa' => $_POST['numero_casa']
            // ... outros campos, se houver
        );

        // Chamar o método update da classe Usuario
        $usuario = new Usuario($db);
        $updateResult = $usuario->updateUser($postValues);

        // Atualizar as variáveis $nome e $email se a atualização for bem-sucedida
        if ($updateResult) {
            $id = $postValues['id'];
            $nome = $postValues['nome'];
            $email = $postValues['email'];
            $cep = $postValues['cep'];
            $rua = $postValues['rua'];
            $numero_casa = $postValues['numero_casa'];

            echo "Atualização bem-sucedida!";
        } else {
            echo "Erro na atualização!";
        }
    }
    ?>

    <div class="modal fade" id="pessoaModal" tabindex="-1" aria-labelledby="pessoaModalLabel" aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="pessoaModalLabel">Editar Perfil</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">

                    <form action="?action=updateUser" method="POST">

                        <input type="hidden" name="id" value="<?php echo $id ?>">

                        <div class="mb-3">
                            <label for="nome_usuario" class="form-label">Nome</label>
                            <input type="text" value="<?php echo htmlspecialchars($nome); ?>" name="nome" class="form-control" id="nomezinho" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" value="<?php echo htmlspecialchars($email); ?>" name="email" class="form-control" required>
                        </div>
                        <div class="cep-tab">

                            <div class="cep-content">
                                <div class="input-box">
                                    <label class="form-label">Endereço</label>
                                    <div class="mb-3" id="cep">
                                        <input name="cep" id="cep" placeholder="CEP" type="text" value="<?php echo htmlspecialchars($cep); ?>" name="cep" class="form-control" required>
                                    </div>

                                </div>

                                <div class="mb-3">
                                    <input type="text" value="<?php echo htmlspecialchars($rua); ?>" name="rua" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" value="<?php echo htmlspecialchars($numero_casa); ?>" name="numero_casa" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <button value="?action=updateUser&id= $id" class="btn btn-primary" type="submit" name="enviar" onclick="return confirm('Certeza que deseja atualizar?')">Atualizar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>

                    </form>

                    <?php




                    ?>
                </div>


                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</header>


<script>
    $(document).ready(function() {
        // Manipulador de clique para o ícone de pessoa (usuário logado)
        $('#pessoa').on('click', function(e) {
            e.preventDefault(); // Impede a ação padrão do link
            var myModal = new bootstrap.Modal(document.getElementById('pessoaModal'));
            myModal.show();
        });

        // Manipulador de clique para o ícone de pessoa (usuário não logado)

    });

    $(document).ready(function() {
        // Manipulador de clique para o ícone de pessoa (usuário logado)
        $('#not').on('click', function(e) {
            e.preventDefault(); // Impede a ação padrão do link
            var myModal = new bootstrap.Modal(document.getElementById('pedidoModal'));
            myModal.show();
        });

        // Manipulador de clique para o ícone de pessoa (usuário não logado)

    });

    // Adicione um ouvinte de evento ao botão
    $(document).ready(function() {
        $('#carrinho-btn').on('click', function(e) {
            e.preventDefault();
            var myModal = new bootstrap.Modal(document.getElementById('carrinhoModal'));
            myModal.show();
        });
    });

    function atualizarCarrinho() {
        $.ajax({
            url: 'carrinho_produtos_ajax.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                atualizarContadorForaAjax();
                exibirProdutos(data);
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    function interagirCarrinho(action, produto_id) {
        $.ajax({
            url: 'carrinho_produtos_ajax.php',
            type: 'POST',
            data: {
                action: action,
                produto_id: produto_id
            },
            success: function() {
                atualizarCarrinho();
            },
            error: function(error) {
                console.error(error);
            }
        });
    }


    function atualizarQuantidade(produto_id, novaQuantidade) {
        $.ajax({
            url: 'carrinho_produtos_ajax.php',
            type: 'POST',
            data: {
                action: 'atualizar',
                produto_id: produto_id,
                nova_quantidade: novaQuantidade
            },
            success: function() {
                atualizarCarrinho();
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    function exibirProdutos(produtos) {
        var carrinhoDiv = $('#carrinho-produtos');
        carrinhoDiv.empty();

        if (produtos.length === 0) {
            carrinhoDiv.append('<p>O carrinho está vazio.</p>');
        } else {
            var tabela = $('<table>');

            var totalCarrinho = 0;

            $.each(produtos, function(index, produto) {
                var linha = $('<tr class="prod">'); // Use <tr> para representar uma linha na tabela
                linha.append('<td style="width: 120px; height=120px;"><img src="' + produto.foto_produto + '"></td>');
                linha.append('<td style="width: 200px;"><div class="info-produto">' +
                    '<div class="nome-produto">' + produto.nome_produto + '</div>' +
                    '<div class="preco-produto">R$' + (produto.preco * produto.quantidade).toFixed(2) + '</div>' +
                    '</div></td>');
                linha.append('<td><div class="car">' +
                    '<button id="ad" onclick="interagirCarrinho(\'adicionar\', ' + produto.id_produto + ')">+</button>' +
                    produto.quantidade +
                    (produto.quantidade > 1 ? '<button id="re" onclick="interagirCarrinho(\'remover\', ' + produto.id_produto + ')">-</button>' : '<button id="re" disabled>-</button>') +
                    '</div></td>' +
                    '<td><button id="excluir" onclick="interagirCarrinho(\'excluir\', ' + produto.id_produto + ')">Excluir</button>' +
                    '</td>');
                tabela.append(linha);
                tabela.append('<tr class="linha-divisao"><td colspan="4"><hr></td></tr>');
                totalCarrinho += produto.preco * produto.quantidade;
            });



            tabela.append('<tr><td style="font-size: 1.3em;"><strong>R$' + totalCarrinho.toFixed(2) + '</strong></td></tr>');
            carrinhoDiv.append(tabela);

        }
    }

    $(document).ready(function() {
        // ...

        // Manipulador de clique para o botão "Finalizar Compra"
        $('#carrinhoModal').on('click', '.btn-primary', function() {
            // Verificar se o usuário está logado
            <?php if (empty($_SESSION['email'])) { ?>
                // Se não estiver logado, exibir mensagem
                $('#mensagemAviso').show();
            <?php } else { ?>
                // Se estiver logado, verificar se há produtos no carrinho
                var totalProdutos = $('#carrinho-produtos').find('tr.prod').length;
                if (totalProdutos === 0) {
                    // Não há produtos no carrinho
                    $('#mensagemAviso2').show();
                } else {
                    // Há produtos no carrinho, prosseguir com a finalização da compra
                    window.location.href = 'pagina_finalizar_compra.php';
                    $('#mensagemAviso').hide();

                    // Fechar o modal
                    var myModal = new bootstrap.Modal(document.getElementById('carrinhoModal'));
                    myModal.hide();
                }
            <?php } ?>
        });

        var urlAtual = window.location.href;

        // Verifica se a URL contém uma parte específica
        if (urlAtual.indexOf('/um-produto.php') !== -1) {
            // A pessoa está na página específica
            // Execute o código para ocultar a funcionalidade aqui
            document.getElementById('pessoa').style.display = 'none';
        }
    });

    // Carregue o carrinho inicialmente
    atualizarCarrinho();

    $('#ola').text('Olá, ' + $('#nomezinho').val() + " !");

    $('#cep').blur(function() {
        // Obtém o valor do CEP
        var cep = $(this).val().replace(/\D/g, '');

        // Verifica se o CEP possui 8 caracteres
        if (cep.length == 8) {
            // Faz a requisição à API ViaCEP
            $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(data) {
                // Preenche os campos com os dados retornados pela API
                $('#rua').val(data.logradouro);
                // Outros campos podem ser preenchidos da mesma forma, conforme necessário
            });
        }
    });

    // Chamar a função para atualizar o contador fora da chamada AJAX
    atualizarContadorForaAjax();

    function atualizarContadorForaAjax() {
        $.ajax({
            type: 'POST',
            url: 'carrinho_produtos_ajax.php',
            dataType: 'json',
            success: function(data) {
                $('#carrinho-contador').text(parseInt(data.length));
            },
            error: function(xhr, status, error) {
                console.error('Erro na requisição Ajax: ' + status + ' - ' + error);
            }
        });
    }



    $(document).ready(function() {
    var isAdmin = <?php echo isset($isAdmin) && $isAdmin ? 'true' : 'false'; ?>;
    $.ajax({
        url: 'get_pedido.php',
        type: 'GET',
        dataType: 'json',
        data: { isAdmin: isAdmin },
        success: function(data) {
            var modalBody = $('#pedidoModal .modal-body');
            modalBody.empty();

            if (data.length > 0) {
                data.forEach(function(pedido) {
                    var htmlPedido = '<div class="detalhesPedido">' +
                        '<p><strong>Preço Total:</strong> ' + pedido.preco_total + '</p>' +
                        '<p><strong>Rua:</strong> ' + pedido.rua + '</p>';

                    // Adiciona informações adicionais apenas se o usuário for um administrador
                    if (isAdmin) {
                        htmlPedido += '<p><strong>Número da Casa:</strong> ' + pedido.numero_casa + '</p>' +
                            '<p><strong>WhatsApp:</strong> ' + pedido.whats + '</p>' +
                            '<p><strong>Nome do Usuário:</strong> ' + pedido.nome_usuario + '</p>' +
                            '<p><strong>Observação:</strong> ' + pedido.obs + '</p>' +
                            '<p><strong>Troco:</strong> ' + pedido.troco + '</p>' +
                            '<p><strong>Data do Pedido:</strong> ' + pedido.data_pedido + '</p>' +
                            '<div class="final-pedido">' +
                            '<button class="btn finalizarPedidoBtn" id="fim-prod" data-id-pedido="' + pedido.id_pedido + '">Pedido concluído</button>'+
                            '</div>';
                    }

                    htmlPedido += 
                        '<button class="btn mostrarProdutosBtn" id="mostrar_prod">Visualizar Produtos ⇩</button>' +
                        '<ul class="pedido-produtos" style="display: none;">' +
                        '<p><strong>Método de Pagamento:</strong> ' + pedido.metodo_pagamento + '</p>';

                    pedido.produtos.forEach(function(produto) {
                        htmlPedido +=
                            '<div class="produtu">' +
                            '<img src="' + produto.foto_produto + '" alt="' + produto.nome_produto + '" style="width: 50px; height: 50px;"> ' +
                            '<div class="produ">  <strong>' + produto.nome_produto + '</strong>  ' +
                            produto.quantidade + 'x' +
                            '  R$' + produto.preco +
                            '</div>';
                        '</div>';
                    });

                    htmlPedido += '</ul></div>';

                    htmlPedido += '<tr class="linha-divisao"><td colspan="4"><hr></td></tr>';

                    modalBody.append(htmlPedido);
                });

                // Adiciona evento de clique para finalizar pedido
                $('.finalizarPedidoBtn').click(function() {
    var idPedido = $(this).data('id-pedido');

    // Confirmação antes de excluir o pedido
    $('.finalizarPedidoBtn').click(function() {
    var idPedido = $(this).data('id-pedido');
    var btnFinalizarPedido = $(this); // Mantenha uma referência ao botão para removê-lo posteriormente

    // Confirmação antes de excluir o pedido
    $.ajax({
            url: 'get_pedido.php',
            type: 'GET',
            dataType: 'json',
            data: { isAdmin: true, finalizarPedido: idPedido },
            success: function(response) {
                // Atualiza a interface ou realiza outras ações necessárias
                console.log('Pedido finalizado com sucesso:', response);
                alert('Pedido concluído com sucesso!');
                // Remove o pedido da interface
                btnFinalizarPedido.closest('.detalhesPedido').remove();
            },
            error: function(error) {
                console.log('Erro ao finalizar pedido:', error);
            }
        });
});
});

                // Adiciona evento de clique para mostrar produtos
                $('.mostrarProdutosBtn').click(function() {
                    $(this).next('.pedido-produtos').toggle();
                });
            } else {
                modalBody.append('<p>Nenhum pedido encontrado para o usuário.</p>');
            }
        },
        error: function(error) {
            console.log('Erro ao obter dados do pedido:', error);
        }
    });
});


</script>