<?php

$debug = false;
// $fromAddress="noreply@autorentsaudi.com";
// $toAddress="rajakumarpusthela@gmail.com";
// $toName="rajakumarpusthela";
// $subject="subject";
// $htmlBody="hi this is raja kumar";

// print_r($htmlBody);exit();

// sendEmail($fromAddress, $toAddress, $toName, $subject, $htmlBody);
function sendEmailToClient($fromAddress, $toAddress, $toName, $subject, $htmlBody) {
    $curl = curl_init();
    $postData = array(
        'from' => array('address' => $fromAddress),
        'to' => array(array(
            'email_address' => array(
                'address' => $toAddress,
                'name' => $toName
            )
        )),
        'subject' => $subject,
        'htmlbody' => $htmlBody
    );
 
    $jsonData = json_encode($postData); 
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.zeptomail.com/v1.1/email",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $jsonData,
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authorization: Zoho-enczapikey wSsVR61w/EKkDPosyjOoc70wmlwBAgunHE5/0FL17yeuTfzKosc7lRLPAQSvGvZKFWFtFGMWobp6mR8FgGUJhokszAxVXSiF9mqRe1U4J3x17qnvhDzNX29YmxaNJI4Lzw9jkmFgFsgi+g==",
            "cache-control: no-cache",
            "content-type: application/json",
        ),
    ));
 
    $response = curl_exec($curl);
    $err = curl_error($curl); 
    curl_close($curl); 
    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }
}

function sendEmailToInternalNotifications($fromAddress, $toAddress, $toName, $subject, $htmlBody) {
    $curl = curl_init();
    $postData = array(
        'from' => array('address' => $fromAddress),
        'to' => array(array(
            'email_address' => array(
                'address' => $toAddress,
                'name' => $toName
            )
        )),
        'subject' => $subject,
        'htmlbody' => $htmlBody
    );
 
    $jsonData = json_encode($postData); 
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.zeptomail.com/v1.1/email",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $jsonData,
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authorization: Zoho-enczapikey wSsVR61w/EKkDPosyjOoc70wmlwBAgunHE5/0FL17yeuTfzKosc7lRLPAQSvGvZKFWFtFGMWobp6mR8FgGUJhokszAxVXSiF9mqRe1U4J3x17qnvhDzNX29YmxaNJI4Lzw9jkmFgFsgi+g==",
            "cache-control: no-cache",
            "content-type: application/json",
        ),
    ));
 
    $response = curl_exec($curl);
    $err = curl_error($curl); 
    curl_close($curl); 
    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }
}
 



