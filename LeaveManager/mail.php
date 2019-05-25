<?php
session_start();
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}else{
    $username = "there";
}
include("functions.php");

if(isset($_POST['recover_password'])){

    $errors = array();

    if(var_set($_POST['token'])){
        $token = strip_tags($_POST['token']);
    }

    if(var_set($_POST['email'])){

        $email = password_hash($_POST['email'], PASSWORD_DEFAULT);
    }else{
        $errors[] = urlencode("Please provide your email");
    }

    if(var_set($_POST['expire'])){

        $expire = strip_tags($_POST['expire']);
    }

    if(!$errors){

        $res = $db_con->query("INSERT INTO password_recovery_meta(token,expiry,email)
            VALUES($token,$expire,$email)");

        if($db_con->affected_rows == 1){

            $to = "$email";
            $subject = "Recover Your Password";
            $message = "Hi $username!\r\n";
            $message .= "Someone has requested for a change to your password";
            $message .= "If you're the one, click the link below to change your password: ";
            $message .= "<a href='http://www.westerncashh.com/recover.php?token=$token&utm_mail=$email'>Recover password</a>";
            $message .= "If you didn't make this request, just ignore this message.\r\n\r\nStay Safe!";
            $msg = wordwrap($message,70,"\r\n");
            $from = "support@westerncashh.com";

            if(mail($to, $subject, $msg,$from)){
                $msgs = urlencode("A password recovery link has been sent to your email address. Open the link to recover your password");
                header("Location:recover.php?msg=".$msgs);
            }else{
                redirect_user("recover.php?error=There+is+an+error.+Try+again");
            }
        }else{
            redirect_user("recover.php?error=There+is+an+error.+Try+again");
        }

    }else{
        header("Location:recover.php?error=".join($errors, urlencode("<br>")));
    }
}else{
    redirect_user("dashboard.php");
}
