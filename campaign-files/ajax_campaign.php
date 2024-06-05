<?php
include "../inc_opendb.php";
include_once "../libs/class.phpmailer.php";
$debug = false;

if (isset($_POST))
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $campaign_id             = filter_var($_POST['campaignid'],FILTER_SANITIZE_STRING);
        $campaign_lang           = filter_var($_POST['campaignlang'],FILTER_SANITIZE_STRING);
        $campaign_name           = filter_var($_POST['campaignname'],FILTER_SANITIZE_STRING);
        $campaign_email          = filter_var($_POST['campaignemail'],FILTER_SANITIZE_EMAIL);
        $campaign_phone          = filter_var($_POST['campaignphone'],FILTER_SANITIZE_EMAIL);
        $campaign_message        = filter_var($_POST['campaignmessage'],FILTER_SANITIZE_STRING);




        $result = $db->query("INSERT INTO campaign_report (campaignID,campaignLanguage,fullName, email, phone, message,status)
                                VALUES(?s,?s,?s,?s,?s,?s,?s)", $campaign_id, $campaign_lang, $campaign_name, $campaign_email, $campaign_phone, $campaign_message, 'NEW');


        $res = $db->query("SELECT * FROM smtp_details WHERE active  = 1");

        while($row=mysqli_fetch_assoc($res))
        {
            $SMTP_HOST = $row['host'];
            $SMTP_USERNAME = $row['username'];
            $SMTP_PASSWORD = $row['password'];
            $SMTP_PORT = $row['port'];
            $SMTP_SECURETYPE = $row['secured_type'];
        }




        $notificationType = 3; // this is for Contact Form
        //Retrieve the Notification options
        $sql = $db->query("SELECT * FROM notification_options WHERE id = ?i",$notificationType);
        $row = mysqli_fetch_assoc($sql);

        $emailOutbound = $row["emailOutbound"];
        $emailOutboundName = $row["emailOutboundName"];
        $client_subject = $row["autorespondSubject"];
        $client_message = $row["autorespondMessage"];
        $client_email = $campaign_email;
        $internal_subject = $row["int_notificationSubject"];
        $internal_message = $row["int_notificationMessage"];
        $resultPageMessage = $row["resultPageMessage"];

        // campaign Name in Email
        $sql2 = $db->query("SELECT * FROM campaign_master WHERE campaignID = ?i",$campaign_id); //
        $row2 = mysqli_fetch_assoc($sql2);
        $campaign = $row2["title"];


        if ($debug) echo "Client Sub: " . $sql;

        //$formData = "Name: " . $campaign_name . "<br/>" .
        //    "Email: " . $campaign_email . "<br/>" .
        //    "Phone: " . $campaign_phone . "<br/>" .
        //    "Car Model: " . $campaign_message . "<br/>" .
        //    "Lead Source: " . $campaign_id . " " . $campaign;


        date_default_timezone_set('Asia/Riyadh');
        $t = date('Y/m/d H:i:s');

        $formData = file_get_contents('camp_notif.html', true);
        $formData = str_replace("{DATE}", $t  , $formData);
        $formData = str_replace("{FULLNAME}", $campaign_name  , $formData);
        $formData = str_replace("{EMAIL}", $campaign_email  , $formData);
        $formData = str_replace("{PHONE}", $campaign_phone  , $formData);
        $formData = str_replace("{CAR_MODEL}", $campaign_message  , $formData);
        $formData = str_replace("{SOURCE}", $campaign_id." ".$campaign  , $formData);


        $message = file_get_contents('email_response.html', true);
        $message = str_replace("{FULLNAME}", $campaign_name  , $message);


//        $recipientFormData = "Name: " . $campaign_name . "<br/>" .
//            "Email: " . $campaign_email . "<br/>" .
//            "Phone: " . $campaign_phone . "<br/>" .
//            "Message: " . $campaign_message;

        $client_message = $client_message . "<br/> <br/>" . $message;
        $internal_message = $internal_message . "<br/> <br/>" . $formData;

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
        $mail->AddAddress($campaign_email);


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
            $mail->Username   = $SMTP_USERNAME;
            $mail->Password   = $SMTP_PASSWORD;
            $mail->SMTPSecure = $SMTP_SECURETYPE;
            $mail->Port       = $SMTP_PORT;



            $mail->From = $emailOutbound;
            $mail->FromName = $emailOutboundName;
            $mail->Subject = $internal_subject." from ".$campaign_name;
            $mail->WordWrap = 50; // some nice default value


            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->Body = $formData;
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
    $errors = $_POST();
//    echo "ERROR|" . "please fill the mandatory fields";
    echo "ERROR|" . getLangText( 'please fill the mandatory fields' );
    exit();
}

exit();
