$(document).ready(function(){
    var currentIndex = 0;
    var maxIndex = $('.small-img').length - 1;
    var intervalId; // Variable to hold the interval ID

    $('.small-img').click(function(){
        stopInterval(); // Stop the interval when a small image is clicked
        currentIndex = $(this).index();
        var imgSrc = $(this).attr('src');
        $('#mainImg').fadeOut(300, function() { // Fade out the main image
            $(this).attr('src', imgSrc).fadeIn(300); // Set new image source and fade in
        });
        // Remove focus from previously focused image and add focus to the current one
        $('.small-img').removeClass('focused');
        $(this).addClass('focused');
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
            stopInterval();
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
            stopInterval();
            $("#fullScreen").text('');
            $("#fullScreen").append('&times;');
        }else{
            startInterval();
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
            startInterval();
            $('.main-image').removeClass('fullscreen');

            $("#nav-arrows").hide();
            $("#fullScreen").text('');
            $("#fullScreen").append('Full');
        }
    });


    // Start changing image at regular intervals
    // Function to change the image at regular intervals
    function changeImage() {
        currentIndex = (currentIndex + 1) % (maxIndex + 1); // Update current index cyclically
        var imgSrc = $('.small-img').eq(currentIndex).attr('src');
        $('#mainImg').fadeOut(300, function() { // Fade out the main image
            $(this).attr('src', imgSrc).fadeIn(300); // Set new image source and fade in
        });
        // Remove focus from previously focused image and add focus to the current one
        $('.small-img').removeClass('focused');
        $('.small-img').eq(currentIndex).addClass('focused');
    }
    function startInterval() {
        intervalId = setInterval(changeImage, 10000); // Change image every 5 seconds (5000 milliseconds)
    }
    // Start changing image at regular intervals initially
    startInterval();

    // Stop changing image at regular intervals
    function stopInterval() {
        clearInterval(intervalId);
    }

});
