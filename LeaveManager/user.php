<?php

require_once('connection.php');

include_once("functions.php");

if(isset($_POST['login'])){

    $errors = array();
    
    if(!isset($_POST['username']) || $_POST['username'] == ''){
        
        $errors[] = urlencode('Username is required');
        
    } else{
        
        $username = strip_tags(trim(htmlspecialchars($_POST['username'])));
    
    }
    
     if(isset($_POST['table']) || $_POST['table'] !== ''){
        
        $tbl = strip_tags(trim(htmlspecialchars($_POST['table'])));
    
    }
    
     if(isset($_POST['page']) || $_POST['page'] !== ''){
        
        $page = strip_tags(trim(htmlspecialchars($_POST['page'])));
    
    }
    
    if(isset($_POST['login-type']) || $_POST['login-type'] !== ''){
        
        $login_type = strip_tags(trim($_POST['login-type']));
    
    }
    if(!isset($_POST['password']) || $_POST['password'] == ''){
        
        $errors[] = urlencode('Password is required');
        
    }else{
        $password = $_POST['password'];
    }

    if(!$errors){
        
        $stmt = $db_con->prepare("SELECT * FROM $tbl WHERE username = ?");
        
        $stmt->bind_param('s', $username);
        
        $stmt->execute();
        
        $result = $stmt->get_result();
      
        $row = $result->num_rows;
        
        if($row == 1){
            
           
            $rows = $result->fetch_object();
            
            if(password_verify($password, $rows->password)){
               
               session_start();

                if($login_type == "admin"){

                    $_SESSION['admin-user'] = $rows->username;

                    $_SESSION['admin-id'] = $rows->admin_id;
                    
                    $_SESSION['admin-email'] = $rows->email;


                }elseif ($login_type == "staff") {

                    $_SESSION['staff-user'] = $rows->username;

                    $_SESSION['staff-email'] = $rows->email;

                    $_SESSION['staff-id'] = $rows->staff_id;

                }else{

                    $_SESSION['supervisor-user'] = $rows->username;

                    $_SESSION['supervisor-id'] = $rows->supervisor_id;

                    $_SESSION['supervisor-email'] = $rows->email;
                }
                
                header("Location:$page");
                
            }else{
            
                $error = urlencode("Invalid password");
                    
                header("Location:index.php?action=login&type=$login_type&error=$error");
                    
            }
                

        } else{
            
            $error = urlencode("Username provided is not registered");
            
            header("Location:index.php?error=$error");
            
        }
        
    } else{
        
        header("Location:index.php?error=".join($errors, "<br>"));
        
    }
    
}else{ 
    redirect_user("404.php");
}
