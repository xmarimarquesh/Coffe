// cart.js
document.addEventListener("DOMContentLoaded", function () {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', addToCart);
    });

    function addToCart(event) {
        event.preventDefault();
        const productId = event.target.getAttribute('data-id');

        // Envie uma solicitação AJAX para adicionar o produto ao carrinho
        // Aqui você precisará usar uma biblioteca como jQuery ou o objeto XMLHttpRequest

        // Exemplo usando jQuery
        $.ajax({
            url: 'adicionar_ao_carrinho.php',
            method: 'POST',
            data: { productId: productId },
            success: function (response) {
                // Atualize o carrinho flutuante com as informações do banco de dados
                // Você pode usar outra solicitação AJAX para obter os dados do carrinho
            }
        });
    }
});
