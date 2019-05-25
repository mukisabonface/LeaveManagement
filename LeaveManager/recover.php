<?php
include_once("header.php");

if(isset($_GET['token']) && isset($_GET['utm_mail'])){
    
    if(is_string($_GET['token']) && $_GET['utm_mail'] !== ""){
        
        $token = isset($_GET['token']) ? strip_tags($_GET['token']) : "";
        
        $mail = isset($_GET['utm_mail']) ? strip_tags($_GET['utm_mail']) : "";
        
        $sql = $db_con->query("SELECT * FROM password_recovery_meta WHERE 
                token = '$token' AND email = '$email'");
        
        $rows = $sql->num_rows;
        
        if($rows == 1){
        
            while($result = $sql->fetch_object()){
        
            $len = <<<_
                <div class="container my-5">
                    <div class="card">
                    <h1 class="text-lg-2">Change your password</h1>
                    <form action="update.php" method="post">
                        <input type="hidden" value="$result->email" name="email">
                        <label for="password">New password</label>
                        <input type="password" name="password" id="password" required>
                        <div class="error-line1 text-sm text-red"></div>
                
                        <label for="conf-pass">Retype password</label>
                        <input type="password" name="confpassword" id="conf-pass" required>
                         <div class="error-line2 text-sm text-red"></div>
                        <button class="btn btn-success" name="update-pass">Change Password</button>
                   </form>
                </div>
_;
        echo $len;
            }
        }
    }else{
        header("Location:index.php");
    }
}else{
    
    $random_no = strtoupper(strval(uniqid(date("jny"),$more_entropy = TRUE)));
    $token = str_replace(".","F9AD8",$random_no);
    
    $tomorrow = date("j") + 2;
    
    $tomorrow .= date("nY");
    
    $expire = date("jnY");
    
    $len = <<<_Pad
        <div class="container my-5">
            <div class="card">
            <h1 class="text-lg">Provide your email</h1>
            <p>Provide your email so that we can send you a new password. This 
            email must be active and be the one you used to register your account
            </p>
            <form action="mail.php" method="post">
                <input type="hidden" value="$token" name="token">
                <label for="email">Email Address</label><br>
                <input type="email" name="email" id="email" required>

                <input type="hidden" name="expire" value="$tomorrow"><hr>
                <button class="btn btn-success" name="recover_password">Send Password</button>
           </form>
        </div>
_Pad;
    echo $len;
}

?>
