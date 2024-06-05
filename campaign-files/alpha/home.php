<?php
include "../../inc_opendb.php";
$page_id = "Home";
$lang    = $_SESSION['lang'];

//echo $lang;
//echo "<pre>";
//echo print_r($_SESSION);
//echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Autofix Campaign">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Autofix Campaign">
    <meta name="keywords" content="autofix, campaign">
    <meta name="description" content="Autofix Campaign">
    <title>Autofix Campaign</title>
    <link rel="shortcut icon" href="images/favicon.png" />
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
		<!-- FLaticon stylesheet -->
	<link rel="stylesheet" type="text/css" href="flaticons/flaticon.css">
	
	
		<!-- Custom stylesheet -->
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	
</head>

<body>

    <!-- PRELOADER -->
    <div id="preloader">
        <div id="status">
            <img src="images/preloader.gif">
        </div>
    </div>
    <!-- /PRELOADER -->

    <!-- Navbar -->
    <nav class="navbar navbar-default cs-primary-navbar">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand cs-logo" href="index-2.html"><img src="images/logo_rev.png" alt="logo"></a>
                <button type="button" class="navbar-toggle offcanvas-toggle pull-right" data-toggle="offcanvas" data-target="#js-bootstrap-offcanvas" style="float:left;">
                        <span class="sr-only">Toggle navigation</span>
                        <span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </span>
                    </button>
            </div>
            <div class="navbar-offcanvas navbar-offcanvas-touch navbar-offcanvas-right" id="js-bootstrap-offcanvas">
                <ul class="nav navbar-nav navbar-right">
                    <li> <span class="cs-nav-text">Stay Connected</span></li>
                    <li>
                        <a href="#features" class="wow zoomIn animated" data-wow-delay="0.6s"> <i class="cs-fa fa fa-facebook" aria-hidden="true"></i> <span class="visible-xs-inline-block"> &nbsp; Facebook</span> </a>
                    </li>
                    <li>
                        <a href="#features" class="wow zoomIn animated" data-wow-delay="0.8s"> <i class="cs-fa fa fa-twitter" aria-hidden="true"></i> <span class="visible-xs-inline-block"> &nbsp; Twitter</span> </a>
                    </li>
                    <li>
                        <a href="#features" class="wow zoomIn animated" data-wow-delay="1s"> <i class="cs-fa fa fa-linkedin" aria-hidden="true"></i> <span class="visible-xs-inline-block"> &nbsp; LinkdIn</span> </a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
    <!-- /Navbar -->

    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-lg-push-5 col-md-7 col-md-push-5 col-sm-6 col-sm-push-6">
                    <div class="header-content">
						<h1 class="wow animated fadeInUp" data-wow-delay="600ms">Professional<br><span>Auto-Repair</span> <br>Services</h1>
                        <ul class="list-inline wow animated fadeInUp" data-wow-delay="1000ms">
                            <li><a href="#" class="btn btn-primary btn-radius">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5 col-lg-pull-7 col-md-5 col-md-pull-7  col-sm-6 col-sm-pull-6">
                    <form>
                        <div class="cs-header-form">
                            <h2>Book Our Services Now</h2>
                            <h4>Fill The Form And Get 50% Off on All Services !</h4>
                            <div class="form-group cs-form-group">
                                <input type="text" class="form-control" placeholder="Enter Your Name" required="">
                            </div>
                            <div class="form-group cs-form-group">
                                <input type="email" class="form-control" placeholder="Enter Your Email" required="">
                            </div>
                            <div class="form-group cs-form-group">
                                <input type="text" class="form-control" placeholder="Phone Number" required="">
                            </div>
							 <div class="form-group cs-form-group">
                                <textarea name="form_message" placeholder="Your Message.." required="" spellcheck="false"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </form>
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
                        <h2>About Autofix</h2>
                        <p><strong>We are a fully featured multi-brand car servicing company. Our mechanical services include all types of vehicles, offering everything from oil changes and tune ups to brake jobs and no-starts. </strong></p>
                        <p>AUTOFIX was establishied in Saudi Arabia in 2019 as a one stop solution for multi-brand automotive services. It is a part of Gulf Advantages Automobile (GAA) business activities in Saudi Arabia, which is a part of Suhail Bahwan International Group Holding (SBIGH).  </p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="cs-icon-media wow animated fadeInUp animated">
                                <div class="media-left">
                                    <i class="cs-icon icon icon-Heart"></i>
                                </div>
                                <div class="media-body">
                                    <h4>Expert Staff</h4>
                                    <p>Professional and Qualified Mechanics.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cs-icon-media wow animated fadeInUp animated">
                                <div class="media-left">
                                    <i class="cs-icon icon icon-Dollars"></i>
                                </div>
                                <div class="media-body">
                                    <h4>Competitive Pricing</h4>
                                    <p>Hassle- Free Pricing and Affordability.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cs-icon-media wow animated fadeInUp animated">
                                <div class="media-left">
                                    <i class="cs-icon icon icon-Settings"></i>
                                </div>
                                <div class="media-body">
                                    <h4>One-Stop Solution</h4>
                                    <p>Meet and Exceed Customer Expectations.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cs-icon-media wow animated fadeInUp animated">
                                <div class="media-left">
                                    <i class="cs-icon icon icon-Time"></i>
                                </div>
                                <div class="media-body">
                                    <h4>Convenient Locations</h4>
                                    <p>Located in All Major Cities in the Kingdom.</p>
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

    <!-- Call to Action #Banner -->
    <div class="cs-call-action">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h1 class="wow fadeInUp animated">Are you a corporate?<br> Let's discuss out partnership solutions.</h1>
                    <h2 class="wow fadeInUp animated">Call us at 920006196</h2>
                    <ul class="list-inline wow fadeInUp animated">
                        <li><a href="#" class="btn btn-secondary ">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /Call to Action #Banner -->

    <!-- Icon Texts -->
    <section class="section-sm">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="cs-section-heading">
                        <h2 class="wow animated fadeInUp">Our Services</h2>
                        <h4 class="wow animated fadeInUp"> Benefit from our unique competence and outstanding quality. Go through our vast range of professional services.</h4>
                    </div>
                </div>
            </div>
            <div class="row">
				
		
				
					<?php
