<section class="brand-area">
    <div class="container">
        <?php
        $pageID = 9;
        $partRes = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
        $partRow = mysqli_fetch_assoc($partRes);

        $title             = $partRow['title'.$langid];
        $summary           = $partRow['summary'.$langid];
        ?>
		<div class="sec-title text-center">
            <h3><?php echo $title;?></h3>
            <div class="title"><?php echo $summary;?></div>
        </div>
		
		
        <div class="row">
            <?php
            $i = 0;
            $partnerres = $db->query("SELECT * FROM clients WHERE active = 1 ORDER BY so ASC");
            while ($partnerrow = mysqli_fetch_assoc($partnerres)) {
                $i = $i + 200;
                ?>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                    <div class="single-brand-item wow fadeInUp" data-wow-delay="<?php echo $i;?>ms" data-wow-duration="1500ms">
                        <img src="uploads/clients/<?php echo $partnerrow['image'] ;?>" alt="<?php echo $partnerrow['title'] ;?>">
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>