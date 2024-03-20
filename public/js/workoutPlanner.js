function moveCard(card) {
    if ($(card).closest('.wrapper-left').length) {
        $(card).appendTo('.wrapper-right');
    } else if ($(card).closest('.wrapper-right').length) {
        $(card).appendTo('.wrapper-left');
    }
}