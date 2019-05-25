<?php
?>
<form action="process.php" method="post">
        
    <div class="row mb-2">
        <div class="col-md-5">
            <label for="title">Title</label><br>

            <select name="title" id="title" class="form-control w-75">
                <option value="Mr">Mr</option>
                <option value="Ms">Ms</option>
                <option value="Dr">Dr</option>
                <option value="Mrs">Miss</option>
            </select>

            <label for="username">Username</label><br>
            <input type="text" name="username" id="username">
            <br>
            <label for="firstname">Firstname</label><br>
                <input type="text" name="firstname" id="firstname">
            <br>
               
            <label for="lastname">Lastname</label><br>
                <input type="text" name="lastname" id="lastname">
            <br>
        </div>
        <div class="col-md-5">
            <label class="padding-none">Phone Number</label>
            <hr class="divider">

            <label for="code" class="text-sm">Country code</label><br>
            <select name="country-code" id="code" class="form-control w-75">
                <?php

                for($i = 1; $i < 301; $i++){
                    echo "<option value='+$i'>+$i</option>";
                }
                ?>
            </select>
            
            <label for="phone" class="text-sm">Number</label><br>
            <input type="text" name="phone" placeholder="543000391" id="phone">

            <br>
            <label for="email">Email</label><br>
            <input  name="email" id="email">
            <br>

            <label for="password">Password</label><br>
            <input type="password" name="password" id="password">
        </div>
        <button class="btn btn-warning ml-5" type="submit">Add Supervisor</button>
    </div>
</form>