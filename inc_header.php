<div class="preloader"></div>

<header class="main-header">
    <div class="main-box">
        <div class="inner-container clearfix">
            <div class="logo-box">
                <a href="/">
                    <?php
                    if ( $_SESSION['lang'] == "en" )
                    {
                    ?>
                        <img src="uploads/pages/logo.png" alt="">
                        <?php
                    }
                    else
                    {
                    ?>
                        <img src="uploads/pages/autofix_logo_web_ar.png" alt="">
                        <?php
                    }
                    ?>

                </a>
            </div>
            <div class="nav-outer clearfix" >
                <nav class="main-menu clearfix">
                    <div class="navbar-header clearfix">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="navbar-collapse collapse clearfix">
                        <ul class="navigation clearfix">
                            <li class="dropdown <?php if ($page_id == 'Home') echo 'current' ;?>"><a href="/"><?php echo getLangText('home') ?></a></li>
                            <li class="dropdown <?php if ($page_id == 'About') echo 'current' ;?>"><a href="about"><?php echo getLangText('about us') ?></a></li>
                            <li class="dropdown <?php if ($page_id == 'Services' || $page_id == 'Services Info') echo 'current' ;?>"><a href="services"><?php echo getLangText('services') ?></a></li>

                        <!--    <li class="dropdown"><a href="#"><?php echo getLangText('franchising') ?></a>

                            </li>
                            <li class="dropdown"><a href="#"><?php echo getLangText('tire center') ?></a>

                            </li> -->
                            <li class="<?php if ($page_id == 'Contact') echo 'current' ;?>"><a href="contact-us"><?php echo getLangText('contact us') ?></a></li>
                          <li>
                                <?php
                                if ( $_SESSION['lang'] == "en" )
                                {
                                    ?>
                                    <a href="<?php echo "https://ar." . DOMAIN_NAME ?>" style="cursor: pointer" class="font-ara" >العربية</a>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <a href="<?php echo "https://en." . DOMAIN_NAME ?>" style="cursor: pointer">English</a>
                                    <?php
                                }
                                ?>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="header-right clearfix">


                <div class="button">
                    <a class="btn-two" href="get-estimate"><?php echo getLangText('get an estimate') ?></a>
                </div>
            </div>
        </div>
    </div>
</header>
