<?php
include "inc_opendb.php";
$page_id = "Services Info";



$slug = filter_var($_GET['slug'], FILTER_SANITIZE_STRING);
if (empty($slug)) {
    header("location:services");
    exit();
}

$service_info_res = $db->query("select * from services WHERE slug = ?s", $slug);
$service_info_row = mysqli_fetch_assoc($service_info_res);
$title   = $service_info_row['serviceTitle'.$langid];
$image   = $service_info_row['largeImage'];
$bgimage = $service_info_row['headerImage'];
$description   = $service_info_row['description'.$langid];
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'inc_metadata.php'; ?>

<body <?php if ( $lang == 'ar' ) { echo 'dir="rtl"'; } ?>>

	<?php include 'inc_google_tag_body.php'; ?>

<div class="boxed_wrapper">

    <?php include 'inc_header.php'; ?>


    <section class="breadcrumb-area" style="background-image:url('uploads/services/<?php echo $bgimage ;?>');">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="inner-content text-center clearfix">
                      <!--  <div class="breadcrumb-menu">
                            <ul class="clearfix">
                                <li><a href="/"><?php echo getLangText('home') ?></a></li>
                                <li class="active"><a href="services"><?php echo getLangText('Services') ?></a></li>
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


    <section class="single-service-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12">
                    <div class="single-service-sidebar">

                        <div class="single-sidebar">
                            <div class="service-sidebar-title">
                                <h3><?php echo getLangText('categories') ?></h3>
                            </div>
                            <ul class="service-pages">
                                <?php
                                $serviceres = $db->query("SELECT * FROM services WHERE active = 1 ORDER BY so ASC");
                                while ($servicerow = mysqli_fetch_assoc($serviceres)) {
                                    ?>
                                    <li class="<?php if($slug == $servicerow['slug']) echo 'active';?>"><a href="/service/<?php echo $servicerow['slug'];?>"><?php echo $servicerow['serviceTitle'.$langid];?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>

                        <div class="sidebar-box-online text-center service-info-color" style="background-image:url(images/sidebar/sidebar-box-online-bg.jpg);">
<!--                            <h3>Get Estimate</h3>-->
<!--                            <div class="title">keep your<br> carpets <br>clean</div>-->


                                    <h3><?php echo getLangText('have any questions') ?></h3>
                            <?php
                            $pageID = 1;
                            $otherres = $db->query( "SELECT * FROM others WHERE id=?i",$pageID);
                            $otherrow = mysqli_fetch_assoc($otherres);

                            $phone           = $otherrow['phone'];
                            $email           = $otherrow['email'];
                            $address         = $otherrow['address'.$langid];
                            ?>
                                <ul>
                                    <li>
                                        <span><?php echo getLangText('contact us') ?></span>
                                        <h3><?php echo $phone;?></h3>
                                    </li>
                                    <li>
                                        <span><?php echo getLangText('email') ?></span>
                                        <h3><?php echo $email;?></h3>
                                    </li>
                                    <li>
                                        <span><?php echo getLangText('our address') ?></span>
                                        <h3><?php echo $address;?></h3>
                                    </li>
                                </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12">
                    <div class="single-service-top service-info">
                        <div class="top-image-holder">
                            <img src="uploads/services/<?php echo $image;?>" alt="<?php echo $title;?>">
                        </div>
                        <div class="sec-title-box">
                            <h1><?php echo $title;?></h1>
                        </div>
                        <div class="text">
                            <?php echo $description;?>
                        </div>

<!--                        <div class="row">-->
<!--                            <div class="col-xl-12">-->
<!--                                <div class="single-service-image-box">-->
<!--                                    <div class="icon-box">-->
<!--                                        <div class="inner">-->
<!--                                            <img src="images/icon/2.png" alt="Icon">-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="single-image-box float-left">-->
<!--                                        <img src="images/services/service-single/1.jpg" alt="Awesome Image">-->
<!--                                    </div>-->
<!--                                    <div class="single-image-box float-right">-->
<!--                                        <img src="images/services/service-single/2.jpg" alt="Awesome Image">-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->

                    </div>
<!--                    <div class="single-service-bottom-text">-->
<!--                        <ul>-->
<!--                            <li>-->
<!--                                <div class="text">-->
<!--                                    <h4>The best way to keep your carpets clean longer</h4>-->
<!--                                    <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="text">-->
<!--                                    <h4>Carpets cleaning done right, Revive your carpet</h4>-->
<!--                                    <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </div>-->
                </div>

            </div>
        </div>
    </section>


    <?php include 'inc_footer.php'; ?>


</div>

<?php include 'inc_footer_scripts.php'; ?>

</body>
</html>
