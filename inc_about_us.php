<section class="welcome-area secpd1">
    <div class="container">
        <?php
        $pageID = 15;
        $res7 = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
        $row7 = mysqli_fetch_assoc($res7);

        $title               = $row7['title'.$langid];
        $summary             = $row7['summary'.$langid];
        ?>
        <div class="sec-title text-center">
            <h3><?php echo $title;?></h3>
            <div class="title"><?php echo $summary;?></div>
        </div>

        <?php
        $pageID = 1;
        $aboutres = $db->query( "SELECT * FROM home_about_us WHERE id=?i",$pageID);
        $aboutrow = mysqli_fetch_assoc($aboutres);

        $title               = $aboutrow['title'.$langid];
        $image_01            = $aboutrow['image_01'];
        $image_02            = $aboutrow['image_02'];
        $image_03            = $aboutrow['image_03'];
        $description         = $aboutrow['description'.$langid];
        ?>


        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="welcome-image-box clearfix">
                    <div class="image-box">
                        <img src="uploads/pages/<?php echo $image_01;?>" alt="" class="img-brd-white-6">
                    </div>
                    <div class="image-thumb1">
                        <img src="uploads/pages/<?php echo $image_02;?>" alt="" class="img-brd-white-6">
                    </div>
                    <div class="image-thumb2">
                        <img src="uploads/pages/<?php echo $image_03;?>" alt="" class="img-brd-white-6">
                    </div>

                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="welcome-content-box">
                    <div class="top">

                        <div class="title">
                            <h2><?php echo $title;?></h2>
                        </div>
                    </div>
                    <div class="text">
                        <?php echo $description;?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>