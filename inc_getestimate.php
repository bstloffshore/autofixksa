<section class="quote-area">
    <div class="video-gallery-bg">
        <?php
        $pageID = 10;
        $estimateres = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
        $estimaterow = mysqli_fetch_assoc($estimateres);

        $title               = $estimaterow['title'.$langid];
        $summary             = $estimaterow['summary'.$langid];
        $image               = $estimaterow['image'];
        ?>
        <div class="video-holder-box">
            <div class="img-holder">
                <img src="uploads/pages/<?php echo $image;?>" alt="">
                <div class="icon-holder">
                    <div class="icon">
                        <div class="inner text-center">
                            <h3><?php echo $title;?></h3>
                            <h1><?php echo $summary;?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="container inner-content">
        <div class="row">
            <div class="col-xl-8 col-lg-8">
                <div class="quote-form">
                    <div class="title"><h2><?php echo getLangText('get estimate') ?></h2></div>
                    <div class="inner-quote-box">
                        <form id="estimate-Form" name="estimate-Form" class="default-form" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-box">
                                        <input type="text" name="estimate_name" id="estimate_name" value=""
                                               placeholder="<?php echo getLangText('your name') ?>" required="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-box">
                                        <input type="email" name="estimate_email" id="estimate_email" value=""
                                               placeholder="<?php echo getLangText('email address') ?>" required="">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-box">
                                        <input type="text" name="estimate_phone" id="estimate_phone" value=""
                                               placeholder="<?php echo getLangText('phone number') ?>" onkeypress="return isNumberKey(event)"
                                               required="">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <h4 class="estimate-head"><?php echo getLangText('select service') ?></h4></div>
                            <div class="row">
                                <?php
                                $totalAmount = 0;
                                $i = 0;
                                $serviceres = $db->query("SELECT * FROM services WHERE active = 1 ORDER BY so ASC");
                                while ($servicerow = mysqli_fetch_assoc($serviceres)) {
                                    $i++;
                                    ?>
                                    <div class="col-md-4 estimate-list">
                                        <input type="checkbox" id="service_<?php echo $i; ?>" name="services"
                                               value="<?php echo $servicerow['serviceAmount']; ?>">
                                        <span class="estimate-service"> <?php echo $servicerow['serviceTitle'.$langid]; ?> </span><br>
                                        <span class="estimate-price">SAR <?php echo $servicerow['serviceAmount']; ?></span><br>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="row"><p class="estimate-disclaimer service-summary text-left text-ar-right"><?php echo getLangText('disclaimer') ?></p></div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h1 class="estimate-value"><span class="estimate-currency">SAR </span>
                                        <input type="hidden" id="totalCount" name="totalCount"/></h1>
                                    <span id="totalValue"
                                          class="totalSelection estimate-value estimate-total">0</span>
                                    <img id="ajaxLoader" src="uploads/pages/ajax-loader.gif"
                                         style="display: none; margin-left: auto; margin-right: auto;">
                                </div>
                                <div class="col-md-6">
                                    <button id="estimateButton" class="btn-one estimate-button" type="submit"><?php echo getLangText('send inquiry') ?></button>
                                </div>
                            </div>
                        </form>

                        <br>
                        <div id="estimate-success-div" class="result sc_infobox sc_infobox_style_success"
                             style="display: none"></div>
                        <div id="estimate-error-div" class="result sc_infobox sc_infobox_style_error"
                             style="display: none"></div>
                    </div>
                </div>
            </div>

            <?php
            $pageID = 11;
            $estimateres1 = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
            $estimaterow1 = mysqli_fetch_assoc($estimateres1);

            $title               = $estimaterow1['title'.$langid];
            $image               = $estimaterow1['image'];
            ?>
            <div class="col-xl-4 col-lg-4">
                <div class="quote-right-box">
                    <div class="image-holder">
                        <img src="uploads/pages/<?php echo $image;?>" alt="">
                    </div>
                    <div class="text-holder">
                        <h4><?php echo $title;?></h4>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
