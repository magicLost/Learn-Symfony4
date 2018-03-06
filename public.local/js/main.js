$(function(){
    //settings wrapper div
    var winWidth = $(window).width();
    var widthWrapper = ( winWidth * 0.7 < 400) ? 400 : winWidth * 0.7 ;

    console.log(winWidth);

    $('div#wrapper').css({
        'width': widthWrapper
    });



});

