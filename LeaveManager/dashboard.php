<?php
include_once("header.php");

if(!isset($_SESSION['staff-user']) && $_SESSION['staff-user'] == ""){

    echo "<script>location.href = 'index.php';</script>";

}else{


    $staff_username = $_SESSION['staff-user'];

    $staff_email = $_SESSION['staff-email'];

    $staff_id = $_SESSION['staff-id'];


    $res = query_db("SELECT * FROM employee WHERE username = '$staff_username'");

    $id = $res->staff_id;

    $level = $res->staff_level;

    $username = $res->username;

    include_once("dash-header.php");

    echo "<div class='col-md-8 ml-md-3'>"
    . "<div class='main-content'>";

     show_alert();

    if(isset($_GET['tab']) && $_GET['tab'] == 1){

        $tabs = <<<PHP

            <ul class="nav nav-tabs nav-fill" id="tab_content" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" id="rejected-tab" data-toggle="tab"
                        href="#rejected" role="tab" aria-controls="rejected" aria-selected="true">
                    <i class="fa fa-close"></i>
                    <span class="extra-sm break">Rejected</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="accepted-tab" data-toggle="tab"
                        href="#accepted" role="tab" aria-controls="accepted"
                            aria-selected="false">
                        <i class="fa fa-handshake-o"></i>
                        <span class="extra-sm break">Accepted</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="no-action-tab" data-toggle="tab"
                        href="#no-action" role="tab" aria-controls="no-action"
                            aria-selected="false">
                        <i class="fa fa-refresh"></i>
                        <span class="extra-sm break">Pending</span>
                    </a>
                </li>
            </ul>
PHP;
        echo $tabs.'<div class="tab-content" id="tab">';

        $result = $db_con->query("SELECT * FROM rejected_leaves WHERE staff_id = $id");

        echo '<div class="tab-pane fade show active p-5" role="tabpanel"
                aria-labelledby="rejected-tab" id="rejected">';

        if($result->num_rows > 0){

           echo '<div class="card mb-md-5">
                <h1 class="text-md text-center">Pending Leaves</h1>
                    <table class="table table-bordered table-responsive-sm w-100">

                        <thead class="thead-dark toggle-leave">
                            <th>Leave ID</th>
                            <th>Leave Type</th>
                            <th>Reason</th>
                            <th>Date Rejected</th>
                            <th>Action</th>
                        </thead>';

                    while($row = $result->fetch_object()){

                        $reason = strlen($row->reason_reject) > 0 ? substr($row->reason_reject,0,15):"No reason";

                        $reasons = nl2br($row->reason_reject);
                        $r = <<<PP
                        <tr id='to-be-removed_$row->id'>

                            <td>$row->leave_id</td>
                            <td>$row->leave_type</td>
                            <td>$reason...</td>

                            <td>
                                $row->date_rejected
                             </td>
                            <td>
                                <button class="btn details" id="$row->id">
                                    Details
                                </button>
                            </td>
                        </tr>

                        <tr id='to-replace_$row->id' class='hide'>

                            <td colspan="4">$reasons</td>
                            <td>
                                <button class="btn text-sm back-btn" name="$row->id"
                                    id="replace_$row->id">
                                    <small>Back</small>
                                </button>
                            </td>
                        </tr>
PP;
                    echo $r;
                    }

            echo "</table>
             </div>";

        }else {
            echo '<h2 class="text-center mb-5">No data available</h2>';
        }

        echo '</div>';

        $result = $db_con->query("SELECT * FROM accepted_leaves WHERE staff_id = $id");

        echo '<div class="tab-pane fade show p-5" role="tabpanel"
                aria-labelledby="accepted-tab" id="accepted">';
        if($result->num_rows > 0){

            echo '<div class="card">
                    <table class="table table-bordered table-responsive-sm w-100">

                        <thead class="thead-dark">
                            <th>Leave ID</th>
                            <th>Leave Type</th>
                            <th>Number of Days</th>
                            <th>Date Accepted</th>
                        </thead>';

            while($row = $result->fetch_object()){

                $type = ucwords(implode(' ',explode('_',$row->leave_type)));

                echo "<tr>
                        <td>$row->leave_id</td>

                        <td>$type</td>

                        <td>$row->num_days</td>

                        <td>
                            $row->date_accepted
                        </td>
                    </tr>";
            }

        echo "</table>
           </div>";

        }else {
            echo '<h2 class="text-center mb-5">No data available</h2>';
        }

        echo ' </div>';

        $rows = query_db("SELECT * FROM leave_applications WHERE action IS NULL "
                . "OR action = '' AND staff_id = $id");

        echo '<div class="tab-pane fade show p-5" role="tabpanel"
                aria-labelledby="no-action-tab" id="no-action">';

        if($rows){

            $type = ucwords(implode(' ', explode('_',$rows->leave_type)));

            $more = <<<GROUP_ONE
                <div class="card">
                    <table class="table table-bordered table-responsive-sm w-100">
                        <thead class="thead-dark">
                            <th>Leave ID</th>
                            <th>Date Requested</th>
                            <th>Leave Type</th>
                        </thead>

                        <tr>
                            <td>$rows->leave_id</td>

                            <td>$rows->date_requested</td>

                            <td>
                                $type
                            </td>
                        </tr>

                    </table>
                </form>
            </div>
GROUP_ONE;
            echo $more;
        }else {
            echo '<h2 class="text-center mb-5">No data available</h2>';
        }

        echo '</div></div></div>';

    }elseif (isset($_GET['tab']) && $_GET['tab'] == 2) {

        $stmt = $db_con->query("SELECT * FROM job_description WHERE staff_id = $staff_id");

        $rows = $stmt->num_rows;

        if($rows > 0){

                echo "<h1 class='hide'>Staff Job And Leave Info</h1>
                     <h3 class='text-center text-md'>Brief Summary of Staff Leave And Job Info</h3>
                    <div class='content mb-lg-5'>
                    <table class='table table-bordered table-responsive-sm w-100'>
                        <thead class='thead-dark'>
                            <th>ID</th>
                            <th>Level</th>
                            <th>Salary Level</th>
                            <th>Max Annual Leave Days</th>
                            <th>Max Monthly Days</th>
                            <th>Total Leave Days Left</th>
                            <th>Date Joined</th>
                        </thead>";

            while($row = $stmt->fetch_object()){

                $result = $db_con->query("SELECT * FROM user_leave_metadata WHERE staff_level =
                '$row->staff_level'");

                $level = ucwords($row->staff_level);

                echo "<tr class='text-sm'>
                        <td>$row->staff_id</td>
                        <td>$level</td>
                        <td>$row->salary_level</td>";

                if($result->num_rows > 0){

                    while($rws = $result->fetch_object()){

                        echo "<td>$rws->total_yr_leave_count</td>
                        <td>$rws->total_month_leave_count</td>
                        <td>$rws->current_days</td>";
                    }
                }

                echo "<td>$row->date_joined</td>
                    </tr>";
            }

            echo "</table>
                </div>";

            $res = $db_con->query("SELECT * FROM leaves WHERE leaves.for_staff_level = '$level'");

            $rows = $res->num_rows;

            if($rows > 0){

                $st = $db_con->query("SELECT * FROM leave_applications WHERE staff_id = '$staff_id'
                    AND action = 'accept'");

                $rws = $st->num_rows;
                $r = $st->fetch_object();

                echo '<div class="card mb-md-5 mt-5">
                    <h1 class="text-center text-md">More Leave Statistics</h1>
                    <table class="table table-bordered table-responsive-sm w-100">
                    <thead class="thead-light">
                        <th>Leave ID</th>
                        <th>Leave Type</th>
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

                    $days = $days > 0 ? $days : "Indefinite";
                    echo "<tr><td>$row->leave_id</td>

                            <td>".ucfirst($type)."</td>

                            <td>$allowed</td>

                            <td>$row->allowed_monthly_days</td>

                          <td>$days</td></tr>";
                }

                echo '</table></div>';
            }
        }else{
            echo "<h1 class='text-center text-md mb-lg'>Nothing to show</h1>";
        }

   }elseif (isset($_GET['tab']) && $_GET['tab'] == 3) {

        include_once("stats.php");

    }elseif (isset($_GET['tab']) && $_GET['tab'] == 4) {

        include_once("account.php");

    }elseif (isset($_GET['tab']) && $_GET['tab'] == 5) {


$result = $db_con->query("SELECT * FROM leave_applications WHERE staff_id = $id");

echo '<div class="card mb-md-5">
        <table class="table table-bordered table-responsive-sm w-100">

            <thead class="thead-dark">
                <th>Leave ID</th>
                <th>Leave Type</th>
                <th>Date Start</th>
                <th>Date End</th>
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
                    <td>$row->leave_start_date</td>
                    <td>$row->leave_end_date</td>
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

}elseif (isset($_GET['tab']) && $_GET['tab'] == 6) {

        include_once("new-request.php");

}elseif (isset($_GET['tab']) && $_GET['tab'] == 7) {

        include_once("pending.php");

}else{
        $kamil = <<<FMS
            <div class="container mb-5 p-4">
                <h4 class="text-center">
                Welcome, $res->fname $res->lname</h1>
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

    echo '</div></div></div>';

}


include_once("footer.php");
?>
<script>
    $(".details").click(function(){
        var id = this.id;

        $("#to-be-removed_" + id).fadeOut("slow",function(){

            $("#to-replace_" + id).fadeIn("slow");
        })
    })

    $(".back-btn").click(function(){
        var id = this.id;
        name = this.name;

        $("#to-" + id).fadeOut("slow",function(){
            $("#to-be-removed_" + name).fadeIn();
        });
    });
</script>
