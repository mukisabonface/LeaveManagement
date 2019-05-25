<?php

$result = $db_con->query("SELECT * FROM employee WHERE supervisor IS NULL OR supervisor = ''");

if($result->num_rows > 0){
    
    $res = $db_con->query("SELECT * FROM employee WHERE staff_level = 'supervisor'");

    if($res->num_rows > 0){

        echo "<h1 class='text-center hide'>Assign Supervisor</h1>

            <form action='process.php' method='post' class='mb-5'>

                <label for='users'>Select user to assign supervisor</label>
                <select name='assign-to' class='form-control w-50' id='users' required>";
        while($row = $result->fetch_object()){
            
            echo "<option value='$row->username'>$row->fname $row->lname</option>";
        }
             
            
        echo "</select><hr>
        
        <label for='supervisors'>Choose Supervisor</label><br>
                <select name='supervisor' class='form-control' id='supervisors' required>";
        while($rows = $res->fetch_object()){
            
            echo "<option value='$rows->username'>$rows->fname $rows->lname</option>";
        }
        
        echo '</select><hr>
            <button class="btn btn-warning" name="assign-super" type="submit">
            Add Supervisor
            </button></form>';
        
    }else{
        
        echo "<h1 class='text-center hide'>Assign Supervisor</h1>

            <form action='process.php' method='post'>

            <p class='alert alert-warning'>There is no user who's been assigned
            as supervisor. You can either choose a user from your registered 
            staff or create a new user with supervisor role</p>
            <label for='select'>Choose staff to make supervisor</label>
                <select name='make-supervisor' class='form-control w-50' id='select'>";
        while($row = $result->fetch_object()){
            
            echo "<option value='$row->username'>$row->fname $row->lname   "
                    . "- $row->staff_id</option>";
        }
        
        echo '</select><br>
            <input type="hidden" name="tab" value="5">
            <button class="btn btn-warning" name="make-super" type="submit">
            Make Supervisor
            </button></form><hr>
            <span class="circled-content centered">Or</span><hr>
            <h4 class="text-center mb-2">Register New Supervisor</h4>';
        
        include_once("inc.register.php");
        
    }
}else{
    echo '<h1 class="text-center">No staff available for assignment</h1>'
    . '<p>There is no currently a member of staff who is not assigned to a supervisor. '
            . 'Keep up the good work!</p>';
}