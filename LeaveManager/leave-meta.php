<?php

$data = <<<TTY
    <h3 class='text-center'>Staff Leave Meta Data</h3>
    
    <form action='process.php' method='post'>
        <label for='salary'>Select Staff</label>
        <select name='staff_level' id='select-user'>
            <option value='supervisor'>Supervisor</option>
            <option value='non-supervisor'>Non Supervisor</option>         
        </select><hr>
             
        <label for='allowed_days'>Annual Days Allowed</label>
        <input type='number' min='1' name='annual_leave_days_allowed' class='form-control mb-2' id='allowed_days'><hr>

        <label for='monthly_allowed_days'>Monthly Days Allowed</label>
        <input type='number' min='1' name='monthly_leave_days_allowed' class='form-control mb-2' id='monthly_allowed_days'><hr>

        <hr><button name='staff_meta' class='btn btn-primary'>Add Meta</button><br>
    </form>
TTY;
echo $data;