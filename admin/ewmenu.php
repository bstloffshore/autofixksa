<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(54, "mci_Campaign", $Language->MenuPhrase("54", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(31, "mi_campaign_master", $Language->MenuPhrase("31", "MenuText"), "campaign_masterlist.php", 54, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}campaign_master'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(32, "mi_campaign_report", $Language->MenuPhrase("32", "MenuText"), "campaign_reportlist.php", 54, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}campaign_report'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(30, "mi_campaign_aboutus", $Language->MenuPhrase("30", "MenuText"), "campaign_aboutuslist.php", 54, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}campaign_aboutus'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(29, "mi_translations", $Language->MenuPhrase("29", "MenuText"), "translationslist.php", -1, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}translations'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(26, "mci_Home", $Language->MenuPhrase("26", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(27, "mi_sliders", $Language->MenuPhrase("27", "MenuText"), "sliderslist.php", 26, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}sliders'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(15, "mi_home_about_us", $Language->MenuPhrase("15", "MenuText"), "home_about_uslist.php", 26, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}home_about_us'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(17, "mi_our_process", $Language->MenuPhrase("17", "MenuText"), "our_processlist.php", 26, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}our_process'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(18, "mi_our_values", $Language->MenuPhrase("18", "MenuText"), "our_valueslist.php", 26, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}our_values'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(14, "mi_clients", $Language->MenuPhrase("14", "MenuText"), "clientslist.php", 26, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}clients'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(1, "mi_about_us", $Language->MenuPhrase("1", "MenuText"), "about_uslist.php", -1, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}about_us'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(8, "mi_services", $Language->MenuPhrase("8", "MenuText"), "serviceslist.php", -1, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}services'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10, "mci_Notifications", $Language->MenuPhrase("10", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(4, "mi_notification_options", $Language->MenuPhrase("4", "MenuText"), "notification_optionslist.php", 10, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}notification_options'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(5, "mi_notification_recipients", $Language->MenuPhrase("5", "MenuText"), "notification_recipientslist.php", 10, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}notification_recipients'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(9, "mi_smtp_details", $Language->MenuPhrase("9", "MenuText"), "smtp_detailslist.php", 10, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}smtp_details'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(11, "mci_Inbox", $Language->MenuPhrase("11", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(16, "mi_inb_estimate", $Language->MenuPhrase("16", "MenuText"), "inb_estimatelist.php", 11, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}inb_estimate'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(3, "mi_inb_contactus", $Language->MenuPhrase("3", "MenuText"), "inb_contactuslist.php", 11, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}inb_contactus'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(12, "mci_Others", $Language->MenuPhrase("12", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(7, "mi_pages_static", $Language->MenuPhrase("7", "MenuText"), "pages_staticlist.php", 12, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}pages_static'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(28, "mi_socials", $Language->MenuPhrase("28", "MenuText"), "socialslist.php", 12, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}socials'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(6, "mi_others", $Language->MenuPhrase("6", "MenuText"), "otherslist.php", 12, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}others'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(13, "mi_web_branches", $Language->MenuPhrase("13", "MenuText"), "web_brancheslist.php", 12, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}web_branches'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(2, "mi_cms_users", $Language->MenuPhrase("2", "MenuText"), "cms_userslist.php", 12, "", IsLoggedIn() || AllowListMenu('{8281128E-C7BB-40DA-A1AE-8695DB7283AC}cms_users'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
