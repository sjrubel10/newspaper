<?php
$slidingimages = array(
        0=>"assets/uploads/images/slideImages/img_mountains_wide.jpeg",
        1=>"assets/uploads/images/slideImages/img_nature_wide.jpeg",
        2=>"assets/uploads/images/slideImages/img_snow_wide.jpeg",
);
?>
<div class="slideShowContainerHolder">
    <div class="slideShowContainer">
        <h2>Automatic Slideshow</h2>
        <p>Change image every 3 seconds:</p>

        <div class="slideshow-container">
            <?php foreach ( $slidingimages as $slidingimage ){?>
            <div class="mySlides fade">
                <div class="numbertext">1 / 3</div>
                <img class="slidingImage" src="<?php echo $slidingimage?>" style="width: 100%;" alt="Nature" />
                <div class="content">
                    <h1>Heading</h1>
                    <p>Lorem ipsum..</p>
                </div>
<!--                <div class="text">Caption Text</div>-->
            </div>
            <?php }?>

            <!--<div class="mySlides fade">
                <div class="numbertext">2 / 3</div>
                <img src="assets/uploads/images/slideImages/img_nature_wide.jpeg" style="width: 100%;" alt="Snow" />
                <div class="text">Caption Two</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">3 / 3</div>
                <img src="assets/uploads/images/slideImages/img_snow_wide.jpeg" style="width: 100%;" alt="Mountains" />
                <div class="text">Caption Three</div>
            </div>-->
        </div>
        <br />
        <div style="text-align: center;">
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>
    <div class="addSectionHolder">
        <div class="">
            Ads
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
        }, 5000);

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

