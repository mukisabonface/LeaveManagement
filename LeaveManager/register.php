<?php
include_once("styles.php");

if(isset($_SESSION['username'])){

    echo "<script>histroy.back();</script>";

}

?>

<div class="container">
<h1 class="text-hide">Signup for an account</h1>

<h4 class="text-center">Register for an account</h4>

    <div class="row">

        <div class="col-md-6 mb-3 mx-auto">

            <div class="card login">

<?php

            if(isset($_GET['error']) && !empty($_GET['error'])){

                $error = $_GET['error'];
                
                echo "<small class='alert alert-danger alert-dismissible'>$error
                <span class='close' data-dismiss='alert'>&times;</span></small>";
            }
 
?>


    <form action="process.php" method="post" id="signup">
        
        <div class="row mb-2">
            <div class="col-md-4 mb-md-2">
                <label for="title">Title</label><br>

                <select name="title" id="title">
                    <option value="Mr">Mr</option>
                    <option value="Ms">Ms</option>
                    <option value="Dr">Dr</option>
                    <option value="Mrs">Miss</option>
                </select>
            </div>
            
            <div class="col-md-8 mb-2">
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
            </div>
  
        </div>
            
        <div class="row my-2">
            
            <div class="col-md-6 mb-3">
                <label for="firstname">Firstname</label>
                <input type="text" name="firstname" id="firstname">
            </div>
               
            <div class="col-md-6 mb-3">
                <label for="lastname">Lastname</label>
                <input type="text" name="lastname" id="lastname">
            </div>
        </div>
        <div class="container el">
            <label class="padding-none">Phone Number</label>
            <hr class="divider">

            <div class="row">
                <div class="col-4 stacked-el">
                    <label for="code" class="text-sm padding-none">Country code</label><br>
                    <select name="country-code" id="code">
                        <?php

                        for($i = 1; $i < 301; $i++){
                            echo "<option value='+$i'>+$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-8 stacked-el">
                    <label for="phone" class="text-sm padding-none">Number</label><br>
                    <input type="text" name="phone" placeholder="543000391" id="phone">
                </div>
            </div>
        </div>
        
        <div class="row mb-2">
            
            <div class="col-md-6 mb-2">
                <label for="email">Email</label>
                <input  name="email" id="email">
            </div>
            
            <div class="col-md-6">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
        </div>

        <button class="btn btn-yellow" type="submit" name="register">
            Register
        </button>
        <p class="text-sm">
            Already registered?
            <a href="index.php" class="text-sm">Login here</a>
        </p>
    </form>
    </div>
   </div>
  </div>
 </div>

<?php include('footer.php');

