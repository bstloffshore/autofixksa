<?php
include "inc_opendb.php";
$page_id = "Get Estimate";
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'inc_metadata.php'; ?>

<body <?php if ( $lang == 'ar' ) { echo 'dir="rtl"'; } ?>>

	<?php include 'inc_google_tag_body.php'; ?>

<div class="boxed_wrapper">

    <?php include 'inc_header.php'; ?>

    <?php
    $pageID = 17;
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

            </div>
        </div>
    </section>


    <?php include 'inc_footer.php'; ?>

</div>

<?php include 'inc_footer_scripts.php'; ?>

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
    $("input[name='services']").change(function () {
        totalCount = calculateAll();
    });

    function calculateAll() {
        // console.log("Calling");
        count = 0;
        $("input[name='services']").each(function (index, checkbox) {
            if (checkbox.checked)
                count += parseInt(checkbox.value)
        });
        $("#totalValue").html(count);
        $("#totalCount").val(count);
    }
</script>

<script>
    $(document).ready(function () {
        // console.clear();
    });
    $("#estimate-Form").submit(function (e) {
        e.preventDefault();
        $('#ajaxLoader').show();
        $('#estimateButton').hide();

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "ajax_estimate.php",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                // console.log(data);
                var statusmessage = data.trim().split("|")[0];
                var message = data.trim().split("|")[1];


                if (statusmessage.toString().trim() === "SUCCESS") {
                    // $("#success-message-div").css('display', 'block');
                    $("#estimate-success-div").show();
                    // $("#success-message-div").html(message).delay(3000).fadeOut('slow');
                    // $('#contact-form')[0].reset();
                    $('#estimate-Form').hide();
                    $("#estimate-success-div").html(message);
                }

                if (statusmessage.toString().trim() === "ERROR") {
                    // $("#error-message-div").css('display', 'block');
                    $("#ajaxLoader").css('display', 'block');
                    $('#ajaxLoader').hide();
                    $('#estimateButton').show();
                    $("#estimate-error-div").show();
                    $("#estimate-error-div").html(message).delay(3000).fadeOut('slow');
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
    #estimate-success-div {
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

    #estimate-error-div {
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
