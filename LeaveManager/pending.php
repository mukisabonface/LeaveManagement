<?php

$result = $db_con->query("SELECT * FROM leave_applications WHERE 
        action IS NULL");

echo '<div class="card mb-md-5">
    <h1 class="text-md text-center">Pending Leaves</h1>
        <table class="table table-bordered table-responsive-sm w-100">

            <thead class="thead-dark">
                <th>ID</th>
                <th>Type</th>
                <th>Staff ID</th>
                <th>Starts</th>
                <th>Ends</th>
                <th>Requested on</th>
                <th colspan="3">Action</th>
            </thead>';

if($result->num_rows > 0){

    while ($row = $result->fetch_object()){
    
        if($row->leave_type == "short_embark_disembark"){

            $type = "Short Embarkation/Disembarkation Leave";

        }elseif ($row->leave_type == "long_embark_disembark") {

            $type = "Long Embarkation/Disembarkation Leave";

        }  else {

            $type = ucfirst($row->leave_type)." Leave";

        }
        
        $id = $row->id;
        $staf_id = $row->staff_id;
        $leave_type = $row->leave_type;
        $leave_id = $row->leave_id;
        global  $id;
        global $staf_id;
        global $leave_id;
        global $leave_type;
        
        $start = str_replace('-', '', $row->leave_start_date);
        
        $end = str_replace('-', '',$row->leave_end_date);
        
        $num_days = intval($end) - intval($start);
        
        $rows = query_db("SELECT fname,email FROM employee WHERE 
            staff_id = $row->staff_id");
        
        $student = <<<STAFF
                <tr>

                    <td>$row->leave_id</td>
                    <td>$type</td>
                    <td>
                        $row->staff_id
                    </td>
                
                     <td>$row->leave_start_date</td>
                   
                    <td>
                        $row->leave_end_date
                    </td>
                    <td>
                        $row->date_requested
                    </td>
                    <td>
                    <button type="button" class="btn success-btn" data-toggle="modal" data-target="#rec-$row->leave_id">
                        Recommend
                    </button>
                    <div class="modal" id="rec-$row->leave_id" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Any reason for recommending leave?</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <form action="recommend.php" method="post">
                                    <input name="leave_id" value="$row->leave_id" type="hidden">
                                    <input type="hidden" name="staff_id" value="$row->staff_id">
                                    <input type="hidden" name="recommended_by" value="$username">
                                    <input name="leave_type" value="$row->leave_type" type="hidden">

                                    <input type="hidden" name="email" value="$rows->email">
                                    <input type="hidden" name="firstname" value="$rows->fname">
                                    <input type="hidden" name="num_days" value="$num_days">
                                    <label>Provide reason here</label><br>
                                    <textarea name="why_recommend" class="form-control"></textarea><hr>
                                    <button class="btn btn-success" name='accept'>
                                        Continue
                                    </button>
                                </form>
                            </div>
                           </div>
                          </div>
                         </div>
                    </td>
                    <td><button type="button" class="btn danger-btn" data-toggle="modal" data-target="#reject-$row->leave_id">
                        Reject
                        </button>
                        
                        <div class="modal" id="reject-$row->leave_id" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Reason</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <form action='recommend.php' method='post'>
                                    <label for='notif'>Reason for rejection</label>
                                    <hr class='divider'>
                                    <small>Is there any reason for rejecting this leave? Enter it
                                    here</small>
                                    <input type="hidden" name="email" value="$rows->email">
                                    <input type="hidden" name="firstname" value="$rows->fname">
                                    <input name="leave_id" value="$row->leave_id" type="hidden">
                                    <input type="hidden" name="staff_id" value="$row->staff_id">
                                    <input name="leave_type" value="$row->leave_type" type="hidden">
                                    <textarea name='reason' class='form-control' id='notif'></textarea><br>

                                    <button name='reject' class='btn btn-danger btn-sm'>
                                    Reject Leave</button>
                                </form>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                        </div>
                        </div>
                    </td>
                </tr>
STAFF;

    echo $student; 
    }
    
    echo '</table></div>';
    
    echo "";
  
 }else {
        echo '<tr><td class="text-center mb-m-2">No leave data available</td></tr>'
     . '</table></div>';
    }

