$(document).ready(function(){
    var currentIndex = 0;
    var maxIndex = $('.small-img').length - 1;

    $('.small-img').click(function(){
        currentIndex = $(this).index();
        var imgSrc = $(this).attr('src');
        $('#mainImg').css('transform', 'scale(0)');
        setTimeout(function(){
            $('#mainImg').attr('src', imgSrc).css('transform', 'scale(1)');
        }, 300);
    });

    $('#prevBtn').click(function(){
        if (currentIndex > 0) {
            currentIndex--;
            var prevImgSrc = $('.small-img').eq(currentIndex).attr('src');
            $('#mainImg').css('transform', 'scale(0)');
            setTimeout(function(){
                $('#mainImg').attr('src', prevImgSrc).css('transform', 'scale(1)');
            }, 300);
        }
    });

    $('#nextBtn').click(function(){
        if (currentIndex < maxIndex) {
            currentIndex++;
            var nextImgSrc = $('.small-img').eq(currentIndex).attr('src');
            $('#mainImg').css('transform', 'scale(0)');
            setTimeout(function(){
                $('#mainImg').attr('src', nextImgSrc).css('transform', 'scale(1)');
            }, 300);
        }
    });

    $('.main-image').click(function(){
        if (!$(this).hasClass('fullscreen')) {
            $(this).addClass('fullscreen');
            $('#mainImg').parent().get(0).requestFullscreen();

            $("#nav-arrows").show();
            $("#fullScreen").text('');
            $("#fullScreen").append('&times;');
        }
    });

    $('.close-btn').click(function(){
        let clickedId = $(this).attr('id');

        if ( !$(".main-image").hasClass('fullscreen') ) {
            $("#fullScreen").text('');
            $("#fullScreen").append('&times;');
        }else{
            $("#fullScreen").text('');
            $("#fullScreen").append('Full');
            $("#nav-arrows").hide();
        }

        $('.main-image').removeClass('fullscreen');
        if (document.fullscreenElement) {
            document.exitFullscreen();

            $("#nav-arrows").hide();
            $("#fullScreen").text('');
            $("#fullScreen").append('Full');
        }
    });

    document.addEventListener('fullscreenchange', function () {
        if (!document.fullscreenElement) {
            $('.main-image').removeClass('fullscreen');

            $("#nav-arrows").hide();
            $("#fullScreen").text('');
            $("#fullScreen").append('Full');
        }
    });
});
