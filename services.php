<?php
include "inc_opendb.php";
$page_id = "Services";
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'inc_metadata.php'; ?>

<body <?php if ( $lang == 'ar' ) { echo 'dir="rtl"'; } ?>>

	<?php include 'inc_google_tag_body.php'; ?>


<div class="boxed_wrapper">
<?php include 'inc_header.php'; ?>

    <?php
    $pageID = 2;
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



<section class="services-style1-area secpd1">
    <div class="container">

        <div class="row">

		<?php
        $serviceres = $db->query("SELECT * FROM services WHERE active = 1 ORDER BY so ASC");
        while ($servicerow = mysqli_fetch_assoc($serviceres)) {
        ?>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                <div class="single-service-style1 wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1200ms">
                    <div class="inner"> <a href="/service/<?php echo $servicerow['slug'];?>">
                        <div class="img-holder">
                           <img src="uploads/services/<?php echo $servicerow['image'];?>" alt="<?php echo $servicerow['serviceTitle'.$langid];?>">
                        </div>
						</a>
                    </div>
                    <div class="text-holder service-landing">
                        <h4 class="service-landing-title"><a href="/service/<?php echo $servicerow['slug'];?>"><?php echo $servicerow['serviceTitle'.$langid];?></a></h4>
						<p class="service-summary text-left text-ar-right"><?php echo $servicerow['summary'.$langid];?></p>
                    </div>
                </div>
            </div>

			<?php } ?>


        </div>

        <?php
        $pageID = 3;
        $res1 = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
        $row1 = mysqli_fetch_assoc($res1);

        $summary             = $row1['summary'.$langid];
        ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="contact-us text-center wow fadeInUp" data-wow-delay="1000ms" data-wow-duration="1500ms">
                    <h3><?php echo $summary;?><a href="contact-us"> <span> <?php echo getLangText('contact us') ?></span></a> </h3>
                </div>
            </div>
        </div>
    </div>
</section>



<?php include 'inc_footer.php'; ?>

</div>

<?php include 'inc_footer_scripts.php'; ?>

</body>
</html>
