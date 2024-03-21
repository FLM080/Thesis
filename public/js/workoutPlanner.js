let movedCards = [];

function moveCard(card) {
    if ($(card).closest('.wrapper-left').length) {
        $(card).appendTo('.wrapper-right');
        let cardId = $(card).data('id');
        let index = movedCards.indexOf(cardId);
        if (index > -1) {
            movedCards.splice(index, 1);
        }
    } else if ($(card).closest('.wrapper-right').length) {
        $(card).appendTo('.wrapper-left');
        let cardId = $(card).data('id');
        movedCards.push(cardId);
    }
}
$(document).ready(function() {
    $('.saveExercise').click(function() {
        $.ajax({
            url: '/saveMovedCards', 
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                moved: movedCards
            },
            success: function(response) {
                console.log(response);
            },
            error: function(response) {
                console.log(response);
            }
        });
    });
});