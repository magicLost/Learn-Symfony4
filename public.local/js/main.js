$(function(){
    //settings wrapper div
    var winWidth = $(window).width();
    var widthWrapper = ( winWidth * 0.7 < 400) ? 400 : winWidth * 0.7 ;

    const div_change_locale = $('div#div_locale_form');
    //console.log(div_change_locale);

    div_change_locale.css({
        'width': widthWrapper / 13,
        'float': 'right',
        'display': 'block'
    });

    const select = div_change_locale.find('select');

    select.on('change', function (event) {

        select.parent().submit();

    });

    //console.log(winWidth);

    $('div#wrapper').css({
        'width': widthWrapper,
        'display': 'block'
    });



});

