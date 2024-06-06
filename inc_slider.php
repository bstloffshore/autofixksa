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
        <!--
            this is old code
            <?php
        $sliderres = $db->query("SELECT * FROM sliders WHERE active = 1 ORDER BY so ASC");
        while ($sliderrow = mysqli_fetch_assoc($sliderres)) {
            ?>
            <a href="<?php echo $sliderrow['buttonlinkTo']; ?>" class="slide-link" target="_blank">
            <div class="slide-item" style="height:700px !important;background-image:url('uploads/sliders/<?php echo $sliderrow['image']; ?>');">
            </div>
        </a>
            <?php }  ?>
        -->
<?php
    // Get the current date
    $currentDate = date('Y-m-d');    
    // Query to get active sliders within the campaign period
    $sliderres = $db->query("SELECT * FROM sliders WHERE active = 1 AND '$currentDate' BETWEEN campaign_start_date AND campaign_end_date ORDER BY so ASC");
    // Check if the query returned any results
    if (mysqli_num_rows($sliderres) > 0) 
    {
        // Display the sliders within the campaign period
        while ($sliderrow = mysqli_fetch_assoc($sliderres)) 
        {?>
            <a href="<?php echo $sliderrow['buttonlinkTo']; ?>" class="slide-link" target="_blank">
                <div class="slide-item" style="height:700px !important;background-image:url('uploads/sliders/<?php echo $sliderrow['image']; ?>');"></div>
            </a>
        <?php 
        } 
    } else 
    {
        // If no campaign sliders are found, display another set of images
        // Query to get active sliders outside the campaign period
        $defaultSliderres = $db->query("SELECT * FROM sliders WHERE active = 1 AND ('$currentDate' < campaign_start_date OR '$currentDate' > campaign_end_date)
        ORDER BY so ASC");
        while ($defaultSliderrow = mysqli_fetch_assoc($defaultSliderres)) 
        {?>
            <!-- <a href="<?php echo $defaultSliderrow['buttonlinkTo']; ?>" class="slide-link" target="_blank">
            <div class="slide-item" style="height:700px !important;background-image:url('uploads/sliders/<?php echo $defaultSliderrow['image']; ?>');">
            </div>
            </a> -->
            <div class="slide-item" style="height:700px !important;background-image:url('uploads/sliders/AUT0FIXKSA-Slider_01.jpg');">
        <?php 
        }
    }
?>
    </div>
</section>
       
        