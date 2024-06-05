<?php
include "inc_opendb.php";
include_once "libs/class.phpmailer.php";
$debug = false;


//echo print_r($_POST);
//exit();

if (isset($_POST))
{
//    echo "SUCCESS|" ."Verified";
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $estimate_name           = filter_var($_POST['estimate_name'],FILTER_SANITIZE_STRING);
        $estimate_email          = filter_var($_POST['estimate_email'],FILTER_SANITIZE_EMAIL);
        $estimate_phone          = filter_var($_POST['estimate_phone'],FILTER_SANITIZE_EMAIL);
        $value                   = filter_var($_POST['totalCount'],FILTER_SANITIZE_STRING);




        $result = $db->query("INSERT INTO inb_estimate (fullname, email, phone, totalValue)
                                VALUES(?s,?s,?s,?s)", $estimate_name, $estimate_email, $estimate_phone, $value);


//        $res = $db->query("SELECT * FROM smtp_details WHERE active  = 1");
//
//        while($row=mysqli_fetch_assoc($res))
//        {
//            $SMTP_HOST = $row['host'];
//            $SMTP_USERNAME = $row['username'];
//            $SMTP_PASSWORD = $row['password'];
//            $SMTP_PORT = $row['port'];
//            $SMTP_SECURETYPE = $row['secured_type'];
//        }




//        $notificationType = 2; // this is for Contact Form
//        //Retrieve the Notification options
//        $sql = $db->query("SELECT * FROM notification_options WHERE id = ?i",$notificationType);
//        $row = mysqli_fetch_assoc($sql);
//
//        $emailOutbound = $row["emailOutbound"];
//        $emailOutboundName = $row["emailOutboundName"];
//        $client_subject = $row["autorespondSubject"];
//        $client_message = $row["autorespondMessage"];
//        $client_email = $estimate_email;
//        $internal_subject = $row["int_notificationSubject"];
//        $internal_message = $row["int_notificationMessage"];
//        $resultPageMessage = $row["resultPageMessage"];
//
//
//        if ($debug) echo "Client Sub: " . $sql;
//
//        $formData = "Name: " . $estimate_name . "<br/>" .
//            "Email: " . $estimate_email . "<br/>" .
//            "Phone: " . $estimate_phone . "<br/>" .
//            "Service: " . $value;
//
//
//
//        $recipientFormData = "Name: " . $estimate_name . "<br/>" .
//            "Email: " . $estimate_email . "<br/>" .
//            "Phone: " . $estimate_phone . "<br/>" .
//            "Service: " . $services;
//
//        $client_message = $client_message . "<br/> <br/>" . $recipientFormData;
//        $internal_message = $internal_message . "<br/> <br/>" . $recipientFormData;
//
//        //Send Emails
//
//        //Send Client Auto Response
//        $mail = new PHPMailer();
//        $mail->Host = $SMTP_HOST;
//        $mail->isSMTP();
//        $mail->SMTPAuth = true;
//        $mail->isHTML( true );
//        $mail->Username   = $SMTP_USERNAME;
//        $mail->Password   = $SMTP_PASSWORD;
//        $mail->SMTPSecure = $SMTP_SECURETYPE;
//        $mail->Port       = $SMTP_PORT;
//
//
//
//        $mail->From = $emailOutbound;
//        $mail->FromName = $emailOutboundName;
//        $mail->Subject = $client_subject;
//        $mail->WordWrap = 50; // some nice default value
//
//
//        $mail->IsHTML(true);
//        $mail->Body = $client_message;
//        $mail->AddReplyTo($emailOutbound);
//        $mail->AddAddress($client_email);
//
//
//        if (!$mail->Send())
//        {
//            if ($debug) echo $mail->ErrorInfo;
//            if ($debug) echo "EMAIL ERROR (email to Client)";
//        }
//        else
//        {
//            if ($debug) echo "EMAIL SENT SUCCESSFULLY (email to client)";
//        }
//
//        //Send Internal Notifications
//        $result = $db->query("SELECT * FROM notification_recipients WHERE idNotificationType = ?i AND active = 1 AND sendEmail = 1",$notificationType);
//        while ($row = mysqli_fetch_assoc($result))
//        {
//            $mail = new PHPMailer();
//            $mail->Host = $SMTP_HOST;
//            $mail->isSMTP();
//            $mail->SMTPAuth = true;
//            $mail->isHTML( true );
//            $mail->Username   = $SMTP_USERNAME;
//            $mail->Password   = $SMTP_PASSWORD;
//            $mail->SMTPSecure = $SMTP_SECURETYPE;
//            $mail->Port       = $SMTP_PORT;
//
//
//
//            $mail->From = $emailOutbound;
//            $mail->FromName = $emailOutboundName;
//            $mail->Subject = $internal_subject;
//            $mail->WordWrap = 50; // some nice default value
//
//
//            $mail->IsHTML(true);
//            $mail->CharSet = 'UTF-8';
//            $mail->Encoding = 'base64';
//            $mail->Body = $internal_message;
//            $mail->AddReplyTo($emailOutbound);
//            $mail->AddAddress($row["recipientEmail"]);
//
//
//            if (!$mail->Send())
//            {
//                if ($debug) echo $mail->ErrorInfo;
//                if ($debug) echo "EMAIL ERROR (email to internal)";
//
//            }
//            else
//            {
//                if ($debug) echo "EMAIL SENT SUCCESSFULLY (email to internal)";
//
//            }
//        }
//        echo "SUCCESS|" ."$resultPageMessage";
        echo "SUCCESS|" . getLangText( 'estimate successfully submitted' );
    }
}
else
{
    $errors = $_POST();
    echo "ERROR|" . getLangText( 'please fill the mandatory fields' );
    exit();
}

exit();
