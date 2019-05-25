<?php
include_once("connection.php");
/* 
 * Copyright (C) 2018 Alhassan Kamil.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

/********************************* MAIN FUNCTIONS FILE *************************
/**
 * This is the function to check whether a user is registered or not
 * @param string $user The user whose details to be checked
 */
    
function is_user_registered($tbl,$user) {

    global $db_con;

    $result = $db_con->query("SELECT * FROM '$tbl' WHERE username = '$user'");

    if($result->num_rows == 0){

        return FALSE;
    }
    return TRUE;   
}

/**
 * Checks whether the specified $item is in the table given as $table. The second 
 * variable $column refers to the column name of $item in the table
 * @global Handle $db_con The connection handle
 * @param string $table Table to check through
 * @param string $column The column to search item
 * @param string $item The item to query.
 * @return boolean True if item in table. False if item is not in table
 */
function in_db($table, $column, $itemn) {
    
    global $db_con;
    
    $name = strval($column);
    
    $res = $db_con->query("SELECT * FROM $table WHERE $name = $item");
    
    if($res->num_rows == 1){
        
        return TRUE;
    }
    return FALSE;
}

/**
 * This function is used to determine whether some rows were affected in the last 
 * database query. If rows were affected, it returns an integer value of one(1) 
 * zero(0) if no row was affetcted 
 * @global Handle $handle The connection handle to the database
 * @param Handle $handle The connection handle
 * @return int Returns 1 if some rows are affected by the query. Otherwise, zero(0)
 *  is returned.
 */
function rows_affected($handle) {
    
    global $handle;
    
    if($handle->affected_rows > 0){
        return 1;
    }
    
    return 0;
}


/**
 * @param string $page
 * Redirects to the page passed in as @param 
 */


function redirect_user($page){
    
    if(isset($page)){
        
        header("Location:$page");
    }
    
}

function show_alert(){
    
     if(isset($_GET['error']) && $_GET['error'] !== ''){

        echo "<div class='alert alert-danger alert-dismissible'>"
        .strval($_GET['error'])."<span class='close' data-dismiss='alert'>&times;
            </span></div>";
        }

    if(isset($_GET['msg']) && $_GET['msg'] !== ''){

         echo "<div class='alert alert-success alert-dismissible'>"
        .$_GET['msg']."<span class='close' data-dismiss='alert'>"
                 . "&times;</span></div>";
    }
}
/**
 * This function queries the database with the command passed to it
 * @global Handle $db_con - The database connection handle.
 * @param String $str - The query statement/string
 * @return boolean = False query unsuccessful or @param $rows on query success
 */
function query_db($str) {  
        
    global $db_con;
        
    $res = $db_con->query($str);
        
    if($res->num_rows < 1 || $db_con->affected_rows == 0){
            
        return FALSE;
    }
        
    $rows = $res->fetch_object();
        
    return $rows;
 }
    
/**
 * 
 * @str String $tbl is table name to select from
 * @param int $id is the id of the item to select
 * @param String $col_identifier is the string representation of @param $col. It's 
 * required if @param $col is specified
 * @param String $col is the column to test against in addtion to id.
 * @return boolean - Returns @param $rows populated with data for use upon success
 * or FALSE on failure
 */
 
function select_with_prepare_stmt($tbl,$id=NULL,$col_identifier=NULL,$col=NULL){
    global $db_con;
    $str = "SELECT * FROM $tbl";
     
     if($id !== ""){
         
         $str .= " WHERE id = ?";
     }
     
     if($col !== "" && $col_identifier !== ""){
         $str .= " AND $col_identifier = ?";
     }
     
     $stmt = $db_con->prepare($str);
     
     $stmt->bind_param("is", $id,$col);
     
     $stmt->execute();
     
     $result = $stmt->get_result();
     
     if($result->num_rows > 0){
         
         $rows = $result->fetch_object();
         return $rows;
     }
     
     return FALSE;
 }
 
/**
 * 
 * @param String $user - User that's to be verified
 * @param String $password - User password
 * @param String $tbl - Table name
 * @return boolean - True on success, False on failure
 */
function verify_user($user, $password, $tbl) {
        
    $query = "SELECT $password FROM $tbl WHERE username = $user";
        
    if(query_db($query)){
            
        if(!password_verify($rows->password, PASSWORD_DEFAULT)){
                
            return FALSE;
        }
    }
        
    return TRUE;
}

