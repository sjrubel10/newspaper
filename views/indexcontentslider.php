<?php
$slidingimages = array(
        0=>"assets/uploads/images/slideImages/img_mountains_wide.jpeg",
        1=>"assets/uploads/images/slideImages/img_nature_wide.jpeg",
        2=>"assets/uploads/images/slideImages/img_snow_wide.jpeg",
);
function display_sliding_images( $slidingimages ): string
{
    $display_images = '';
    $sliding_images = '';
    $sliding_dots = '';
    $images_holder  = '<div class="slideshow-container">';
    $dots_holder    = '<div class="slidDotsHolder" style="text-align: center">';
    $div_close      = '</div>';
    foreach ( $slidingimages as $slidingimage ){
        $sliding_images .= '<div class="mySlides fade" style="display:none;">
                                <div class="numbertext">1 / 3</div>
                                <img class="slidingImage" src="'.$slidingimage.'" alt="Nature" />
                                <div class="content">
                                    <h1>Heading</h1>
                                    <p>Lorem ipsum..</p>
                                </div>
                            </div>';
        $sliding_dots .= '<span class="dot"></span>';
    }

    $display_images .= $images_holder.$sliding_images.$div_close.$dots_holder.$sliding_dots.$div_close;

    return $display_images;
}
?>
<div class="slideShowContainerHolder">
    <div class="slideShowContainer">
        <?php echo display_sliding_images( $slidingimages ); ?>
    </div>
    <div class="addSectionHolder">
        <div class="">
            <img class="adsImage" alt="ads images" src="../assets/uploads/ads/ads1.jpeg">
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        let slideIndex = 1;

        const showSlides = function(n) {
            let newIndex = n;
            const $slides = $(".mySlides");
            const $dots = $(".dot");

            if (newIndex > $slides.length) {
                newIndex = 1;
            }
            if (newIndex < 1) {
                newIndex = $slides.length;
            }

            slideIndex = newIndex;

            $slides.hide();
            $dots.removeClass("active");

            $slides.eq(newIndex - 1).fadeIn(1000);
            $dots.eq(newIndex - 1).addClass("active");
        };

        const plusSlides = function(n) {
            showSlides(slideIndex + n);
        };

        const currentSlide = function(n) {
            showSlides(n);
        };

        const intervalId = setInterval(function() {
            showSlides(slideIndex + 1);
        }, 6000);

        $(".dot").click(function() {
            const index = $(this).index() + 1;
            currentSlide(index);
        });

        // Clear interval on component unmount or cleanup
        $(window).on("beforeunload", function() {
            clearInterval(intervalId);
        });

        // Initial slide show
        showSlides(slideIndex);
    });
</script>
