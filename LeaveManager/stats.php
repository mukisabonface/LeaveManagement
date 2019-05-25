<?php

/**
 * This file contains all leave activities by staff - accepted leaves, rejected 
 * leaves and pending leaves
 */

$result = $db_con->query("SELECT * FROM leave_applications WHERE staff_id = $id");

echo '<div class="card mb-md-5">
        <h1 class="text-center mb-4 text-md">Requested Leaves</h1>
        <table class="table table-bordered table-responsive-sm w-100">

            <thead class="thead-dark">
                <th>Leave ID</th>
                <th>Leave Type</th>
                <th>Status</th>
                <th>Date Requested</th>
            </thead>';

if($result->num_rows > 0){

    while ($row = $result->fetch_object()){
    
        if($row->action == 'accept'){

        $status = "<button class='btn success-btn'>"
                . "<i class='fa fa-check pr-2'></i> Accepted</button>";
        }elseif($row->action == "reject"){

            $status = "<button class='btn danger-btn'>"
                    . "<i class='fa fa-remove pr-2'></i> Rejected</button>";
        }else{
            $status = "<button class='btn pending-btn'>"
                    . "<i class='fa fa-refresh pr-2'></i> Pending</button>";
        }

        if($row->leave_type == "short_embark_disembark"){

            $type = "Short Embarkation/Disembarkation Leave";

        }elseif ($row->leave_type == "long_embark_disembark") {

            $type = "Long Embarkation/Disembarkation Leave";

        }  else {

            $type = ucfirst($row->leave_type)." Leave";

        }

        $student = <<<STAFF
                <tr>

                    <td>$row->leave_id</td>

                    <td>$type</td>

                    <td>
                        $status
                     </td>
                    <td>
                        $row->date_requested
                    </td>
                </tr>
STAFF;

    echo $student; 
    }
     
  
 }else {
        echo '<tr><td class="text-center mb-m-2">No leave data available</td></tr>';
    }

echo '</table></div>';

$res = $db_con->query("SELECT * FROM leaves WHERE leaves.for_staff_level = '$level'");


$rows = $res->num_rows;

if($rows > 0){
    
    $st = $db_con->query("SELECT * FROM leave_applications WHERE staff_id = '$staff_id'
        AND action = 'accept'");
    
    $rws = $st->num_rows;
    $r = $st->fetch_object();

    echo '<div class="card mb-md-5 mt-5">
        <h1 class="text-center text-md">Leave Statistics</h1>
        <table class="table table-bordered table-responsive-sm w-100">
        <thead class="thead-dark">
            <th>Leave ID</th>
            <th>Leave Type - '.$staff_id.'</th>
            <th>Allowed Annual Days</th>
            <th>Allowed Monthly Days</th>
            <th>No. Days Left</th>
        </thead>';

    while($row = $res->fetch_object()){
        
        if($rws > 0){
            $ltype = $r->leave_type;
        }else{
            $ltype = "";
        }
        
        if($row->leave_type == $ltype){
            
            $days = $row->current_days - $rws;
        }else{
            $days = $row->current_days;
        }
        
        if($row->allowed_days == 0){
            
            $allowed = "Indefinite";
            
        }else{
            
            $allowed = $row->allowed_days;
        }
        
        if($row->leave_type == "long_embark_disembark"){
            $type = "Long Embarkation/Disembarkation";
        }elseif($row->leave_type == "short_embark_disembark"){
            $type = "Short Embarkation/Disembarkation";
        }else{
            $type = $row->leave_type;
        }
        
        echo "<tr><td>$row->leave_id</td>
            
                <td>".ucfirst($type)."</td>
                    
                <td>$allowed</td>
                
                <td>$row->allowed_monthly_days</td>
                    
              <td>$days</td></tr>";
    }
    
    echo '</table></div>';
}