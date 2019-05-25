<?php

 include_once("header.php");
    
if(isset($_SESSION['admin-user']) && $_SESSION['admin-user'] !== ""){

    $username = $_SESSION['admin-user'];

    $id = $_SESSION['admin-id'];

    $result = $db_con->query("SELECT * FROM admin WHERE username = '$username'");

    if($result->num_rows == 1){
        
        $row = $result->fetch_object();
        
        $fullname = $row->fname." ".$row->lname;
        
    }

    include_once("dash-header.php");
   
     echo "<div class='col-md-8 ml-md-3'>"
    . "<div class='main-content'>";
      show_alert();
    
   
    $date_posted = date('Y-m-d');

    $time_posted = date('h:m:sa',time());

    if(isset($_GET['tab']) && $_GET['tab'] == 1){

        $leave_types = ['annual'=>"Annual Leave",'sick'=>"Sick Leave",'maternity'=>'Maternity Leave',
        'paternity'=>'Paternity Leave','study'=>'Study Leave','emergency'=>'Emergency Leave',
        'casual'=>'Casual Leave','special'=>'Special Leave','examinations'=>'Exams Leave',
        'sports'=>'Sports Leave','absense'=>'Absence Leave',
        'short_embark_disembark'=>'Short Embarkation/Disembarkation Leave',
        'long_embark_disembark'=>'Long Embarkation/Disembarkation Leave'];
    
        echo "<h1 class='text-center hide'>New Leave Type</h1>

                <form action='leaves.php' method='post' class='mb-5'>
                
                    <label for='leave-type'>Leave Type</label><br>
                    <select name='leave_type' id='leave-type' class='selectable' required>
                        <option value=''>---Select---</option>";
        
                    foreach($leave_types as $key=>$value){
                        echo "<option value='$key'>$value</option>";
                    }
                    unset($leave_types);

                    $leave_id = rand(10, 20).date("U");
                    
                    $date_now = date("U")+2591590;
                    
                    $auto_date = date("U") + 2591590;

                    $dif = intval($date_now) - intval($auto_date);
                    
                    echo "</select><hr>
                
                    <label for='title'>Allowed Days</label><br>
                            
                    <input type='number' min='0' name='allowed_days' id='days' required><br>
                    <div id='hint' class='hide text-red'>
                    
                        <ul style='list-style-type:none;font-size:13px;'><br>
                            <b>Note:</b>
                            <li> 0 means Indefinite</li>
                            <li> 1 or more convey actual days</li>
                        </ul>
                    </div><hr>
                    <label for='title'>Allowed Monthly Days</label><br>
                            
                    <input type='number' min='1' name='allowed_monthly_days' required>
                    
                    <input type='hidden' name='leave_id' value='$leave_id'>
                    <input type='hidden' name='auto_update' value='$auto_date'>
                    <hr>
                    <label>Staff Level</label><br>
                    <select name='staff_level' class='selectable'>
                        <option value='supervisor'>Supervisor</option>
                        <option value='non-supervisor'>Non-supervisor</option>
                    </select>

                    <hr><button class='btn btn-primary ml-md-5' name='new_leave'>Publish Leave</button>

                </form><hr><br>";

    }elseif(isset($_GET['tab']) && $_GET['tab'] == 2){

        include_once("approve.php");
        
    }elseif(isset($_GET['tab']) && $_GET['tab'] == 3){

        include_once("pending-leaves.php");
        
    } elseif(isset($_GET['tab']) && $_GET['tab'] == 4){

        include_once("account.php");
        
    } elseif(isset($_GET['tab']) && $_GET['tab'] == 5){

        include_once("assign.php");
        
    }elseif(isset ($_GET['tab']) && $_GET['tab'] == 6){
        include("desc.php");
    }elseif(isset ($_GET['tab']) && $_GET['tab'] == 7){
        include("new.php");
     }elseif(isset ($_GET['tab']) && $_GET['tab'] == 8){
        include("leave-meta.php");
    }else{
    $kamil = <<<FMS
        <div class="container mb-5 p-4">
            <h4 class="text-center">
            Welcome, $row->fname $row->lname</h1>
            <p>Here is where to manage your details as an employee. 
            With the tabs on the left-sidebar, you can view, edit and delete
             your account without any difficulty.</p>
            <p>Also included are the ability to view your leave requests 
            such as recommended leaves, accepted leaves, rejected leaves, in 
            addition to being able to request for new leaves - all at the 
            comfort of your home or on the go.</p>
            <p>You can view your job description, generate reports of the 
            leave activities of a particular time/all time, view leave 
            statistics, pending leaves, and update your job description.
            </p>
            <h5>We hope you love your dashboard</h5>
            <quote class="float-right mute muted">
                <i class="fa fa-heart fa-4x text-green"></i><br>
                <span>Your friends!</span><br>
                Group One</quote>
            <br><br><br>
        </div>
     </div>
FMS;
    echo $kamil;
    }

    echo "</div></div>";
    ?>
    <script src="js/jquery.js"></script>

    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="js/main.js"></script>
    <script>
        $('#days').on('change input', function(){
            
            var val = $(this).val();
            
            if(val !== ''){
                $("#hint").removeClass("hide");
            }else{
                
                $('#hint').addClass("hide");
            }
        });
        
    </script>
        
    </body>
    </html>
    <?php
}else{
    header("Location:index.php?action=login&type=admin");
}

include("footer.php");
?>