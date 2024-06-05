<?php
include "../inc_opendb.php";
$lang    = $_SESSION['lang'];
//echo $_SESSION['lang'];
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WC5B4BQ');</script>
    <!-- End Google Tag Manager -->



    <base href="/campaign-files/">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Autofix KSA">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Autofix KSA">
    <meta name="keywords" content="autofix kSA">
    <meta name="description" content="Autofix KSA">
    <title>Autofix KSA</title>
    <link rel="shortcut icon" href="images/favicon.png"/>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- FLaticon stylesheet -->
    <link rel="stylesheet" type="text/css" href="flaticons/flaticon.css">


    <!-- Custom stylesheet -->
    <!-- Custom stylesheet -->
    <?php

    if ( $lang == 'ar' ) {
        ?>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min_ar.css">
        <link rel="stylesheet" type="text/css" href="css/style_ar.css">
        <link rel="stylesheet" type="text/css" href="css/custom_ar.css">
        <?php
    } else {
        ?>
        <link rel="stylesheet" type="text/css" href="css/custom.css">
        <?php
    }
    ?>
		</head>

<body <?php if ( $lang == 'ar' ) {
    echo 'dir="rtl"';
} ?>>

	<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WC5B4BQ"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->



    <!-- PRELOADER -->
<div id="preloader">
    <div id="status">
        <img src="images/preloader.gif">
    </div>
</div>
    <!-- /PRELOADER -->

    <!-- Navbar -->

    <!-- /Navbar -->

            <!-- Header -->
    <?php
    $pageID       = 3;
    $campaboutres = $db->query( "SELECT * FROM campaign_aboutus WHERE id=?i", $pageID );
    $campaboutrow = mysqli_fetch_assoc( $campaboutres );

    $title       = $campaboutrow[ 'title' . $langid ];
    $sliderImage = $campaboutrow[ 'sliderImage' . $langid ];
    $description = $campaboutrow[ 'description' . $langid ];

    $section_01_title   = $campaboutrow[ 'section_01_title' . $langid ];
    $section_01_summary = $campaboutrow[ 'section_01_summary' . $langid ];
    $section_01_icon    = $campaboutrow['section_01_icon'];

    $section_02_title   = $campaboutrow[ 'section_02_title' . $langid ];
    $section_02_summary = $campaboutrow[ 'section_02_summary' . $langid ];
    $section_02_icon    = $campaboutrow['section_02_icon'];

    $section_03_title   = $campaboutrow[ 'section_03_title' . $langid ];
    $section_03_summary = $campaboutrow[ 'section_03_summary' . $langid ];
    $section_03_icon    = $campaboutrow['section_03_icon'];

    $section_04_title   = $campaboutrow[ 'section_04_title' . $langid ];
    $section_04_summary = $campaboutrow[ 'section_04_summary' . $langid ];
    $section_04_icon    = $campaboutrow['section_04_icon'];

    ?>


    <header class="bgimg" style="background-image:url('../uploads/campaign/<?php echo $sliderImage ?>')">

    <div class="container">
        <div class="row">


            <div class="col-lg-8  col-md-8  ">


            </div>


            <div class="col-lg-4 col-md-4 campaign-form">

                <form id="campaignForm" name="campaignForm" class="default-form" method="post">
                    <div class="cs-header-form">

						 <h2><?php echo getLangText( 'thank you' ) ?></h2>
						<br>
						<h4>
						<?php echo getLangText( 'thank you message' ) ?></h4>

                        <a  href="https://<?php echo $_SERVER['HTTP_HOST']?>" id="campaign-btn" class="btn btn-primary btn-block"><?php echo getLangText( 'visit website' ) ?></a>
                    </div>
                </form>
                <br>


            </div>


        </div>
    </div>
</header>
    <!-- /Header -->


    <!-- About Portfolio-->
<section class="cs-abt-section">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-7">
                <div class="cs-about-content wow animated fadeInUp" data-wow-delay="300ms">
                    <h2><?php echo $title; ?></h2>
                    <?php echo $description; ?>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="cs-icon-media wow animated fadeInUp animated">
                            <div class="media-left">
                                <i class="<?php echo $section_01_icon; ?>"></i>
                            </div>
                            <div class="media-body">
                                <h4><?php echo $section_01_title; ?></h4>
                                <?php echo $section_01_summary; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cs-icon-media wow animated fadeInUp animated">
                            <div class="media-left">
                                <i class="<?php echo $section_02_icon; ?>"></i>
                            </div>
                            <div class="media-body">
                                <h4><?php echo $section_02_title; ?></h4>
                                <?php echo $section_02_summary; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cs-icon-media wow animated fadeInUp animated">
                            <div class="media-left">
                                <i class="<?php echo $section_03_icon; ?>"></i>
                            </div>
                            <div class="media-body">
                                <h4><?php echo $section_03_title; ?></h4>
                                <?php echo $section_03_summary; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cs-icon-media wow animated fadeInUp animated">
                            <div class="media-left">
                                <i class="<?php echo $section_04_icon; ?>"></i>
                            </div>
                            <div class="media-body">
                                <h4><?php echo $section_04_title; ?></h4>
                                <?php echo $section_04_summary; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-5">
                <img src="images/abt-img.png" alt="" class="img-responsive wow animated fadeInUp">
            </div>
        </div>
    </div>
