<section class="home-slider-one">
    <div class="silder-right-content">
        
<!--
        <div class="slider-contact-info">
            <div class="inner">
				<a href="https://wa.me/971503140413" target="_blank">
                <div class="icon-holder">
                    <span class="flaticon-whatsapp-logo"></span>
                </div>
					</a>
                
            </div>
        </div>        
-->
    </div>
    <div class="home-slider owl-theme owl-carousel banner-carousel-four" dir="ltr">
        <?php
        $sliderres = $db->query("SELECT * FROM sliders WHERE active = 1 ORDER BY so ASC");
        while ($sliderrow = mysqli_fetch_assoc($sliderres)) {
            ?>
            <a href="<?php echo $sliderrow['buttonlinkTo']; ?>" class="slide-link" target="_blank">
            <div class="slide-item" style="height:700px !important;background-image:url('uploads/sliders/<?php echo $sliderrow['image']; ?>');">
            </div>
        </a>
            <?php }  ?>

    </div>
</section>
       <script>
        function goToLandingPage(url){
                // window.location.href = url;
                window.open(url, '_blank');

        }
        </script>
        