<?php
$pageID = 8;
$res2 = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
$row2 = mysqli_fetch_assoc($res2);

$title               = $row2['title'.$langid];
$summary             = $row2['summary'.$langid];
$image               = $row2['image'];
?>

<section class="choose-area" style="background-image:url('uploads/pages/<?php echo $image ;?>');">
    <div class="container">
        <div class="sec-title clr-white text-center">
            <h3><?php echo $title ;?></h3>
            <div class="title"><?php echo $summary ;?></div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <ul class="choose-content fix service-anchor-color">
                    <?php
                    $i = 100;
                    $serviceres = $db->query("SELECT * FROM services WHERE active = 1 ORDER BY so ASC");
                    while ($servicerow = mysqli_fetch_assoc($serviceres)) {
                        $i = $i+100;
                        ?>

                        <li class="single-choose-box wow fadeInUp" data-wow-delay="<?php echo $i;?>ms" data-wow-duration="500ms">
                            <span class="<?php echo $servicerow['class'];?>"></span>
<!--                            <h4>Oil <br> Change</h4>-->
                            <h4><a href="/service/<?php echo $servicerow['slug'];?>"><?php echo $servicerow['serviceTitle'.$langid];?></a></h4>
                        </li>
                        <?php
                    }
                    ?>
<!--                    -->
<!--                    <li class="single-choose-box wow fadeInUp" data-wow-delay="200ms" data-wow-duration="500ms">-->
<!--                        <span class="flaticon-maintenance"></span> -->
<!--                        <h4>Periodic <br> Maintenance</h4>   -->
<!--                    </li>  -->
<!--                    <li class="single-choose-box wow fadeInUp" data-wow-delay="300ms" data-wow-duration="500ms">-->
<!--                        <span class="flaticon-car-service-2"></span> -->
<!--                        <h4>Car<br> Wash</h4>   -->
<!--                    </li>  -->
<!--                    <li class="single-choose-box wow fadeInUp" data-wow-delay="400ms" data-wow-duration="500ms">-->
<!--                        <span class="flaticon-car-service"></span> -->
<!--                        <h4>Car<br> Polishing</h4>   -->
<!--                    </li>  -->
<!--                    <li class="single-choose-box wow fadeInUp" data-wow-delay="500ms" data-wow-duration="500ms">-->
<!--                        <span class="flaticon-brake"></span> -->
<!--                        <h4>Brake <br> Services</h4>   -->
<!--                    </li>-->
<!--					<li class="single-choose-box wow fadeInUp" data-wow-delay="600ms" data-wow-duration="500ms">-->
<!--                        <span class="flaticon-tyre"></span> -->
<!--                        <h4>Tires <br> & Wheels </h4>   -->
<!--                    </li>-->
<!--					<li class="single-choose-box wow fadeInUp" data-wow-delay="700ms" data-wow-duration="500ms">-->
<!--                        <span class="flaticon-tinting"></span> -->
<!--                        <h4>Window<br> Tinting</h4>   -->
<!--                    </li>-->
<!--					<li class="single-choose-box wow fadeInUp" data-wow-delay="800ms" data-wow-duration="500ms">-->
<!--                        <span class="flaticon-car-wash"></span> -->
<!--                        <h4>Steam <br> Wash</h4>   -->
<!--                    </li>-->
<!--					<li class="single-choose-box wow fadeInUp" data-wow-delay="900ms" data-wow-duration="500ms">-->
<!--                        <span class="flaticon-air-conditioning"></span> -->
<!--                        <h4>Air<br> Conditioning</h4>   -->
<!--                    </li>-->
<!--					<li class="single-choose-box wow fadeInUp" data-wow-delay="1000ms" data-wow-duration="500ms">-->
<!--                        <span class="flaticon-battery"></span> -->
<!--                        <h4>Batteries <br> & Electrical</h4>   -->
<!--                    </li>-->
<!--                    <li class="single-choose-box wow fadeInUp" data-wow-delay="1100ms" data-wow-duration="500ms">-->
<!--                        <span class="flaticon-car-service-3"></span> -->
<!--                        <h4>Nano-Ceramic <br> & Protection</h4>   -->
<!--                    </li>-->
<!--                    <li class="single-choose-box wow fadeInUp" data-wow-delay="1200ms" data-wow-duration="500ms">-->
<!--                        <span class="flaticon-headlights"></span> -->
<!--                        <h4>Headlight <br> Restoration</h4>   -->
<!--                    </li>-->
<!--                    <li class="single-choose-box wow fadeInUp" data-wow-delay="1300ms" data-wow-duration="500ms">-->
<!--                        <span class="flaticon-suspension"></span> -->
<!--                        <h4>Car <br> Suspension</h4>   -->
<!--                    </li>-->
<!--                    <li class="single-choose-box wow fadeInUp" data-wow-delay="1400ms" data-wow-duration="500ms">-->
<!--                        <span class="flaticon-wheel-alignment"></span> -->
<!--                        <h4>Wheel  <br> Alignment</h4>   -->
<!--                    </li>-->
<!--                    <li class="single-choose-box wow fadeInUp" data-wow-delay="1600ms" data-wow-duration="500ms">-->
<!--                        <span class="flaticon-windshield"></span> -->
<!--                        <h4>Windscreen <br>Replacement</h4>   -->
<!--                    </li>-->
<!--                    <li class="single-choose-box wow fadeInUp" data-wow-delay="1600ms" data-wow-duration="500ms">-->
<!--                        <span class="flaticon-windshield-1"></span> -->
<!--                        <h4>Wiper <br> Blades</h4>   -->
<!--                    </li>-->
					
                </ul>
            </div>
        </div>
        <?php
        $pageID = 7;
        $res1 = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
        $row1 = mysqli_fetch_assoc($res1);

        $summary             = $row1['summary'.$langid];
        ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="contact-us text-center wow fadeInUp" data-wow-delay="1000ms" data-wow-duration="1500ms">
                    <h3><?php echo $summary;?></h3>
                </div>
            </div>
        </div>
    </div>
</section>