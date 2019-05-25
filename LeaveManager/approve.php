<?php

$res = $db_con->query("SELECT * FROM employee WHERE staff_level IS NULL OR staff_level = ''");

if($res->num_rows > 0){

    echo '<div class="card mb-md-5">
    <h1 class="text-md text-center">Pending Leaves</h1>
        <table class="table table-bordered table-responsive-sm w-100">

            <thead class="thead-dark">
                <th>Staff ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Date Registered</th>
                <th>Action</th>
            </thead>';

    while ($row = $res->fetch_object()){
    
        
        $student = <<<STAFF
                <tr>

                    <td>$row->staff_id</td>
                    <td>$row->username</td>
                    <td>
                        $row->fname $row->lname
                    </td>
                
                     <td>$row->date_registered</td>
                   
                    
                    <td><form action="process.php" method="post">
                        <input name="staff_id" value="$row->staff_id" type="hidden">
                        <input type="hidden" name="id" value="$row->id">
                        <button class="btn success-btn" name='approve'>Approve</button>
                        </form>
                    </td>
                   
                </tr>
STAFF;

    echo $student; 
    }
    
    echo '</table></div>';
}else{
    echo '<div class="mt-4">
        <h1 class="text-md text-center">Nothing available</h1></div>';
}
    