<?php
include "inc_opendb.php";
$page_id = "About";

//echo print_r($lang);

?>

<!DOCTYPE html>
<html lang="en">

<?php include 'inc_metadata.php'; ?>

<body <?php if ( $lang == 'ar' ) { echo 'dir="rtl"'; } ?>>

	<?php include 'inc_google_tag_body.php'; ?>


<div class="boxed_wrapper">

    <?php include 'inc_header.php'; ?>
    <?php
    $pageID = 1;
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
                      <!--  <div class="breadcrumb-menu">
                            <ul class="clearfix">
                                <li><a href="/"><?php echo getLangText('home') ?></a></li>
                                <li class="active"><?php echo $title;?></li>
                            </ul>
                        </div> -->
                        <div class="title">
                            <h1><?php echo $title;?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    $pageID = 1;
    $aboutres = $db->query( "SELECT * FROM about_us WHERE id=?i",$pageID);
    $aboutrow = mysqli_fetch_assoc($aboutres);

    $title             = $aboutrow['section_01_title'.$langid];
    $image             = $aboutrow['section_01_image'];
    $summary_01        = $aboutrow['section_01_summary'.$langid];
    $description_01    = $aboutrow['section_01_description'.$langid];
    $summary_02        = $aboutrow['section_02_summary'.$langid];
    $description_02_01 = $aboutrow['section_02_description_01'.$langid];
    $description_02_02 = $aboutrow['section_02_description_02'.$langid];
    ?>
    <section class="welcome-area style2 secpd1">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="welcome-image-box2 clearfix">
                        <img src="uploads/pages/<?php echo $image;?>" alt="<?php echo $title;?>">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="welcome-content-box2">
                        <div class="sec-title">
                            <h3><?php echo $title;?></h3>
                            <div class="title"><?php echo $summary_01;?></div>
                        </div>
                        <div class="inner-content">
                            <div class="text">
                                <?php echo $description_01;?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="provide-area">
        <div class="container">
            <div class="row provide-content">
                <div class="col-xl-4">
                    <div class="provide-title">
                        <div class="sec-title">
                            <div class="title"><?php echo $summary_02;?></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="single-provide-text">
                        <?php echo $description_02_01;?>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="single-provide-text">
                        <?php echo $description_02_02;?>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

</body>
</html>
