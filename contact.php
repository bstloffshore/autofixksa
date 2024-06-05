<?php
include "inc_opendb.php";
$page_id = "Contact";
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'inc_metadata.php'; ?>

<body <?php if ( $lang == 'ar' ) { echo 'dir="rtl"'; } ?>>

	<?php include 'inc_google_tag_body.php'; ?>


<div class="boxed_wrapper">

    <?php include 'inc_header.php'; ?>

    <?php
    $pageID = 4;
    $res = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
    $row = mysqli_fetch_assoc($res);

    $title             = $row['title'.$langid];
    $bgimage           = $row['image'];
    ?>
    <section class="breadcrumb-area" style="background-image:url('uploads/pages/<?php echo $bgimage ;?>');">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="inner-content text-center clearfix">
                        <div class="breadcrumb-menu">
                            <ul class="clearfix">
                                <li><a href="/"><?php echo getLangText('home') ?></a></li>
                                <li class="active"><?php echo $title;?></li>
                            </ul>
                        </div>
                        <div class="title">
                            <h1><?php echo $title;?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End breadcrumb area-->

    <!--Start contact form area-->
    <section class="contact-info-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6">
                    <div class="contact-info-content">
                        <?php
                        $pageID = 5;
                        $res1 = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
                        $row1 = mysqli_fetch_assoc($res1);

                        $title1             = $row1['title'.$langid];
                        $summary           = $row1['summary'.$langid];
                        ?>
                        <div class="sec-title">
                            <h3><?php echo $title1;?></h3>
                            <div class="title"><?php echo $summary;?></div>
                        </div>
                        <?php
                        $pageID = 6;
                        $res2 = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
                        $row2 = mysqli_fetch_assoc($res2);

                        $summary2           = $row2['summary'.$langid];
                        ?>
                        <div class="inner-content">
                            <div class="text">
                                <?php echo $summary2;?>
                            </div>
<!-- Branches-->			<div>
											<button type="button" class="collapsible">Dammam</button>
                            <ul class="branch"> <!-- Branch 1-->
                                <?php
                                $pageID = 2;
                                $otherres = $db->query( "SELECT * FROM others WHERE id=?i",$pageID);
                                $otherrow = mysqli_fetch_assoc($otherres);

                                $phone           = $otherrow['phone'];
                                $email           = $otherrow['email'];
                                $address         = $otherrow['address'.$langid];
                                ?>
                                <li>
                                    <p><?php echo getLangText('call now') ?></p>
                                    <span><?php echo $phone;?></span>
                                </li>
                                <li>
                                    <p><?php echo getLangText('send email') ?></p>
                                    <span><?php echo $email;?></span>
                                </li>
                                <li>
                                    <p><?php echo getLangText('visit us') ?></p>
                                    <span><?php echo $address;?></span>
                                </li>
																<li>
																	<div class="earth3dmap-com"><iframe id="iframemap" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d233.43361129002844!2d50.1716452328014!3d26.374272155700478!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e49e55f98954bb7%3A0xba61a8dbc95be8f9!2sAuto%20Fix%20Car%20Service%20-%20Dammam!5e0!3m2!1sen!2ssa!4v1675856214460!5m2!1sen!2ssa" width="100%" height="500" frameborder="0" scrolling="no"></iframe></div>
																</li>
                            </ul>
												<button type="button" class="collapsible">Riyadh</button>
														<ul class="branch"> <!-- Branch 2-->
                                <?php
                                $pageID = 1;
                                $otherres = $db->query( "SELECT * FROM others WHERE id=?i",$pageID);
                                $otherrow = mysqli_fetch_assoc($otherres);

                                $phone           = $otherrow['phone'];
                                $email           = $otherrow['email'];
                                $address         = $otherrow['address'.$langid];
                                ?>
                                <li>
                                    <p><?php echo getLangText('call now') ?></p>
                                    <span><?php echo $phone;?></span>
                                </li>
                                <li>
                                    <p><?php echo getLangText('send email') ?></p>
                                    <span><?php echo $email;?></span>
                                </li>
                                <li>
                                    <p><?php echo getLangText('visit us') ?></p>
                                    <span><?php echo $address;?></span>
                                </li>
																<li>
																	<div class="earth3dmap-com"><iframe id="iframemap" src="https://maps.google.com/maps?q=Auto+Fix+Car+Service+Umar+Walid+Adh+Dhahir%2C+Ash+Shuhada%2C+Riyadh&amp;ie=UTF8&amp;iwloc=&amp;output=embed" width="100%" height="500" frameborder="0" scrolling="no"></iframe></div>
																</li>
                            </ul>
												</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                    <div class="contact-form">
