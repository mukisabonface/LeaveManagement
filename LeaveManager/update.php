<?php
require_once('db.php');

require_once('functions.php');

if(isset($_POST['update'])){

    $err = array();
    
    if(var_set($_POST['password'])){

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
    }else{
        $err[] = urlencode("Provide a password");
    }
    
    if(var_set($_POST['confpassword'])){

        $confpass = password_hash($_POST['confpassword'], PASSWORD_DEFAULT);
    }else{
        $err[] = urlencode("Confirm password");
    }
    
    if(var_set($_POST['phone'])){

        $phone = strip_tags($_POST['phone']);
    }else{
        $err[] = urlencode("Provide a phone number");
    }
    
    $id = var_set($_POST['id']) ? intval($id) : "";
      
    if(var_set($_POST['email'])){
        
        $email = strip_tags($_POST['email']);
    }else{
        $err[] = urlencode("Enter your email");
    }
    
    if(!$err){
        if($confpass == $password){

            $query = $db_con->query("UPDATE employee SET email = '$email', phone = $phone, password = '$password' WHERE id = $id");

            $affected = $db_con->affected_rows;

            if($affected == 1){

                $msg = urlencode("Your information has been updated");

                header('Location:dashboard.php?tab=4&msg='.$msg);

            }else{

                $error = urlencode("Your request could not be processed. Try again".$db_con->error);

                header('Location:dashboard.php?tab=4&error='.$error);
            }

        } else{

            $error = urlencode("Passwords do not match");

            header('Location:dashboard.php?tab=4&error='.$error);
        }
        
    }else{
        header("Location:admin.php?tab=4&error=".join($err, urlencode("<br")));
    }
}else{
    header("Location:dashboard.php?tab=4");
}