</section>
    <!-- /About Portfolio-->

    <!-- Call to action -contact -->
<div class="cs-cotact-action-bg">
    <div class="container">
        <div class="row">

			<?php
            $pageID   = 1;
            $otherres = $db->query( "SELECT * FROM others WHERE id=?i", $pageID );
            $otherrow = mysqli_fetch_assoc( $otherres );

            $phone   = $otherrow['phone'];
            $email   = $otherrow['email'];
            $address = $otherrow[ 'address' . $langid ];
            ?>

            <div class="col-sm-4">
                <div class="cs-contact-action wow animated zoomIn">
                  <!--  <div class="icon icon-Phone2"></div> -->
                    <h4><?php echo getLangText( 'call us' ) ?></h4>
                    <h2><?php echo "$phone"; ?></h2>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="cs-contact-action wow animated zoomIn">
                    <!-- <div class="icon icon-Mail"></div> -->
                    <h4><?php echo getLangText( 'drop an email' ) ?></h4>
                    <h2><?php echo $email; ?></h2>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="cs-contact-action wow animated zoomIn">
                    <!-- <div class="icon icon-Time"></div> -->
                    <h4><?php echo getLangText( 'visit us' ) ?></h4>
                    <h2><?php echo $address; ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- /Call to action -contact -->



    <!-- Footer -->
<div class="cs-copyright-bar">
    <div class="container">
        <ul class="cs-footer-navbar">
            <li><a href="#"><?php echo getLangText( 'visit website' ) ?></a></li>
            <li><a href="#"><?php echo getLangText( 'privacy policy' ) ?></a></li>
            <li><a href="#"><?php echo getLangText( 'terms and conditions' ) ?></a></li>
        </ul>

        <?php
        if ( $_SESSION['lang'] == "en" ) {
            ?>
            <div class="cs-copy-text">© Copyright <?php echo date( 'Y' ); ?> All Rights Reserved</div>
            <?php
        } else {
            ?>
            <?php echo getLangText( 'copy right' ) ?>
            <?php
        }
        ?>

        <!--        <div class="cs-copy-text">© 2019 All rights reserved.</div>-->
    </div>
    <a href="#" class="btn-primary back-to-top show" title="Move to top"><i class="icon icon-BatteryLow"></i></a>

</div>
    <!-- /Footer -->

    <!-- Script files -->
<script src="js/jquery-2.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap.offcanvas.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/jquery.magnific-popup.js"></script>
<script src="js/slider/owl.carousel.min.js"></script>


<script src="js/main.js"></script>

<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>




<script>
    $(document).ready(function () {
        console.clear();
    });
    $("form#campaignForm").submit(function (e) {

        e.preventDefault();
        $('#campaign-ajaxLoader').show();
        $('#campaign-btn').hide();

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "ajax_campaign.php",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {

                console.log(data);
                // alert(data);

                var statusmessage = data.trim().split("|")[0];
                var message = data.trim().split("|")[1];


                if (statusmessage.toString().trim() === "SUCCESS") {
                    // $("#success-message-div").css('display', 'block');
                    $("#campaign-success-message-div").show();
                    // $("#success-message-div").html(message).delay(3000).fadeOut('slow');
                    $('#campaignForm')[0].reset();
                    $('#campaign-ajaxLoader').hide();
                    $('#campaign-btn').show();
                    // $('#campaignForm').hide();
                    $("#campaign-success-message-div").html(message).delay(3000).fadeOut('slow');
                }

                if (statusmessage.toString().trim() === "ERROR") {
                    // $("#error-message-div").css('display', 'block');
                    $("#campaign-ajaxLoader").css('display', 'block');
                    $('#campaign-ajaxLoader').hide();
                    $('#campaign-btn').show();
                    $("#campaign-error-message-div").show();
                    $("#campaign-error-message-div").html(message).delay(3000).fadeOut('slow');
                }

            },
            always: function (data) {
                console.log("Always snippet" + data);
            },
            fail: function (data) {
                console.log("Error sniippet" + data);
            }
        });

        return false;
    });
</script>

<style>
    #campaign-success-message-div {
        background-color: #5aa631;
        border: 1px solid #c8f8af;
        background: #eaffdf;
        text-align: center;
        max-width: 700px;
        color: #000000;
        padding: 20px;
        left: 30px;
        width: 100%;
    }

    #campaign-error-message-div {
        background-color: #7C0304;
        border: 1px solid #ffd8d8;
        background: #e30613;
        text-align: center;
        width: 100%;
        max-width: 700px;
        color: #ffffff;
        padding: 5px;
        left: 30px;
    }
</style>
</body>

</html>
