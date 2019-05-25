<?php
include_once("functions.php");

if(isset($_POST['accept'])){
        
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
    
    if(var_set($_POST['leave_type']) && is_string($_POST['leave_type'])){

        $leave_type = $_POST['leave_type'];
        
    }
    
    if(var_set($_POST['num_days']) && is_numeric($_POST['num_days'])){

        $num_days = $_POST['num_days'];
        
    }
    
     if(var_set($_POST['recommended_by']) && is_string($_POST['recommended_by'])){

        $recommended_by = $_POST['recommended_by'];
        
    }else{
        
        $error[] = urlencode("An error occurred. By");
    }
    
     if(var_set($_POST['why_recommend']) && is_string($_POST['why_recommend'])){

        $why_recommend = $_POST['why_recommend'];
        
    }else{
        
        $why_recommend = '';
    }
    
    $date_accepted = date("d-m-Y");
    
    if(!$error){
        
        $result = $db_con->query("UPDATE leave_applications SET action = 'accept' 
            WHERE leave_id = $leave_id AND staff_id = $staff_id");

        if($db_con->affected_rows == 1){

           $stmt = $db_con->prepare("INSERT INTO recommended_leaves(leave_id,staff_id,
            leave_type,recommended_by,num_days,why_recommend,date_recommended) VALUES(?,?,?,?,?,?,?)");
           
           $stmt->bind_param("iississ",$leave_id,$staff_id,$leave_type,$recommended_by,
                   $num_days,$why_recommend,$date_accepted);
           
           $stmt->execute();
           
           if($db_con->affected_rows == 1){
               
               $firstname = ucfirst($firstname);
               
               $to = "$email";
               
               $subject = "Leave Has Been Recommended";
               
               $message = "Hello $firstname!\r\n\tYour leave application with Leave ID 
                      $leave_id has been recommended by your Supervisor. This means it's now left with your overall boss to accept or reject the leave."
                       . "\r\n\r\n\t\t\tBest Wishes!";
               
               $msg = wordwrap($message,70,"\r\n");
                      
               $from = "HR: <hr@leavemanager.com>";
               
               if(mail($to, $subject, $msg, $from)){
                    
                    $msg= urlencode("Leave recommendation successful");

                    redirect_user("dashboard.php?tab=7&msg=$msg");
               }
               
                
           } else {
               
               $msg= urlencode("Leave could not be recommended");

               redirect_user("dashboard.php?tab=7&error=$msg");
           }
           
        }else{
            
            $msg = urlencode("An error occurred. Try again ".$db_con->error);
            
            redirect_user("dashboard.php?tab=7&error=$msg");
        }
        
    }else{
        redirect_user("dashboard.php?tab=7&error=".join($error, urlencode("<br>")));
    }
    
}elseif(isset($_POST['reject'])){
    
    $error = array();
    if(var_set($_POST['leave_type'])){
        
        $leave_type =  strval($_POST['leave_type']);
        
    }else{
        $error[] = urlencode("Sorry, an error occurred.");
    }
    
    if(var_set($_POST['leave_id'])){
        
        $leave_id = intval($_POST['leave_id']);
        
    }
    
    if(var_set($_POST['email']) && is_numeric($_POST['email'])){

        $email = $_POST['email'];
    }
    
    if(var_set($_POST['firstname']) && is_numeric($_POST['firstname'])){

        $firstname = $_POST['firstname'];
        
    }
    
    if(var_set($_POST['staff_id'])){
        
        $staff_id = intval($_POST['staff_id']);
        
    }else{
        $error[] = urlencode("Sorry, an error occurred.");
    }
    
    if(var_set($_POST['reason'])){
        
        $reason = strval($_POST['reason']);
        
    }else{
        $reason = "";
    }
    
    if(!$error){
        
        $date_rejected = date("d-m-Y");
        
        $result = $db_con->query("UPDATE leave_applications SET action = 'reject' 
            WHERE leave_id = $leave_id AND staff_id = $staff_id");

        if($db_con->affected_rows == 1){
            
            $stmt = $db_con->prepare("INSERT INTO rejected_leaves(leave_id,staff_id,
                leave_type,reason_reject,date_rejected) VALUES(?,?,?,?,?)");

            $stmt->bind_param("iisss",$leave_id,$staff_id,$leave_type,$reason,$date_rejected);

            $stmt->execute();

            if($db_con->affected_rows == 1){
                
               $firstname = ucfirst($firstname);
               
               $to = "$email";
               
               $subject = "Leave Has Been Rejected";
               
               $reason = wordwrap($reason,70,'\r\n');
               
               $message = "Hi $firstname!\r\n\tYour leave application with Leave ID $leave_id has been rejected by your Supervisor for the following reason:\r\n\"$reason\"\r\nYou can contact your Supervisor for more info.\r\n\r\n\t\t\t
                      Good Luck Next Time!";
                 
               $msg = wordwrap($message,70,"\r\n");
                      
               $from = "HR: <hr@leavemanager.com>";
               
               if(mail($to, $subject, $msg, $from)){
                                      
                    $msg = urlencode("Leave has been rejected");

                    redirect_user("dashboard.php?tab=7&msg=$msg");
               }

            }else{
                redirect_user("dashboard.php?tab=7&error=Leave+could+not+be+rejected+".$db_con->error);
            }
        }else{
                redirect_user("dashboard.php?tab=7&error=Leave+could+not+be+rejected+".$db_con->error);
            }
        
    }else{
        redirect_user("dashboard.php?tab=7&error=".join($error,  urlencode("<br>")));
        
    }
}else{
    redirect_user("404.php");
}