<head>

	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-WMCCKHG');</script>
	<!-- End Google Tag Manager -->



	<meta charset="UTF-8">
	
<?php 
// Get the current URL
$currentUrl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

// Parse the URL
$parsedUrl = parse_url($currentUrl);

// Get the parameter
$parameter = trim($parsedUrl['path'], '/');

$metaTitle = $metaDescription = $metaKeywords = "";

// Home Page
if ($parameter == "" || $parameter == "home") {
    $metaTitle = "AUTOFIX - Your Complete Car Care Solution";
    $metaDescription = "Welcome to AUTOFIX, your one-stop solution for multi-brand automotive services. Join us in Riyadh & Dammam to experience a revolution in tires, custom wheels, car accessories, and auto services.";
    $metaKeywords = "AUTOFIX, car care, automotive services, tires, custom wheels, car accessories, revolution in auto services, Riyadh, Dammam";
 	$canonical = "https://autofixksa.com/";
    $robots = "index,follow";
    $og_title = "AUTOFIX - Your Complete Car Care Solution";
	$og_description = "Welcome to AUTOFIX, your one-stop solution for multi-brand automotive services.";
	$og_url = "https://autofixksa.com/";
	$og_type = "article";
	$og_locale = "en_US";
} 
// About Page
elseif ($parameter == 'about') {
    $metaTitle = "About AUTOFIX - A Part of Bahwan International Group";
    $metaDescription = "Explore AUTOFIX, a part of Bahwan International Group (BIG). Established in Saudi Arabia in 2019, AUTOFIX is a one-stop solution for multi-brand automotive services.";
    $metaKeywords = "AUTOFIX, Bahwan International Group, BIG, Saudi Arabia, multi-brand automotive services";
	$canonical = "https://autofixksa.com/about";
    $robots = "index,follow";
    $og_title = "About AUTOFIX - A Part of Bahwan International Group";
	$og_description = "Explore AUTOFIX, a part of Bahwan International Group (BIG). ";
	$og_url = "https://autofixksa.com/about";
	$og_type = "article";
	$og_locale = "en_US";
	
} 
// Services Page
elseif ($parameter == 'services') {
    $metaTitle = "AUTOFIX Services - Enhancing Your Car's Safety and Performance";
    $metaDescription = "Discover a range of services at AUTOFIX dedicated to enhancing your car's safety, performance, and comfort. We provide easy and fast services to meet and exceed customer expectations.";
    $metaKeywords = "AUTOFIX services, car safety, car performance, customer expectations, automotive services";
	$canonical = "https://autofixksa.com/services";
    $robots = "index,follow";
    $og_title = "AUTOFIX Services - Enhancing Your Car's Safety and Performance";
	$og_description = "Discover a range of services at AUTOFIX dedicated to enhancing your car's safety, performance, and comfort.";
	$og_url = "https://autofixksa.com/services";
	$og_type = "article";
	$og_locale = "en_US";
}
// Service Info Page
elseif ($parameter == 'service') {
    // You may customize this based on the specific service info
    $metaTitle = "AUTOFIX Service - services";
    $metaDescription = "Learn more about the service at AUTOFIX. Our professionals are dedicated to adding value to your car's safety, performance, and comfort.";
    $metaKeywords = "AUTOFIX service, car safety, car performance, automotive services";
	$canonical = "https://autofixksa.com/service/oil-change";
    $robots = "index,follow";
    $og_title = "AUTOFIX Service - services";
	$og_description = "Learn more about the service at AUTOFIX. Our professionals are dedicated to adding value to your car's safety.";
	$og_url = "https://autofixksa.com/service/oil-change";
	$og_type = "article";
	$og_locale = "en_US";
}
// Get Estimate Page
elseif ($parameter == 'get-estimate') {
    $metaTitle = "Get Estimate - AUTOFIX Car Services";
    $metaDescription = "Request an estimate for your car services at AUTOFIX. Our professionals are here to provide you with accurate and transparent cost estimates.";
    $metaKeywords = "AUTOFIX estimate, car services estimate, transparent cost estimates";
	$canonical = "https://autofixksa.com/get-estimate";
    $robots = "index,follow";
    $og_title = "Get Estimate - AUTOFIX Car Services";
	$og_description = "Request an estimate for your car services at AUTOFIX. Our professionals are here to provide you with accurate and transparent cost estimates.";
	$og_url = "https://autofixksa.com/get-estimate";
	$og_type = "article";
	$og_locale = "en_US";
}
// Contact Us Page
elseif ($parameter == 'contact-us') {
    $metaTitle = "Contact AUTOFIX - Reach Out for Inquiries and Assistance";
    $metaDescription = "Contact AUTOFIX for inquiries and assistance. Our team is ready to help you with any questions regarding our car services and solutions.";
    $metaKeywords = "AUTOFIX Contact Us, inquiries, assistance, car services, customer support";
	$canonical = "https://autofixksa.com/contact-us";
    $robots = "index,follow";
    $og_title = "Contact AUTOFIX - Reach Out for Inquiries and Assistance";
	$og_description = "Contact AUTOFIX for inquiries and assistance. Our team is ready to help you with any questions regarding our car services and solutions.";
	$og_url = "https://autofixksa.com/contact-us";
	$og_type = "article";
	$og_locale = "en_US";
}
// Campaign Page
elseif ($parameter == 'campaign') {
    // You may customize this based on the specific campaign
    $metaTitle = "AUTOFIX Campaign - [Campaign Name]";
    $metaDescription = "Explore the [Campaign Name] at AUTOFIX. Join us to experience exclusive offers and promotions for tires, custom wheels, car accessories, and more.";
    $metaKeywords = "AUTOFIX campaign, [Campaign Name], exclusive offers, promotions, tires, custom wheels, car accessories";
	$canonical = "";
    $robots = "index,follow";
    $og_title = "";
	$og_description = "";
	$og_url = "";
	$og_type = "article";
	$og_locale = "en_US";
}
// Thank You Page
elseif ($parameter == 'thank-you') {
    $metaTitle = "Thank You - AUTOFIX Appreciates Your Interaction";
    $metaDescription = "AUTOFIX appreciates your interaction. Thank you for choosing us. We look forward to providing you with exceptional car care services.";
    $metaKeywords = "AUTOFIX Thank You, appreciates, exceptional car care services";
	$canonical = "https://autofixksa.com/thank-you";
    $robots = "index,follow";
    $og_title = "Thank You - AUTOFIX Appreciates Your Interaction";
	$og_description = "AUTOFIX appreciates your interaction. Thank you for choosing us.";
	$og_url = "https://autofixksa.com/thank-you";
	$og_type = "article";
	$og_locale = "en_US";
}
// Default meta tags for unrecognized routes
else {
    $metaTitle = "AUTOFIX - Your Complete Car Care Solution";
    $metaDescription = "Welcome to AUTOFIX, your one-stop solution for multi-brand automotive services. Join us in Riyadh & Dammam to experience a revolution in tires, custom wheels, car accessories, and auto services.";
    $metaKeywords = "AUTOFIX, car care, automotive services, tires, custom wheels, car accessories, revolution in auto services, Riyadh, Dammam";
	$canonical = "";
    $robots = "index,follow";
    $og_title = "AUTOFIX - Your Complete Car Care Solution";
	$og_description = "Welcome to AUTOFIX, your one-stop solution for multi-brand automotive services. ";
	$og_url = "";
	$og_type = "article";
	$og_locale = "en_US";
}

