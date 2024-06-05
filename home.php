<?php
include "inc_opendb.php";
$page_id = "Home";
$lang    = $_SESSION['lang'];

//echo $lang;
//echo "<pre>";
//echo print_r($_SESSION);
//echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'inc_metadata.php'; ?>

<body <?php if ( $lang == 'ar' ) { echo 'dir="rtl"'; } ?>>

<?php //include 'inc_google_tag_body.php'; ?>


<div class="boxed_wrapper">

    <?php include 'inc_header.php'; ?>

    <?php include 'inc_slider.php'; ?>

    <?php include "inc_about_us.php"; ?>

    <?php include 'inc_services.php'; ?>

    <?php include "inc_how_it_works.php"; ?>

    <?php include "inc_why_choose_us.php"; ?>

    <?php //include 'inc_testimonials.php'; ?>

    <?php include 'inc_getestimate.php'; ?>

<!--    --><?php //include 'inc_partners.php'; ?>

    <?php include 'inc_footer.php'; ?>

</div>


<?php include 'inc_footer_scripts.php'; ?>


<script>

    $("#langSwitch").click(function (event){
        event.preventDefault();
        console.log("Lang Clicked: " + $(this).data("lang"));
        var language = $(this).data("lang");
        $.post('about.php', { lang: language }, function(data, status, xhr)
        {
            // console.log(data);
        }).done(function() {
            console.log("Changed");
            location.reload();
        })
            .fail(function(jqxhr, settings, ex) { console.log('failed, ' + ex); });
    });

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
<script>

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
<!--Revolution Slider-->
<script src="plugins/revolution/js/jquery.themepunch.revolution.min.js"></script>
<script src="plugins/revolution/js/jquery.themepunch.tools.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.actions.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.migration.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.video.min.js"></script>
<script src="js/main-slider-script.js"></script>

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
