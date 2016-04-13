/*  Big complicated function to move the "cards"
 *  around on the page and keep them looking nice.
 *
 *  Currently works by computing the size of the screen,
 *  and how many cards will fit per row. It then takes each
 *  "row" of cards and finds the one with the largest
 *  vertical offset. This is used to compute how far the rest
 *  of the cards in the row will have to be pushed up in order
 *  to appear as though they just stack on eachother.
 *
 *  Each card in the row then has its css attributes modified
 *  to push it up to the bottom of the previous row.
 *
 */
function moveCards(){
    // Compute the screen width, card widths, padding (the space
    // between the sides of the page and the cards), top_padding
    // (space between the top of one row and the bottom of the next),
    // number of cards per row, total number of cards, and number of rows.
    var num_cards = $('.card').length;
    var screen_width = $(document).width();
    var card_width = $('.card').width();
    if(num_cards > 0){
        var padding = parseInt($('.card').css('margin-left').slice(0, -2))*2;
        var top_padding = parseInt($('.card').css('margin').slice(0, -2));
        var num_cards_per_row = Math.floor(screen_width / (card_width + padding));
        var num_rows = Math.ceil(num_cards / num_cards_per_row);
    }

    var rows = new Array();

    // Put all the cards in an array
    $('.card').each(function(){rows.push($(this))});
    var previous_row_push = new Array();
    for(i=0; i < num_cards_per_row; i++){
        previous_row_push.push(0);
    }
    for(i = 0; i < num_rows; i++){
        var this_row = [];
        for(j = 0; j < num_cards_per_row; j++){
            var card = rows[(i*num_cards_per_row)+j];
            if(card){
                this_row.push(card);
            }
        }
        // Find the tallest card in each row
        max_height = findTallest(this_row);
        for(j=0; j < num_cards_per_row; j++){
            if(this_row[j]){
                var card_height = this_row[j].height();
                var push = (max_height - (card_height)) * -1;
                if(push != 0){
                    push += top_padding;
                }
                this_row[j].css('margin-top', previous_row_push[j] + top_padding);
                previous_row_push[j] += push;
            }
        }
    }
    var card_count = 0;
    if(num_cards < num_cards_per_row){
        card_count = num_cards;
    } else {
        card_count = num_cards_per_row;
    }
    var margin = screen_width - (card_count * (card_width + padding));
    $("#cards-container").css('margin-left', margin/2 - padding);
}
moveCards();

function findTallest(cards){
    var max_height = 0;
    var max_offset = 0;
    $(cards).each(function(e){
        var this_height = $(this).height();
        var this_offset = $(this)[0].offsetHeight;
        if(this_offset > max_offset){
            max_height = this_height;
            max_offset = this_offset;
        }
    });
    return max_height;
}

$(window).resize(function(){moveCards();});
$("#message-banner").on('closed.bs.alert', function(){ moveCards(); });

function resizeSearchForm(){
    $("#searchform").width($("#searchform").parent().width() - $("#search-buttons").width() - 30);
}
resizeSearchForm();

$(document).ready(function(e){
    $("#cards-container").css('visibility', 'visible');
});
