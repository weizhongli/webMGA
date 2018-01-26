<?php
function isvalidemail( $email ) {
    if( preg_match( "/[a-zA-Z0-9-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $email ) > 0 ) //TODO recheck this pattern!
        return true;
    else
        return false;
}

//people receiving messages from the web form
//multiple addresses must be seperated by comma
$to='liwz@sdsc.edu, weizhongli1987@gmail.com';

if (isvalidemail($_POST["uemail"]) and $_POST["uemail"] == $_POST["uemail2"]) {
    // subject
    $subject = '[WebMGA Web Inquiry] ' . trim($_POST["subject"]);

    // message
    $message = '';
    $message .= "### This message was sent from the WebMGA web contact form ###\r\n\r\n";
    $message .= 'From: '.$_POST["uemail"] . "\r\n";
    $message .= 'Subject: '.trim($_POST["subject"]) . "\r\n";
    $message .= 'Date: ' . date("Y-m-d H:i") . "\r\n";
    $message .= "Message:\r\n\r\n";
    $mailbody = trim($_POST["mailbody"]);
    $message .=  $mailbody . "\r\n";

    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";

    // Additional headers
    $headers .= 'To: ' . $to . "\r\n";
    $headers .= "From: WebMGA Web Inquiry <WebMGA@weizhong-lab.ucsd.edu>\r\n";
    $headers .= 'Reply-To: ' . $_POST["uemail"] . ',' . $to . "\r\n";

    // Mail it
    if ($mailbody)
    {
        mail($to, $subject, $message, $headers);
        print("Your message has been received. We will get back to you soon.");
    }
    else
    {
        print("Attention: Please write something in the message.");
    }
}
else
    print("Attention: Please input a valid email address.");
?>