<!--                        <form id="contact-form" name="contact_form" class="default-form" action="http://mehedi.asiandevelopers.com/demo/html/fouens/inc/sendmail.php" method="post">-->
                        <form id="contactForm" name="contactForm" class="default-form" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-box">
                                        <input type="text" name="name" id="name" value="" placeholder="<?php echo getLangText('your name') ?>" required="">
                                        <div class="icon">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-box">
                                        <input type="email" name="email" id="email" value="" placeholder="<?php echo getLangText('email address') ?>" required="">
                                        <div class="icon">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-box">
                                        <input type="text" name="phone" id="phone" value="" placeholder="<?php echo getLangText('phone') ?>" onkeypress="return isNumberKey(event)" required="">
                                        <div class="icon">
                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-box">
                                        <input type="text" name="subject" id="subject"  value="" placeholder="<?php echo getLangText('subject') ?>" required="">
                                        <div class="icon">
                                            <i class="fa fa-file-text" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-box">
                                        <select class="selectmenu " id="services" name="services" required="">
                                            <option selected="selected"><?php echo getLangText('select service') ?></option>
                                            <?php
                                            $serviceres = $db->query("SELECT * FROM services WHERE active = 1 ORDER BY so ASC");
                                            while ($servicerow = mysqli_fetch_assoc($serviceres)) {
                                                ?>
                                                <option value="<?php echo $servicerow['serviceTitle'];?>"><?php echo $servicerow['serviceTitle'.$langid];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="icon">
                                            <i class="fa fa-question" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-box">
                                        <textarea name="message" id="message"  placeholder="<?php echo getLangText('your message') ?>"></textarea>
                                        <div class="icon">
                                            <i class="fa fa-comment" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="g-recaptcha" data-sitekey="6Le9UroUAAAAAJnuTdtQralY49pH3OvsAT7H03CF"></div><br>
                                    <img id="ajaxLoader" src="uploads/pages/ajax-loader.gif" style="display: none; margin-left: auto; margin-right: auto;">
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="button-box">
                                        <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="">
                                        <button id="submit-btn" class="btn-one" type="submit" data-loading-text="Please wait..."><?php echo getLangText('submit here') ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br>
                        <div id="success-message-div" class="result sc_infobox sc_infobox_style_success" style="display: none"></div>
                        <div id="error-message-div" class="result sc_infobox sc_infobox_style_error" style="display: none"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--End contact form area-->
		<!-- Map code goes here-->
    <?php include 'inc_footer.php'; ?>

</div>
<div class="scroll-to-top scroll-to-target thm-bg-clr" data-target="html"><span class="fa fa-angle-up"></span></div>


<!-- main jQuery -->
<script src="js/jquery.js"></script>

<script src="js/wow.js"></script>

<script src="js/bootstrap.min.js"></script>

<script src="js/jquery.bxslider.min.js"></script>

<script src="js/jquery.fancybox.js"></script>

<script src="js/jquery.countTo.js"></script>
<script src="js/appear.js"></script>

<script src="js/owl.js"></script>

<!--<script src="js/validation.js"></script>-->

<script src="js/jquery.mixitup.min.js"></script>

<script src="js/isotope.js"></script>

<script src="js/jquery.easing.min.js"></script>

<script src="assets/jquery-ui-1.11.4/jquery-ui.js"></script>

<script src="assets/language-switcher/jquery.polyglot.language.switcher.js"></script>

<script src="assets/timepicker/timePicker.js"></script>

<script src="assets/bootstrap-sl-1.12.1/bootstrap-select.js"></script>

<script src="assets/html5lightbox/html5lightbox.js"></script>



<!-- thm custom script -->
<script src="js/custom.js"></script>

<script>
		var coll = document.getElementsByClassName("collapsible");
		var i;

		for (i = 0; i < coll.length; i++) {
		coll[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var content = this.nextElementSibling;
			if (content.style.display === "block") {
				content.style.display = "none";
			} else {
				content.style.display = "block";
			}
		});
		}

</script>


<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>

<script>
    $(document).ready(function () {
        console.clear();
    });
    $("form#contactForm").submit(function (e)
    {

        e.preventDefault();
        $('#ajaxLoader').show();
        $('#submit-btn').hide();

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "ajax_contactus.php",
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
                    $("#success-message-div").show();
                    // $("#success-message-div").html(message).delay(3000).fadeOut('slow');
                    // $('#contact-form')[0].reset();
                    $('#contactForm').hide();
                    $("#success-message-div").html(message);
                }

                if (statusmessage.toString().trim() === "ERROR") {
                    // $("#error-message-div").css('display', 'block');
                    $("#ajaxLoader").css('display', 'block');
                    $('#ajaxLoader').hide();
                    $('#submit-btn').show();
                    $("#error-message-div").show();
                    $("#error-message-div").html(message).delay(3000).fadeOut('slow');
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
    #success-message-div
    {
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

    #error-message-div
    {
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
