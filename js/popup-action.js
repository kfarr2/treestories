var delay = 2500;

function animateImages(){
    setTimeout(function(){
        if($('#popup-image-container').is(":visible")){
            var count = $('.popup-image').length;
            if(count > 2){
                var push = $('.popup-images').width() - $('#popup-image-container').width();
                $('.popup-images').animate({'left': push * -1}, delay * count, function(){
                    setTimeout(function(){
                        $('.popup-images').animate({'left': 0}, delay * count, function(){
                            animateImages();
                        });
                    }, delay);
                });
            } else {
                var push = (($('.popup-images').width()) - $('#popup-image-container').width())/-2;
                $('.popup-images').css('left', push);
            }
        } else {
            setTimeout(function(){ animateImages(); }, 100);
        }
    }, delay);
}
animateImages();
