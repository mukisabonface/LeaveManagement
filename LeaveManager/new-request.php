<?php
if($level == "non-supervisor"){
    
    $result = $db_con->query("SELECT * FROM leaves WHERE for_staff_level = 'non-supervisor'");
    
}else{
        
    $result = $db_con->query("SELECT * FROM leaves WHERE for_staff_level = 'supervisor'");

}

if($result->num_rows > 0){
    
    include("leave-types.php");

    echo "<h1 class='text-center hide'>New Leave Request</h1>

        <form action='request.php' method='post' class='mb-5' id='request-form'>
            <input type='hidden' name='staff_id' value='$id'>

            <label for='leave-type'>Select leave type</label>
            <select name='leave_id' class='form-control' required>";

    while($row = $result->fetch_object()){

        
        $num_days = $row->allowed_monthly_days;
        
        switch($row->leave_type){

        case "sick": $type = "Sick leave";
        break;
        case "casual":$type = "Casual leave";
        break;
        case "maternity": $type = "Maternity leave";
        break;
        case "paternity": $type = "Paternity leave";
        break;
        case "annual": $type = "Annual leave";
        break;
        case "study": $type = "Study leave";
        break;
        case "emergency": $type = "Emergency leave";
        break;
        case "special": $type = "Special leave";
        break;
        case "examinations": $type = "Examination leave";
        break;
        case "sports": $type = "Sports leave";
        break;
        case "absense": $type = "Absense";
        break;
        case "short_embark_disembark": $type = "Short Embarkation/Disembarkation";
        break;
        case "long_embark_disembark": $type = "Long Embarkation/Disembarkation";
        break;
        default : "Unknown";
        break;
    
        }
            
            echo "<option class='leave_type' value='$row->leave_id'>$type</option>";
            
    }
       
        echo "</select><hr>";

        
}         

    $min = date("Y-m-d");
    
    echo "<label for='start'>Start Date</label><br>
        <input type='date' name='leave_start_date' min='$min' id='start' class='form-control' required><hr>
        <label for='end'>End Date</label><br>
        <input type='date' name='leave_end_date' id='end' min='$min' class='form-control' required><br>
        <small class='error' id='error'></small>
        <hr>
        <button class='btn btn-warning' type='submit' name='request'>
        Request for a Leave</button></form>";
