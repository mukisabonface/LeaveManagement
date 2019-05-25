<?php
include_once("connection.php");
include("functions.php");

if(isset($_POST['new_leave'])){
    
    $error = array();
    
    if(var_set($_POST['leave_type'])){
        
        include("leave-types.php");
        
        $leave_type = in_array(strip_tags($_POST['leave_type']),$arr) ? strip_tags($_POST['leave_type']):
            $error[] = urlencode("Invalid leave type");
        
    }else{
        
        $error[] = urlencode("Leave type is not chosen");
    }
    
    
    if(var_set($_POST['staff_level'])){
        
        
        $for_staff_level = is_string($_POST['staff_level']) ? strip_tags($_POST['staff_level']):
            $error[] = urlencode("Invalid staff level");
        
    }else{
        
        $error[] = urlencode("Staff level must be selected");
    }
    
    $leave_id = var_set($_POST['leave_id']) ? intval($_POST['leave_id']) :$error[] = urlencode("An error occurred. Try again");
    
    if(var_set($_POST['allowed_days'])){
    
        $allowed_days = is_numeric($_POST['allowed_days']) ? $_POST['allowed_days']: $error[] = urldecode("Allowed days must be a number");
        
    }else{
        $error[] = urlencode("Allowed days must not be blank");
    }
    
    if(var_set($_POST['allowed_monthly_days'])){
  
        $allowed_monthly_days = is_numeric($_POST['allowed_monthly_days']) ? $_POST['allowed_monthly_days']: 
            $error[] = urldecode("Allowed monthly days is not a number");
        
    }else{
        $error[] = urlencode("Please enter allowed monthly days");
    }
    
    $auto_date = var_set($_POST['auto_update']) ? intval($_POST['auto_update']): 
        $error[] = urlencode("There is an error. Try again");
    
    $result = $db_con->query("SELECT * FROM leaves WHERE leave_type = '$leave_type' 
            AND for_staff_level = '$for_staff_level'");
   
    $rows = $result->num_rows;
    
    if($rows == 1){
        
        $error[] = urlencode("Leave type already exists");
    }
    
    if(!$error){
        
        $stmt = $db_con->prepare("INSERT INTO leaves(leave_id,leave_type,
                allowed_days,current_days,allowed_monthly_days, for_staff_level,
                auto_update) VALUES(?,?,?,?,?,?,?)");
        
        $stmt->bind_param("isiiisi",$leave_id,$leave_type,$allowed_days,$allowed_days,
                $allowed_monthly_days,$for_staff_level,$auto_date);
        
        $stmt->execute();
        
        if($db_con->affected_rows == 1){
            
            $msg = urlencode("Leave created successfully");
            redirect_user("admin.php?tab=1&msg=$msg");

        }else{
            
            $error = urlencode("Leave could not be created ".$db_con->error);
            redirect_user("admin.php?tab=1&error=$error");
        }
        
    }else{
          
        redirect_user("admin.php?tab=1&error=".join($error, urlencode("<br>")));
    }
}else{ 
    redirect_user("404.php");
}