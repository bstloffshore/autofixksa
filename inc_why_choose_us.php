<section class="working-steps-area"><?php
    $pageID = 12;
    $res4 = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
    $row4 = mysqli_fetch_assoc($res4);

    $title               = $row4['title'.$langid];
    $summary             = $row4['summary'.$langid];
    ?>

    <div class="container">
        <div class="sec-title text-center">
            <h3><?php echo $title;?></h3>
            <div class="title"><?php echo $summary;?></div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <ul class="fix text-center">
                    <?php
                    $i = 0;
                    $whyres = $db->query("SELECT * FROM our_values WHERE active = 1 ORDER BY so ASC");
                    while ($whyrow = mysqli_fetch_assoc($whyres)) {
                        $i = $i + 300;
                        ?>

                        <li class="single-working-steps-box wow fadeInUp">
                            <div class="icon-holder">
                                <span class="<?php echo $whyrow['class'];?>"></span>
                            </div>
                            <div class="text-holder">
                                <h4><?php echo $whyrow['title'.$langid];?></h4>
                                <p><?php echo $whyrow['summary'.$langid];?></p>
                            </div>
                        </li>
                        <?php
                    }
                    ?>

                </ul>
            </div>
        </div>
    </div>
</section>