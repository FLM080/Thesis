function moveCard(card) {
    if ($(card).closest('.wrapper-left').length) {
        // Move the card to the right
        $(card).appendTo('.wrapper-right');
    } else if ($(card).closest('.wrapper-right').length) {
        // Move the card to the left
        $(card).appendTo('.wrapper-left');
    }
}