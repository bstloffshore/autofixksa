<section class="services-style1-area secpd1">
    <div class="container">
        <?php
        $pageID = 13;
        $res5 = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
        $row5 = mysqli_fetch_assoc($res5);

        $title               = $row5['title'.$langid];
        $summary             = $row5['summary'.$langid];
        ?>
        <div class="sec-title text-center">
            <h3><?php echo $title;?></h3>
            <div class="title"><?php echo $summary;?></div>
        </div>
        <div class="row">

            <?php
            $i = 0;
            $howres = $db->query("SELECT * FROM our_process WHERE active = 1 ORDER BY so ASC");
            while ($howrow = mysqli_fetch_assoc($howres)) {
                $i = $i + 200;
                ?>

                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                    <div class="single-service-style1 wow fadeInUp" data-wow-delay="<?php echo $i;?>ms" data-wow-duration="1500ms">
                        <div class="inner">
                            <div class="img-holder">
                                <img src="uploads/how_it_works/<?php echo $howrow['image'];?>" alt="<?php echo $howrow['title'.$langid];?>">
                            </div>
                        </div>
                        <div class="text-holder text-center">
                            <div class="button">
                                <a><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                            </div>
                            <h4><a><?php echo $howrow['title'.$langid];?></a></h4>
                        </div>
                    </div>
                </div>

                <?php
            }
?>

        </div>
        <?php
        $pageID = 14;
        $res6 = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
        $row6 = mysqli_fetch_assoc($res6);

        $title1               = $row6['title'.$langid];
        ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="contact-us text-center wow fadeInUp" data-wow-delay="1000ms" data-wow-duration="1500ms">
                    <h3><?php echo $title1;?><a href="contact-us">
                            <span> <?php echo getLangText('contact us') ?> </span></a></h3>
                </div>
            </div>
        </div>
    </div>
</section>