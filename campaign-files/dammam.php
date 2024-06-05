<?php
include "../inc_opendb.php";
$page_id = "Home";
$lang    = $_SESSION['lang'];


//echo "<pre>";
//echo print_r($_GET);
//echo "</pre>";

//$cid               = filter_var($_GET['cid'], FILTER_SANITIZE_STRING);
$cslug = filter_var( $_GET['cslug'], FILTER_SANITIZE_STRING );


$cid = 0;
if ( empty( $cslug ) ) {
	header( "location: /" );
	exit();
} else {
	$campaign_info_res = $db->query( "select * from `campaign_master` WHERE `campaignSlug` = ?s AND `active` = 1", $_GET['cslug'] );
	$campaign_info_row = mysqli_fetch_assoc( $campaign_info_res );
	$cid               = $campaign_info_row["campaignID"];

	if ( empty( $cid ) ) {
		header( "location: /" );
		exit();
	}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
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

$pageID       = $cslug;
$campaboutres = $db->query( "SELECT * FROM campaign_aboutus WHERE campaignSlug=?s", $pageID );
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


    <div class="">
			
        

<div class="row">
            <div class="col-lg-12 col-md-12 text-center">
                <img src="../uploads/campaign/<?php echo $sliderImage ?>" style="max-width:80%;margin-bottom:10px;" class="image-fluid mx-auto">
            </div>
                <div class="col-lg-12 col-md-12">
                <form id="campaignForm" name="campaignForm" class="default-form" method="post">
                    <div class="cs-header-form">
                        <input type="hidden" class="form-control" name="campaignid" id="campaignid" value="<?php echo $cid ?>">
                        <input type="hidden" class="form-control" name="campaignlang" id="campaignlang" value="<?php echo $lang ?>">
                        <h2><?php echo getLangText( 'book our services now' ) ?></h2>
                        <br>
                        <div class="form-group cs-form-group">
                            <input type="text" class="form-control" name="campaignname" id="campaignname" placeholder="<?php echo getLangText( 'enter your name' ) ?>" required="">
                        </div>
                        <div class="form-group cs-form-group">
                            <input type="email" class="form-control" name="campaignemail" id="campaignemail" placeholder="<?php echo getLangText( 'enter your email' ) ?>" required="">
                        </div>
                        <div class="form-group cs-form-group">
                            <input type="text" class="form-control" name="campaignphone" id="campaignphone" placeholder="<?php echo getLangText( 'phone number' ) ?>" required="" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group cs-form-group">
                            <textarea name="campaignmessage" id="campaignmessage" placeholder="<?php echo getLangText( 'your message' ) ?>" required="" spellcheck="false"></textarea>
                        </div>
                        <div class="form-group cs-form-group">
                            <img id="campaign-ajaxLoader" src="../uploads/pages/ajax-loader.gif" style="display: none; margin-left: auto; margin-right: auto;">
                        </div>
                        <button type="submit" id="campaign-btn" class="btn btn-primary btn-block"><?php echo getLangText( 'submit' ) ?></button>
                        <p><h5>Terms and conditions :</h5></p>
                        <p>Terms and conditions apply.</p>
                    </div>
                </form>
                <br>
                <div id="campaign-success-message-div" class="result sc_infobox sc_infobox_style_success" style="display: none"></div>
                <div id="campaign-error-message-div" class="result sc_infobox sc_infobox_style_error" style="display: none"></div>
                <div>
            </div>
            </div>


        </div>
    </div>
<!-- /Header -->


<!-- About Portfolio-->

<!-- /About Portfolio-->

<!-- Call to action -contact -->

<!-- /Call to action -contact -->

<!-- Footer -->
<div class="cs-copyright-bar">
    <div class="container">
        <ul class="cs-footer-navbar">
            <li><a href="#"><?php echo getLangText( 'visit website' ) ?></a></li>
            <li><a href="#"><?php echo getLangText( 'privacy policy' ) ?></a></li>
            <li><a href="#"><?php echo getLangText( 'terms and conditions' ) ?></a></li>
						<?php
						if ( $_SESSION['lang'] == "en" )
						{
						?>
								<li><a href="https://ar.autofixksa.com<?php echo $_SERVER['REQUEST_URI']?>" >العربية</a></li>
								<?php
						}
						else
						{
						?>
								<li><a href="https://en.autofixksa.com<?php echo $_SERVER['REQUEST_URI']?>">English</a></li>
								<?php
						}
						?>
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

                    // $("#campaign-success-message-div").show();
                    // $('#campaignForm')[0].reset();
                    // $('#campaign-ajaxLoader').hide();
                    // $('#campaign-btn').show();
                    // $("#campaign-success-message-div").html(message).delay(3000).fadeOut('slow');
                    window.location.href="/thank-you";
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
