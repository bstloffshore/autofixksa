<?php
include "inc_opendb.php";
include_once "libs/class.phpmailer.php";
$debug = false;

//echo print_r($_POST);
//exit();

$siteKey = '6Le9UroUAAAAAJnuTdtQralY49pH3OvsAT7H03CF';
$secret = '6Le9UroUAAAAAOlFGxIqRpf8yqwV5Lz5S6XqVtLP';


require('reCaptcha/autoload.php');
//$recaptcha = new \ReCaptcha\ReCaptcha($secret);

$recaptcha = new \ReCaptcha\ReCaptcha($secret, new \ReCaptcha\RequestMethod\CurlPost());

$gRecaptchaResponse = $_POST['g-recaptcha-response'];
$remoteIp = $_SERVER['REMOTE_ADDR'];

$resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp);

if ($resp->isSuccess())
{
//    echo "SUCCESS|" ."Verified";
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $name           = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
        $email          = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $phone          = filter_var($_POST['phone'],FILTER_SANITIZE_EMAIL);
        $subject        = filter_var($_POST['subject'],FILTER_SANITIZE_STRING);
        $services       = filter_var($_POST['services'],FILTER_SANITIZE_STRING);
        $message        = filter_var($_POST['message'],FILTER_SANITIZE_STRING);




        $result = $db->query("INSERT INTO inb_contactus (name, email, phone, subject, service, message)
                                VALUES(?s,?s,?s,?s,?s,?s)", $name, $email, $phone, $subject, $services, $message);


        $res = $db->query("SELECT * FROM smtp_details WHERE active  = 1");

        while($row=mysqli_fetch_assoc($res))
        {
            $SMTP_HOST = $row['host'];
            $SMTP_USERNAME = $row['username'];
            $SMTP_PASSWORD = $row['password'];
            $SMTP_PORT = $row['port'];
            $SMTP_SECURETYPE = $row['secured_type'];
        }




        $notificationType = 1; // this is for Contact Form

        $sql = $db->query("SELECT * FROM notification_options WHERE id = ?i",$notificationType);
        $row = mysqli_fetch_assoc($sql);

        $emailOutbound = $row["emailOutbound"];
        $emailOutboundName = $row["emailOutboundName"];
        $client_subject = $row["autorespondSubject"];
        $client_message = $row["autorespondMessage"];
        $client_email = $email;
        $internal_subject = $row["int_notificationSubject"];
        $internal_message = $row["int_notificationMessage"];
        $resultPageMessage = $row["resultPageMessage"];


        if ($debug) echo "Client Sub: " . $sql;

        $formData = "Name: " . $name . "<br/>" .
            "Email: " . $email . "<br/>" .
            "Phone: " . $phone . "<br/>" .
            "Subject: " . $subject . "<br/>" .
            "Service: " . $services . "<br/>" .
            "Message: " . $message  ;


        $recipientFormData = "Name: " . $name . "<br/>" .
            "Email: " . $email . "<br/>" .
            "Phone: " . $phone . "<br/>" .
            "Subject: " . $subject . "<br/>" .
            "Service: " . $services . "<br/>" .
            "Message: " . $message  ;

        $client_message = $client_message . "<br/> <br/>" . $recipientFormData;
        $internal_message = $internal_message . "<br/> <br/>" . $recipientFormData;

        //Send Emails

        //Send Client Auto Response
        $mail = new PHPMailer();
        $mail->Host = $SMTP_HOST;
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->isHTML( true );
        $mail->Username   = $SMTP_USERNAME;
        $mail->Password   = $SMTP_PASSWORD;
        $mail->SMTPSecure = $SMTP_SECURETYPE;
        $mail->Port       = $SMTP_PORT;



        $mail->From = $emailOutbound;
        $mail->FromName = $emailOutboundName;
        $mail->Subject = $client_subject;
        $mail->WordWrap = 50; // some nice default value


        $mail->IsHTML(true);
        $mail->Body = $client_message;
        $mail->AddReplyTo($emailOutbound);
        $mail->AddAddress($client_email);


        if (!$mail->Send())
        {
            if ($debug) echo $mail->ErrorInfo;
            if ($debug) echo "EMAIL ERROR (email to Client)";
        }
        else
        {
            if ($debug) echo "EMAIL SENT SUCCESSFULLY (email to client)";
        }

        //Send Internal Notifications
        $result = $db->query("SELECT * FROM notification_recipients WHERE idNotificationType = ?i AND active = 1 AND sendEmail = 1",$notificationType);
        while ($row = mysqli_fetch_assoc($result))
        {
            $mail = new PHPMailer();
            $mail->Host = $SMTP_HOST;
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->isHTML( true );
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->Username   = $SMTP_USERNAME;
            $mail->Password   = $SMTP_PASSWORD;
            $mail->SMTPSecure = $SMTP_SECURETYPE;
            $mail->Port       = $SMTP_PORT;



            $mail->From = $emailOutbound;
            $mail->FromName = $emailOutboundName;
            $mail->Subject = $internal_subject;
            $mail->WordWrap = 50; // some nice default value


            $mail->IsHTML(true);
            $mail->Body = $internal_message;
            $mail->AddReplyTo($emailOutbound);
            $mail->AddAddress($row["recipientEmail"]);


            if (!$mail->Send())
            {
                if ($debug) echo $mail->ErrorInfo;
                if ($debug) echo "EMAIL ERROR (email to internal)";

            }
            else
            {
                if ($debug) echo "EMAIL SENT SUCCESSFULLY (email to internal)";

            }
        }
//        echo "SUCCESS|" ."$resultPageMessage";
        echo "SUCCESS|" . getLangText( 'result page message' );
    }
}
else
{
    $errors = $resp->getErrorCodes();
//    echo "ERROR|" ."Captcha Error";
    echo "ERROR|" . getLangText( 'captcha error' );
    exit();
}

exit();