$pageID = 8;
$res2 = $db->query( "SELECT * FROM pages_static WHERE id=?i",$pageID);
$row2 = mysqli_fetch_assoc($res2);

$title               = $row2['title'];
$summary             = $row2['summary'];
$image               = $row2['image'];
?>

				
				
		 <?php
                    $i = 100;
                    $serviceres = $db->query("SELECT * FROM services WHERE active = 1 ORDER BY so ASC");
                    while ($servicerow = mysqli_fetch_assoc($serviceres)) {
                        $i = $i+100;
                        ?>
				
				
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card wow animated fadeInUp">
                        <div class="card-icon">
						 <span class="<?php echo $servicerow['class'];?>"></span>
						</div>
                        <h4 class="card-title"><?php echo $servicerow['serviceTitle'];?></h4>
                    </div>
                </div>
                
				
		
				   <?php
                    }
                    ?>

                
                
            </div>
        </div>
    </section>
    <!-- /Cards -->

    <!-- GALLERY -->
    
    <!-- /GALLERY -->

    <!-- Price Section -->
    
    <!-- /Price Section -->

    <!-- Testimonials -->
    
    <!-- /Testimonials -->

    <!-- Team Cards -->
    
    <!-- /Team Cards -->

    <!-- Call to action -contact -->
    <div class="cs-cotact-action-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="cs-contact-action wow animated zoomIn">
                        <div class="icon icon-Phone2"></div>
                        <h4>Call Us </h4>
                        <h2>920006196</h2>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="cs-contact-action wow animated zoomIn">
                        <div class="icon icon-Mail"></div>
                        <h4>Drop an Email</h4>
                        <h2>info@autofixksa.com</h2>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="cs-contact-action wow animated zoomIn">
                        <div class="icon icon-Time"></div>
                        <h4>Visit Us</h4>
                        <h2>King Fahad Road, Riyadh, Saudi Arabia</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Call to action -contact -->

    <!-- Google Map -->
    <div class="google-map" id="pw-portal-map"></div>
    <!-- /Google Map -->

    <!--Newsletter-->
    
    <!--/Newsletter -->

    <!-- Footer -->
    <div class="cs-copyright-bar">
        <div class="container">
            <ul class="cs-footer-navbar">
                <li><a href="#">Visit Website </a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms & Conditions</a></li>
            </ul>
            <div class="cs-copy-text">© 2019 All rights reserved. </div>
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
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script src="js/main.js"></script>

    <script>
        $(document).ready(function() {
            "use strict";

            function e() {
                var e = {
                        center: a,
                        zoom: 10,
                        /*scrollwheel:!0*/
                        scrollwheel: false,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        styles: [{
                            featureType: "landscape",
                            stylers: [{
                                hue: "#FFBB00"
                            }, {
                                saturation: -111.400000000000006
                            }, {
                                lightness: 17.599999999999994
                            }, {
                                gamma: 1
                            }]
                        }, {
                            featureType: "road.highway",
                            stylers: [{
                                hue: "#FFC200"
                            }, {
                                saturation: -61.8
                            }, {
                                lightness: 45.599999999999994
                            }, {
                                gamma: 1
                            }]
                        }, {
                            featureType: "road.arterial",
                            stylers: [{
                                hue: "#FF0300"
                            }, {
                                saturation: -100
                            }, {
                                lightness: 51.19999999999999
                            }, {
                                gamma: 1
                            }]
                        }, {
                            featureType: "road.local",
                            stylers: [{
                                hue: "#FF0300"
                            }, {
                                saturation: -100
                            }, {
                                lightness: 52
                            }, {
                                gamma: 1
                            }]
                        }, {
                            featureType: "water",
                            stylers: [{
                                hue: "#0078FF"
                            }, {
                                saturation: -13.200000000000003
                            }, {
                                lightness: 2.4000000000000057
                            }, {
                                gamma: 1
                            }]
                        }, {
                            featureType: "poi",
                            stylers: [{
                                hue: "#00FF6A"
                            }, {
                                saturation: -1.0989010989011234
                            }, {
                                lightness: 11.200000000000017
                            }, {
                                gamma: 1
                            }]
                        }]

                    },
                    t = new google.maps.Map(document.getElementById("pw-portal-map"), e),
                    s = {
                        url: ""
                    },
                    o = new google.maps.Marker({
                        position: a,
                        map: t,
                        icon: s,
                        animation: google.maps.Animation.BOUNCE
                    });
                o.setMap(t);
                var n = new google.maps.InfoWindow({
                    content: "<strong>Silicon Valley, HITEC City <br> Hyderabad, Telangana 500081</strong>"
                });
                google.maps.event.addListener(o, "click", function() {
                    n.open(t, o)
                })
            }
            var a;
            a = new google.maps.LatLng("17.451603", "78.380930"), google.maps.event.addDomListener(window, "load", e), a = new google.maps.LatLng("17.451603", "78.380930")
        });

    </script>
</body>

</html>
