<?phpsession_start(); // store session datainclude_once "libs/safemysql-master/safemysql.class.php";include_once("masterconfig.php");$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbdatabase);if (mysqli_connect_errno()){    echo("Database Connection Error");    exit();}$dbInfo = array(    'host'      => $dbhost,    'user'      => $dbuser,    'pass'      => $dbpass,    'db'        => $dbdatabase,    'port'      => NULL,    'socket'    => NULL,    'pconnect'  => FALSE,    'charset'   => 'utf8',    'errmode'   => 'error', //or exception    'exception' => 'Exception', //Exception class name);$db = new SafeMySQL($dbInfo);$db->query( "SET collation_connection = 'utf8_general_ci'" );//Language Selector$langArray = array('en','ar');/* Url based language switcher */$servName = $_SERVER['SERVER_NAME'];if(strpos($servName, "ar.") !== false){	$_SESSION['lang'] = "ar";}else{	$_SESSION['lang'] = "en";}/* Url based language switcher -- ENDS*/if(!isset($_SESSION['lang'])){    $_SESSION['lang'] = "en";}if(isset($_GET['lang'])){    $lang = filter_var($_GET['lang'], FILTER_SANITIZE_STRING);    if(in_array($lang, $langArray))    {        $_SESSION['lang'] = $lang;    }}if(isset($_POST['lang'])){    $lang = filter_var($_POST['lang'], FILTER_SANITIZE_STRING);    if(in_array($lang, $langArray))    {        $_SESSION['lang'] = $lang;    }}// Test - Arabic Override//$_SESSION['lang'] = "ar";$lang = $_SESSION['lang'];$langid = "";if($lang == "ar") $langid = "_ar"; else $langid = "";include_once "inc_general_function.php";