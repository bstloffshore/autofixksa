<?php
include "inc_opendb.php";
$page_id = "Services";
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'inc_metadata.php'; ?>
	
<!-- Campaign stylesheet -->
	<link rel="stylesheet" href="css/onepager.css">	

<body <?php if ( $lang == 'ar' ) { echo 'dir="rtl"'; } ?>>
	
	<?php include 'inc_google_tag_body.php'; ?>
	
	
<div class="boxed_wrapper">
<?php include 'inc_header_onepager.php'; ?>

    <?php
    $pageID = 2;
    $res = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
    $row = mysqli_fetch_assoc($res);

    $title             = $row['title'];
    $bgimage           = $row['image'];
    ?>

<section class="breadcrumb-area" style="background-image:url('uploads/pages/<?php echo $bgimage ;?>');">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="inner-content text-center clearfix">
                    <div class="breadcrumb-menu">
                        <ul class="clearfix">
                                                       <li class="active"> Welcome to AutoFix !</li>
                        </ul>    
                    </div>
                    <div class="title">
                       <h1>The complete Auto Care</h1>
                    </div>
                </div>
            </div>
        </div>
	</div>
</section>

	
	
	
	
	
	
	
	
	
	
	<section class="benefits-area secpd1">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="benefits-image-box wow slideInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                    <img src="assets/onepager/info-man-repair.jpg" alt="Awesome Image">
                </div>    
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="benefits-text-box">
                    <div class="sec-title">
                        <h3>About Us</h3>
                        <div class="title">A One-Stop Solution<br>For Auto Services</div>
                    </div>
                    <div class="inner-content">
						
						<p>AUTOFIX was establishied in Saudi Arabia in 2019 to provide a complete solution for multi-brand automotive services. It is part of Gulf Advantages Automobile (GAA) business activities in Saudi Arabia, which is a part of Suhail Bahwan International Group Holding (SBIGH). </p>
						
                        <ul>
                            <li><i class="fa fa-check" aria-hidden="true"></i> Professional & Qualified Mechanics.</li>
                            <li><i class="fa fa-check" aria-hidden="true"></i>Focus on no hassle pricing and convenience. </li>
                            <li><i class="fa fa-check" aria-hidden="true"></i>Specialized expertise, without any compromise.</li>
                            <li><i class="fa fa-check" aria-hidden="true"></i>Unique competence and outstanding quality at fair prices.</li>
                            <li><i class="fa fa-check" aria-hidden="true"></i> Locations in all major cities in the Kingdom. </li>
                            <li><i class="fa fa-check" aria-hidden="true"></i>Adding value to safety, performance and comfort.</li>
                        </ul>
                        
                    </div> 
                </div>    
            </div>
        </div>  
    </div>
</section>
	
	
	
	
	
	
	
	
	
	<?php
$pageID = 8;
$res2 = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
$row2 = mysqli_fetch_assoc($res2);

$title               = $row2['title'];
$summary             = $row2['summary'];
$image               = $row2['image'];
?>

	
	
	
	
	
	<section class="choose-area" style="background-image:url('uploads/pages/<?php echo $image ;?>');">
    <div class="container">
        <div class="sec-title clr-white text-center">
            <h3><?php echo $title ;?></h3>
            <div class="title"><?php echo $summary ;?></div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <ul class="choose-content fix service-anchor-color">
                    <?php
                    $i = 100;
                    $serviceres = $db->query("SELECT * FROM services WHERE active = 1 ORDER BY so ASC");
                    while ($servicerow = mysqli_fetch_assoc($serviceres)) {
                        $i = $i+100;
                        ?>

                        <li class="single-choose-box wow fadeInUp" data-wow-delay="<?php echo $i;?>ms" data-wow-duration="500ms">
                            <span class="<?php echo $servicerow['class'];?>"></span>
<!--                            <h4>Oil <br> Change</h4>-->
                            <h4><?php echo $servicerow['serviceTitle'];?></h4>
                        </li>
                        <?php
                    }
                    ?>

					
                </ul>
            </div>
        </div>
        <?php
        $pageID = 7;
        $res1 = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
        $row1 = mysqli_fetch_assoc($res1);

        $summary             = $row1['summary'];
        ?>
        
    </div>
</section>
	
	
	
	
	
	
<section class="contact-info-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-6">
                <div class="contact-info-content">
                    <div class="sec-title">
                        <h3>Get in Touch</h3>
                        <div class="title">Drop us a Message</div>
                    </div>
                    <div class="inner-content">
                        <div class="text">
                            <p>Contact us for all your automotive service needs. We are always available for your queries & requirements.</p>
                        </div>
                        <ul>
                            <li>
                                <p>Call Us</p>
                                <span>920006196</span>
                            </li>
                            <li>
                                <p>Send an Email</p>
                                <span>info@autofix.com</span>
                            </li>
                            <li>
                                <p>Visit Us</p>
                                <span>King Fahad Road, Riyadh, Saudi Arabia</span>
                            </li>
                        </ul>
                    </div>
                </div>    
            </div>
            <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                <div class="contact-form">
                    <form id="contact-form" name="contact_form" class="default-form" action="http://mehedi.asiandevelopers.com/demo/html/fouens/inc/sendmail.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-box">   
                                    <input type="text" name="form_name" value="" placeholder="Your Name" required="">
                                    <div class="icon">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </div>
                                </div>    
                            </div>
                            <div class="col-md-6">
                                <div class="input-box"> 
                                    <input type="email" name="form_email" value="" placeholder="Email Address" required="">
                                    <div class="icon">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                    </div>
                                </div>    
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-box"> 
                                    <input type="text" name="form_phone" value="" placeholder="Phone">
                                    <div class="icon">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                    </div>
                                </div>    
                            </div>
                            <div class="col-md-6">
                                <div class="input-box"> 
                                    <input type="text" name="form_subject" value="" placeholder="Subject"> 
                                    <div class="icon">
                                        <i class="fa fa-file-text" aria-hidden="true"></i>
                                    </div>
                                </div>    
                            </div>      
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-box">    
                                    <textarea name="form_message" placeholder="Your Message.." required=""></textarea> 
                                    <div class="icon">
                                        <i class="fa fa-comment" aria-hidden="true"></i>
                                    </div>
                                </div>   
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="button-box">
                                    <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="">
                                    <button class="btn-one" type="submit" data-loading-text="Please wait...">Submit </button>    
                                </div>     
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</section>



<?php include 'inc_footer_onepager.php'; ?>   
	
</div>  

<?php include 'inc_footer_scripts.php'; ?>

</body>
</html>