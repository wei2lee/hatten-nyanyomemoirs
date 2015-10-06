
<?php
include_once "lib/class.phpmailer.php";
include_once "config.php";


function toJSON($error_exist, $error_no, $error_msg, $data) {
    $ret = array();
    $ret['status'] = $error_exist == 0 ? 1 : 0;
    $ret['error_exist'] = $error_exist;
    $ret['error_no'] = $error_no;
    $ret['error_msg'] = $error_msg;
    $ret['data'] = $data;
    return json_encode($ret);
}

class RegistrationEmailTemplate {
    public function render($data) {
        $body = "";
        
        foreach($data as $key => $value){
            $body .= "<b>" . ucfirst($key) . ":</b> $value<br/><br/>";
        }
        return $body;
    }
}

$addresses = array(
    array('nyonyamemoirs@hattengrp.com', '')
//    array('jacky@infradesign.com.my', '')
);

$addressesCC = array(
);

try {
    $templateData = $_POST;
    $template = new RegistrationEmailTemplate();
    $body = $template->render($templateData);
    $name = "no-reply@infradigital.com.my";
    $sender = "no-reply@infradigital.com.my";
    $subject = "InfraDigital Contact";

    $mailer = new PHPMailer(true);
    $mailer->IsSMTP();
    $mailer->SMTPDebug = false;
    $mailer->SMTPAuth = true;
    $mailer->Host = $config['smtp']['host'];
    $mailer->Port = $config['smtp']['port'];
    $mailer->Username = $config['smtp']['user'];
    $mailer->Password = $config['smtp']['pass'];
    $mailer->CharSet = "UTF-8";
    $mailer->SetFrom($sender, $name);
    foreach($addresses as $k => $address) {
        $mailer->AddAddress($address[0], $address[1]);
    }
    foreach($addressesCC as $k => $address) {
        $mailer->AddCC($address[0], $address[1]);
    }
    $mailer->Subject = $subject;
    $mailer->MsgHTML($body);
    $result1 = $mailer->send();
}catch(Exception $ex) {
    echo toJSON(1,0,'Fail to send email to admin : ' . $ex->getMessage(),'');
    return;
}

if(!$result1) {
    echo toJSON(1, 0, 'Fail to send email to admin', '');
}else{
    echo toJSON(0, 0, 'Success', '');
}

?>