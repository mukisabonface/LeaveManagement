<?php
require_once('db.php');

require_once('functions.php');

if(isset($_POST['register'])){
    
    $errors = array();
    
    if(!isset($_POST['email']) || $_POST['email'] == ''){

            $errors[] = urlencode('Email address is required');

        } else if(!((strpos($_POST['email'], ".") > 0) && (strpos($_POST['email'], "@") > 0)) || 
                preg_match("/[^a-zA-Z0-9.@_-]/", $_POST['email'])){

            $errors[] = urlencode('Email is invalid');

    } else{
        
        $email = strip_tags(trim(htmlspecialchars($_POST['email'])));
        
    }
    
    
    if(!isset($_POST['username']) || $_POST['username'] == ''){
        
        $errors[] = urlencode('Username is required');
        
    } elseif(strlen($_POST['username']) < 5){
        
        $errors[] = urlencode('Username must be 5 or more characters');
        
    } else{
        
        $username = strip_tags(trim(htmlspecialchars($_POST['username'])));
    
    }
    
    if(!isset($_POST['firstname']) || $_POST['firstname'] == ''){
        
        $errors[] = urlencode('Firstname cannot be blank');
        
    } elseif(!preg_match("/[a-zA-Z]/", $_POST['firstname'])){
        
        $errors[] = urlencode('Firstname must contain only alphabets');
        
    } else{
        
        $firstname = strip_tags(trim(htmlspecialchars($_POST['firstname'])));
    }
    
    if(!isset($_POST['lastname']) || $_POST['lastname'] == ''){
        
        $errors[] = urlencode('Lastname must not be blank');
        
    } elseif(!preg_match("/[a-zA-Z]/", $_POST['lastname'])){
        
        $errors[] = urlencode('Lastname must contain only alphabets');
        
    } else{
        
        $lastname = strip_tags(trim(htmlspecialchars($_POST['lastname'])));
        
    }
    
    if(!isset($_POST['password']) || $_POST['password'] == ''){
        
        $errors[] = urlencode('Password is required');
        
    } elseif(strlen($_POST['password']) < 8){
        
        $errors[] = urlencode('Password must be 8 or more characters');
        
    }else{
        $password = password_hash(strip_tags(trim($_POST['password'])), PASSWORD_DEFAULT);
    }
    
    if(!isset($_POST['phone']) || $_POST['phone'] == ''){
        
        $errors[] = urlencode('Please provide a phone number');
        
    } elseif(!is_numeric($_POST['phone'])){
            
            $errors[] = urlencode('Invalid phone number');
            
    } else{
        
        $phone = strip_tags(trim(htmlspecialchars($_POST['phone'])));
    }
    
    if(!isset($_POST['country-code']) || $_POST['country-code'] == ''){
        
        $errors[] = urlencode('Please specify country code');
        
    } elseif(!preg_match("/[+.0-9]/", $_POST['country-code'])){
            
            $errors[] = urlencode('Invalid country code');
            
    } else{
        
        $code = strip_tags(trim(htmlspecialchars($_POST['country-code'])));
    }
    
    if(!isset($_POST['title']) || $_POST['title'] == ''){
        
        $errors[] = urlencode('Title must be specified');
        
    } elseif(!preg_match("/[a-zA-Z]/",$_POST['title'])){
            
            $errors[] = urlencode('Invalid title');
            
    } else{
        
        $title = strip_tags(trim(htmlspecialchars($_POST['title'])));
    }
    
    
    $query = $db_con->query("SELECT id FROM employee WHERE username = $username OR 
        email = $email Or phone = $phone");
    
    if($query->num_rows > 0){
        $errors[] = urlencode("There is already a user with those details");
    }
    
    
    $user_registered = date('Y-m-d');
    
    $staff_id = date('mYdHis');
    
    if(!$errors){
        
        $stmt = $db_con->prepare("INSERT INTO employee(staff_id,title,fname,
            lname,username,password,email,country_code,phone,date_registered) 
            VALUES(?,?,?,?,?,?,?,?,?,?)");
        
        $stmt->bind_param('ssssssssis',$staff_id,$title,$firstname,$lastname,
                $username,$password,$email,$code,$phone,$user_registered);
        
        $stmt->execute();
            
        $result = $stmt->get_result();
            
        $row = $db_con->affected_rows;
        
        
        if($row == 1){
            
            //Sessions
            if(!session_id()){
            
            session_start();
            
            }
            
            $_SESSION['staff-user'] = $username;
            
            $_SESSION['staff-email'] = $email;
            
            $_SESSION['staff-id'] = $row->staff_id;
            
            $msg = urlencode("Congratulations $lastname! You're successfully "
                    . "registered");
                
            header('Location:thankyou.php?msg='.$msg);
            
            $subject = "Registration Successful";
            $raw_message = "Hi $username!
                \t\tThis is to inform you that your account has been created successfully and is waiting for admin approval.Once you have been approved, you can request for leave and be able to manage your leave/leave information.\n\t\t\tYour Friend\n\t\t\thr@leavemanager";
            
            $message = wordwrap($raw_message, 70, "\n");
            
            $from = "HR:<hr@leavemanager.com";
            
            mail($email, $subject, $message);
                
        }else{
            
            header('Location:register.php?error=Registration+unsuccessful+.+'
                    . 'Try+again+later'.$db_con->error);

            }
        
    } else{
            
            header('Location:register.php?error='.join($errors, "<br>"));
            
    }
    
    
}elseif(isset($_POST['make-super'])){
    
    if(var_set($_POST['make-supervisor'])){
        
        if(is_string($_POST['make-supervisor'])){

            $make_super = $_POST['make-supervisor'];
            
            $tab = $_POST['tab'];

            $result = $db_con->query("UPDATE employee SET supervisor = 'N/A', staff_level = 'supervisor' "
                    . "WHERE username = '$make_super'");

            if($db_con->affected_rows == 1){

                $name = ucfirst($make_super);

                $msg= urlencode("$name has been made a supervisor");

                redirect_user("admin.php?tab=$tab&msg=$msg");
            }else{

                $msg = urlencode("An error occurred. Try again ".$db_con->error);

                redirect_user("admin.php?tab=5&error=$msg");
            }

        }else{
            redirect_user("admin.php?tab=5&error=Invalid+value+selected");
        }
    }
}elseif(isset($_POST['assign-super'])){
    
    if(var_set($_POST['assign-to'])){
        
        $error = array();

        if(is_string($_POST['supervisor'])){

            $super = $_POST['supervisor'];
        }else{
            $error[] = urlencode("Invalid supervisor");
        }

        if(is_string($_POST['assign-to'])){

            $username = $_POST['assign-to'];

        }else{
            $error[] = urlencode("Invalid user chosen");
        }
    }
    
    if(!$error){
        
        $result = $db_con->query("UPDATE employee SET supervisor = '$super', staff_level = 'non-supervisor' "
                . "WHERE username = '$username'");

        if($db_con->affected_rows == 1){

            $name = ucfirst($username);

            $sup = ucfirst($super);
            
            $msg= urlencode("$name has been assigned to $sup");

            redirect_user("admin.php?tab=5&msg=$msg");
            
        }else{
            
            $msg = urlencode("An error occurred. Try again ".$db_con->error);
            
            redirect_user("admin.php?tab=5&error=$msg");
        }
        
    }else{
        redirect_user("admin.php?tab=5&error=".join($error, urlencode("<br>")));
    }
    
}elseif(isset($_POST['accept'])){
        
    $error = array();
    
    if(var_set($_POST['staff_id']) && is_numeric($_POST['staff_id'])){

        $staff_id = $_POST['staff_id'];
    }
    
    if(var_set($_POST['leave_id']) && is_numeric($_POST['leave_id'])){

        $leave_id = $_POST['leave_id'];
        
    }
    
    if(var_set($_POST['email'])){

        $email = $_POST['email'];
    }
    
    if(var_set($_POST['firstname'])){

        $firstname = $_POST['firstname'];
        
    }
    
    if(var_set($_POST['leave_type'])){

        $leave_type = $_POST['leave_type'];
        
    }else{
        
        $error[] = urlencode("An error occurred. Try again");
    }
    
    if(var_set($_POST['num_days']) && is_numeric($_POST['num_days'])){

        $num_days = $_POST['num_days'];
        
    }else{
        
        $error[] = urlencode("An error occurred. Try again");
    }
    
    $date_accepted = date("d-m-Y");
    
    if(!$error){
        
        $result = $db_con->query("UPDATE recommended_leaves SET status = 'accepted' 
            WHERE leave_id = $leave_id AND staff_id = $staff_id");

        if($db_con->affected_rows == 1){

           $stmt = $db_con->prepare("INSERT INTO accepted_leaves(leave_id,staff_id,
            leave_type,num_days,date_accepted) VALUES(?,?,?,?,?)");
           
           $stmt->bind_param("iisis",$leave_id,$staff_id,$leave_type,$num_days,$date_accepted);
           
           $stmt->execute();
           
           if($db_con->affected_rows == 1){
            
               $firstname = ucfirst($firstname);
               
               $to = "$email";
               
               $subject = "LEAVE HAS BEEN ACCEPTED";
               
               $raw_message = "Congratulations $firstname!\n\\tYour leave application with Leave ID 
                      $leave_id has been accepted. This means you can now proceed on enjoying your 
                      leave days.n\t\t\tBest Wishes!";
               
               $message = wordwrap($raw_message, 70, "\n\t");
                      
               $from = "admin@leavemanager.com";
               
               if(mail($to, $subject, $message, $from)){
                   
                    $msg= urlencode("Leave has been accepted");

                    redirect_user("dashboard.php?tab=7&msg=$msg");
               }
               
           }else{
               
               $msg= urlencode("Leave request could not be accepted");

               redirect_user("admin.php?tab=3&error=$msg");
           }
           
        }else{
            
            $msg = urlencode("There were errors. Try again ".$db_con->error);
            
            redirect_user("admin.php?tab=3&error=$msg");
        }
        
    }else{
        redirect_user("admin.php?tab=5&error=".join($error, urlencode("<br>")));
    }
    
}elseif(isset($_POST['approve'])){
   
    $err = array();
    
    if(var_set($_POST['staff_id'])){
        
        $staff_id = intval(strip_tags($_POST['staff_id']));
       
    }else{
        $err[] = urlencode("Couldn't approve staff. Try again");
    }
    
     if(var_set($_POST['id'])){
        
         $id = intval(strip_tags($_POST['id'])); 
     }else{
        $err[] = urlencode("Could not approve staff. Please try again");
    }
    
    if(!$err){
        
        $res = $db_con->query("UPDATE employee set staff_level = 'non-supervisor' 
             WHERE id = $id AND staff_id = $staff_id");
        
        if($db_con->affected_rows == 1){
            
            $msg = urlencode("Staff has been approved");
            redirect_user("admin.php?tab=2&msg=$msg");
        }else{
            $error = urlencode("Could not approve staff ".$db_con->error);
            redirect_user("admin.php?tab=2&error=$error");
        }
        
    }else{
        redirect_user("admin.php?error=".join($err, urlencode("<br>")));
    } 
    
    
}elseif(isset($_POST['publish'])){
    
    $errors = array();
    
    if(var_set($_POST['date_joined'])){
        $date_joined = strip_tags($_POST['date_joined']);
    }else{
        $errors[] = urlencode("Date joined must not be blank");
    }
    
    if(var_set($_POST['salary_level'])){
        $salary_level = strip_tags($_POST['salary_level']);
    }else{
        $errors[] = urlencode("Salary level must be provided");
    }
    
    if(var_set($_POST['staff_id'])){
        $staff_id = strip_tags($_POST['staff_id']);
        
    }else{
        $errors[] = urlencode("Please choose staff");
    }    
    
    if(!$errors){
                      
        $res = $db_con->query("SELECT * FROM job_description WHERE staff_id = $staff_id");
   
        if($res->num_rows > 0){
            
            redirect_user("admin.php?tab=6&error=Job+description+already+exists+for+staff");
            
        }else{
            
            $rows = query_db("SELECT staff_level FROM employee WHERE staff_id = $staff_id");

            $stmt = $db_con->prepare("INSERT INTO job_description(staff_id, 
            staff_level,salary_level,date_joined) VALUES(?,?,?,?)");
            echo "<h1>Errors: $db_con->error</h1>";
            $stmt->bind_param("isis",$staff_id,$rows->staff_level,$salary_level,
                 $date_joined);
           
            $stmt->execute();

            if($db_con->affected_rows == 1){
                $msg = urlencode("Job description added successfully");
                redirect_user("admin.php?tab=6&msg=$msg");
            }
        }
         
        
    }else{
        redirect_user("admin.php?tab=6&error=".join($errors, urlencode("<br>")));
    }
    
}elseif(isset($_POST['staff_meta'])){
 
    $errors = array();
    
    if(var_set($_POST['annual_leave_days_allowed'])){
        
        $allowed_days = strip_tags($_POST['annual_leave_days_allowed']);
        
    }else{
        $errors[] = urlencode("Please enter max annual days allowed");
    }
    
     if(var_set($_POST['annual_leave_days_allowed'])){
        
        $allowed_monthly_days = strip_tags($_POST['monthly_leave_days_allowed']);
        
    }else{
        $errors[] = urlencode("Please enter max annual days allowed");
    }
    
    if(var_set($_POST['staff_level'])){
        $staff_level = strip_tags($_POST['staff_level']);
        
    }else{
        $errors[] = urlencode("Please choose staff level");
    }
   
    
    if(!$errors){
                      
        $res = $db_con->query("SELECT * FROM user_leave_metadata WHERE staff_level = '$staff_level'");
   
        if($res->num_rows > 0){
            
            redirect_user("admin.php?tab=8&error=Data+already+exists+for+$staff_level");
            
        }else{
        
        $stmt = $db_con->prepare("INSERT INTO user_leave_metadata(staff_level,
            total_yr_leave_count,total_month_leave_count) VALUES(?,?,?)");
        $stmt->bind_param("sii",$staff_level,$allowed_days,$allowed_monthly_days);

        $stmt->execute();

            if($db_con->affected_rows == 1){
                $msg = urlencode("Staff leave metadata has been added");
                redirect_user("admin.php?tab=8&msg=$msg");
                
            }else{
                redirect_user("admin.php?tab=8&error=Could+not+create+leave+metadata+".$db_con->error);
            }
        }
    }else{
        redirect_user("admin.php?tab=8&error=".join($errors, urlencode("<br>")));        
    }
}elseif(isset($_POST['reject'])){
    
    $error = array();
    if(var_set($_POST['leave_type'])){
        
        $leave_type = strval($_POST['leave_type']);
        
    }else{
        $error[] = urlencode("Sorry, an error occurred.");
    }
    
    if(var_set($_POST['email'])){

        $email = $_POST['email'];
    }
    
    if(var_set($_POST['firstname'])){

        $firstname = $_POST['firstname'];
        
    }
    
    if(var_set($_POST['leave_id'])){
        
        $leave_id = intval($_POST['leave_id']);
        
    }else{
        $error[] = urlencode("Sorry, an error occurred.");
    }
    
    if(var_set($_POST['staff_id'])){
        
        $staff_id = intval($_POST['staff_id']);
        
    }else{
        $error[] = urlencode("Sorry, an error occurred.");
    }
   
    
    if(!$error){
        
        $result = $db_con->query("UPDATE recommended_leaves SET status = 'rejected' 
            WHERE leave_id = $leave_id AND staff_id = $staff_id");

        if($db_con->affected_rows == 1){

            $date_rejected = date("d-m-Y");

            $stmt = $db_con->prepare("INSERT INTO rejected_leaves(leave_id,staff_id,
                leave_type,date_rejected) VALUES(?,?,?,?)");

            $stmt->bind_param("iiss",$leave_id,$staff_id,$leave_type,$date_rejected);

            $stmt->execute();

            if($db_con->affected_rows == 1){
                 
                $firstname = ucfirst($firstname);

                $to = $email;

                $subject = "LEAVE HAS BEEN REJECTED";

                $raw_message = "Hi $firstname!\r\n\tYour leave application with Leave ID 
                            $leave_id has been rejected. You can read more about reasons for rejection of leaves or 
                            contact your Supervisor for advice on applying for a leave.\r\n\r\n\t\t\t
                            Sorry for the inconvenience!";
                
                $message = wordwrap($raw_message, 70, "\n\t");

                $from = "admin@leavemanager.com";

                if(mail($to, $subject, $message, $from)){
            
                     $msg = urlencode("Leave has been rejected");

                     redirect_user("dashboard.php?tab=7&msg=$msg");
                }
                
            }else{
                redirect_user("admin.php?tab=3&error=Leave+could+not+be+rejected+".$db_con->error);
            }
        }else{
            redirect_user("admin.php?tab=3&error=Leave+could+not+be+rejected+".$db_con->error);
        }

    }else{
        redirect_user("admin.php?tab=3&error=".join($error,  urlencode("<br>")));
        
    }
    
}else{ 
    redirect_user("404.php");
}