echo "<title>{$metaTitle}</title>";
echo "<meta name='title' content='{$metaTitle}'>";
echo "<meta name='description' content='{$metaDescription}'>";
echo "<meta name='keywords' content='{$metaKeywords}'>";
echo "<link rel='canonical' href='{$canonical}'>";
echo "<meta name='robots' content='{$robots}'>";
echo "<meta property='og_title' content='{$og_title}'>";
echo "<meta property='og_description' content='{$og_description}'>";
echo "<meta property='og_url' content='{$og_url}'>";
echo "<meta property='og_type' content='{$og_type}'>";
echo "<meta property='og_locale' content='{$og_locale}'>";

?>

<base href="/">
	<!-- responsive meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- For IE -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

	<!-- master stylesheet -->



    <?php

    if($lang == 'ar')
    {
    ?>
        <link rel="stylesheet" href="css/imp_ar.css" async>
        <link rel="stylesheet" href="css/style_ar.css" async>
        <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">
        <link rel="stylesheet" href="css/custom_ar.css" async>
        <?php
    }
    else
    {
    ?>
        <link rel="stylesheet" href="css/imp.css" async>
	<link rel="stylesheet" href="css/style.css" async>
        <link rel="stylesheet" href="css/custom.css" async>
        <?php
    }
    ?>
	<!-- Responsive stylesheet -->
	<link rel="stylesheet" href="css/responsive.css" async>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="images/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="images/favicon/favicon-16x16.png" sizes="16x16">

    <!-- Fixing Internet Explorer-->
    <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js" defer></script>
        <script src="js/html5shiv.js" defer></script>
    <![endif]-->

	<!-- FLaticon stylesheet -->
	<link rel="stylesheet" type="text/css" href="flaticons/flaticon.css" async>

	<!-- Custom stylesheet -->


</head>
