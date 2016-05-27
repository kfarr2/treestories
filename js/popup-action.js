var delay = 2500;

function animateImages(){
    setTimeout(function(){
        if($('#popup-image-container').is(":visible")){
            var count = $('.popup-image').length;
            var push = $('.popup-images').width() - $('#popup-image-container').width();
            $('.popup-images').animate({'left': push * -1}, delay * count, function(){
                setTimeout(function(){
                    $('.popup-images').animate({'left': 0}, delay * count, function(){
                        animateImages();
                    });
                }, delay);
            });
        } else {
            setTimeout(function(){ animateImages(); }, 100);
        }
    }, delay);
}
animateImages();
