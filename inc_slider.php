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
            <div class="slide-item" style="height:700px !important;background-image:url('uploads/sliders/<?php echo $sliderrow['image'] ;?>');" value="<?php echo 'https://autofixksa.com/'.$sliderrow['buttonlinkTo'] ;?>" onclick="goToLandingPage(this.getAttribute('value'));">
                <div class="auto-container">
                    <div class="content-box">            			
                        <!--<div class="shape"><h3><?php echo $sliderrow['title'.$langid] ;?></h3></div>  
                        <h1 class="title"><?php echo $sliderrow['summary'.$langid] ;?></h1> 
                        <div class="link-box"><a href="<?php echo $sliderrow['buttonlinkTo'] ;?>" class="btn-two"><?php echo $sliderrow['buttonLabel'.$langid] ;?></a></div>-->                         
                    </div>
                </div>
            </div>
            <?php }  ?>

    </div>
</section>
       <script>
        function goToLandingPage(url){
                window.location.href = url;

        }
        </script>
        