<footer class="footer-area">

    <div class="container">
        <div class="row">
            <!--Start single footer widget-->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <?php
                $pageID = 16    ;
                $res8 = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
                $row8 = mysqli_fetch_assoc($res8);

                $image               = $row8['image'];
                $summary             = $row8['summary'.$langid];
                ?>
                <div class="single-footer-widget marbtm50">
                    <div class="footer-logo">
                        <a href="/">
                            <?php
                            if ( $_SESSION['lang'] == "en" )
                            {
                            ?>
                            <img src="uploads/pages/<?php echo $image;?>" alt="Autofix Logo">
                                <?php
                            }
                            else
                            {
                            ?>
                                <img src="uploads/pages/autofix_logo_web_ar_footer.png" alt="">
                                <?php
                            }
                            ?>
                        </a>
                    </div>
                    <div class="company-info">
                        <div class="text-box">
                            <p><?php echo $summary;?></p>
							<br>

							<div>
                                <?php
                                $socialres = $db->query("SELECT * FROM socials WHERE active = 1 ORDER BY so ASC");
                                while ($socialrow = mysqli_fetch_assoc($socialres)) {
                                    ?>

                                    <a href="<?php echo $socialrow['linkTo'];?>" aria-label="">
                                        <div class="social-icon footer-images display-in-block">
                                            <svg viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"
                                                 focusable="false">
                                                <path d="<?php echo $socialrow['path'];?>" fill="#FFF" fill-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </a>
                                    <?php
                                }
                                ?>

							</div>

                        </div>
                    </div>
                </div>
            </div>
            <!--End single footer widget-->
            <!--Start single footer widget-->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="single-footer-widget marleft70 marbtm50">
                    <div class="title">
                        <h3><?php echo getLangText('quick links') ?></h3>
                    </div>
                    <ul class="explore-links">
                      <!--  <li><a href="#"><?php echo getLangText('get coupons and offers') ?></a></li> -->
                        <li><a href="get-estimate"><?php echo getLangText('get estimate') ?></a></li>
                      <!--  <li><a href="#"><?php echo getLangText('shop for tires') ?></a></li> -->
                        <li><a href="contact-us"><?php echo getLangText('get in touch') ?></a></li>

                    </ul>
                </div>
            </div>
            <!--End single footer widget-->
            <!--Start single footer widget-->
            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12">
                <div class="single-footer-widget marleft30">
                    <div class="title">
                        <h3><?php echo getLangText('explore') ?></h3>
                    </div>
                    <ul class="legal-links">
                        <li><a href="about"><?php echo getLangText('about us') ?></a></li>
                        <li><a href="services"><?php echo getLangText('services') ?></a></li>
                    <!--    <li><a href="#"><?php echo getLangText('franchising') ?></a></li> -->
                  <!--      <li><a href="#"><?php echo getLangText('tire center') ?></a></li> -->

                    </ul>
                </div>
            </div>
            <!--End single footer widget-->
            <!--Start single footer widget-->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="single-footer-widget marleft40 pdtop50">
                    <div class="title">
                        <h3><?php echo getLangText('have any questions') ?></h3>
                    </div>
                    <ul class="contact-info">
                        <?php
                        $pageID = 1;
                        $otherres1 = $db->query( "SELECT * FROM others WHERE id=?i",$pageID);
                        $otherrow1 = mysqli_fetch_assoc($otherres1);

                        $phone           = $otherrow1['phone'];
                        $address         = $otherrow1['address'.$langid];
                        ?>
                        <li>
                            <span><?php echo getLangText('contact us') ?></span>
                            <h3><?php echo $phone;?></h3>
                        </li>
                        <li>
                            <span><?php echo getLangText('our address') ?></span>
                            <h3><?php echo $address;?></h3>
                        </li>

                    </ul>
                </div>
            </div>
            <!--End single footer widget-->

        </div>
    </div>
</footer>


<section class="footer-bottom-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="inner text-center clearfix">
                    <div class="copyright-text">


                        <?php
                        if ( $_SESSION['lang'] == "en" )
                        {
                            ?>
                            <p>© Copyright <?php echo date('Y');?> All Rights Reserved By <strong> AutoFix </strong> running in VPS</p>
                            <?php
                        }
                        else
                        {
                            ?>
                            <?php echo getLangText('copy right') ?>
                            <?php
                        }
                        ?>



                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
