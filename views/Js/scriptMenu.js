document.addEventListener('DOMContentLoaded', function () {
    var cards = document.querySelectorAll('.card');
    
    cards.forEach(function (card) {
        card.addEventListener('click', function () {
            // Remove a classe 'clicked' de todos os cards
            cards.forEach(function (c) {
                c.classList.remove('clicked');
            });
            
            // Adiciona a classe 'clicked' ao card clicado
            card.classList.add('clicked');
        });
    });
});