/**
 * This function updates the total yearly leaves remaining in the leaves table 
 * at the end of the month. Note that "end of month" here doesn't actually means 
 * the end of the actual month. It's calculated based on the day the leave's created. 
 * This may not be what you want(so it's a bug, huh? :-) )
 * @global Handle $db_con Connection handle
 */
function auto_update_leave_curr_date(){
    
    global $db_con;
    
    $date_now = date("U");
                    
    $query = $db_con->query("SELECT * FROM leaves");
    
    if($query->num_rows > 0){
        
        while($row = $query->fetch_object()){
            
            $difference = intval($date_now) - $row->auto_update;
            
            $reduced = $row->current_days - $row->allowed_monthly_days;
            
            if($difference == 0){
                
                $db_con->query("UPDATE leaves SET current_days = $reduced WHERE id = $row->id");
                                
            }
        }
    }  
}

/**
 * Checks whether a given variable is set and/or not empty
 * @param string $var - The variable we're testing
 * @return boolean True if the variable is set, False otherwise
 */
function var_set($var) {
    
    if((isset($var) && $var !== "")){
        
        return TRUE;
    }
    
    return FALSE;
}
/**
 * 
 * @param string $user_type: the type of user. Used to set the right session variables
 * based  on its value
 * @param string $rows: the name to set session to
 */
function determine_user_set_session($user_type,$rows) {
    
    session_start();
            
    if($user_type == "admin"){

        $_SESSION['admin-user'] = $rows->username;

        $_SESSION['admin-id'] = $rows->id;

    }elseif ($user_type == "employee") {

        $_SESSION['staff-user'] = $rows->username;

        $_SESSION['staff-email'] = $rows->email;

        $_SESSION['staff-id'] = $rows->staff_id;

    }else{

        $_SESSION['supervisor-user'] = $rows->username;

        $_SESSION['supervisor-id'] = $rows->supervisor_id;
        
        $_SESSION['supervisor-email'] = $rows->email;
    }
                
}
/**
 * 
 * @param String $user - The user to verify 
 * @param String $password - Password of this very user
 * @param String $tbl - The table to perform verification
 * @param String $page - Where to redirect to after successful verification
 * @return boolean 
 */

function verify_redirrect_user($user, $password, $tbl, $page) {
        
    $query = "SELECT * FROM $tbl WHERE username = $user";
        
    if(query_db($query)){
            
        if(password_verify($rows->password, PASSWORD_DEFAULT)){
            
            //Verified. Start and set sessions
            determine_user_set_session($tbl);
            
            redirect_user("Location:$page");
        }else{
            $errors[] = urlencode("Password incorrect");
        }
    }
        
    return FALSE;
}

/**
 * 
 * @param string $field - the field we're checking
 * @return boolean - True if field is empty, false otherwise
 */
 
function is_empty($field){
    
    if($field == '' || empty($field)){
        return TRUE;
    }
    
    return FALSE;
}

/**
 * This function loads sylesheets into the workspace/page.
 */

function load_styles(){
    include("styles.php");
}

/**
 * This function is similar to load_styles, except it loads javascript files rather than css file
 */
function load_scripts(){
    include("scripts.php");
}

/**
 * Redirects the user to an appropriate page, if the user is logged in. Will absolutely redirect the user to login page if there's no session running/user's not logged in.
 */
function session_redirect() {
    
    if(isset($_SESSION['staff-user'])){

            redirect_user("Location:dashboard.php");
            
    }elseif(isset($_SESSION['supervisor-user'])){

            redirect_user("Location:dashboard.php?type=supervisor");
            
    }elseif(isset($_SESSION['admin-user'])){

            redirect_user("Location:admin.php");
            
    }  else {
        
        redirect_user("index.php");
    }
        
}

/**
 * This is boolean function that tells whether there is an existing session in place
 * @param string $session_var The session variable to check. This is always string and cannot be any other type
 * @return boolean True if there is session and False otherwise.
 */
function is_session_inplace($session_var) {
    
    if(!isset($_SESSION[$session_var])){

        return FALSE;
    }
    
    return TRUE;
}

/**
 * This takes care of sending email messages to users of this system.
 * @param string $user_email he email of the user to send message to. 
* @param string $subject Subject of the message.
 * @param string $msg The body of the message.
 * @param array $headers Addtional headers to be included in message. This includes 
 * headers such as From, cc and Bcc.
 * @return boolean Returns true if message is sent. False otherwise
 */
function mail_user($user_email,$subject,$msg,$headers = NULL){
    
    $add_h = var_set($headers) ? $headers : "";
    
    if(mail($user_email,$subject,$msg,$add_h)){
        return TRUE;
    }else{
        return FALSE;
    }
    
}