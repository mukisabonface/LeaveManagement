<?php
session_start();
error_reporting(0);
$directory = basename(dirname($_SERVER['PHP_SELF']));

include_once('db.php');

include_once("functions.php");

auto_update_leave_curr_date();

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title></title>
<meta name="author" content="Group One">

<?php require_once('styles.php');?>

</head>

<body>

<nav class="fixed-top navbar-expand-lg navbar-expand-xl navbar">

  <a class="navbar-brand mr-5" href="/LeaveManager"><i class="fa fa-leaf text-green"></i> Leave Manager</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-toggle" aria-controls="navbar-toggle" aria-label="Toggle navigation">

    <span class="fa fa-bars"></span>

  </button>

  <div class="collapse navbar-collapse" id="navbar-toggle">

    <ul class="navbar-nav">


    <?php
if(isset($_SESSION['admin-user']) && $_SESSION['admin-user'] !== ""){

    $el = <<<POP

            <li class="nav-item">
                <a class="nav-link" href="/LeaveManager/admin.php">
                <i class="fa fa-cog"></i> Dashboard</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/LeaveManager/admin.php?tab=3">
                <i class="fa fa-refresh"></i> Pending Leaves</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/LeaveManager/admin.php?tab=1">
                <i class="fa fa-plus"></i> New Leave Type</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/LeaveManager/admin.php?tab=5">
                <i class="fa fa-arrows"></i> Assign Supervisor</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/LeaveManager/admin.php?tab=4">
                <i class="fa fa-user-secret"></i> My Account</a>
            </li>

            <li class="nav-item">
                <a href="logout.php" class="nav-link">
                    <i class="fa fa-sign-out"></i>
                    Logout
                </a>
            </li>
POP;

    echo $el;
}else{
        $elmns = <<<POP

            <li class="nav-item">

                <a class="nav-link" href="/LeaveManager/dashboard.php">
                <i class="fa fa-cog"></i> Dashboard</a>

            </li>

            <li class="nav-item">

                <a class="nav-link" href="/LeaveManager/dashboard.php?tab=1">
                <i class="fa fa-calendar"></i> Leaves</a>

            </li>

            <li class="nav-item">

                <a class="nav-link" href="/LeaveManager/dashboard.php?tab=4">
                <i class="fa fa-user-secret"></i> My Account</a>

            </li>

            <li class="nav-item">
POP;

        if(isset($_SESSION['staff-user']) && $_SESSION['staff-user'] != ''){

            $staff_username = $_SESSION['staff-user'];

            $user_dir = "users/myaccount/images/".$staff_username.".jpg";

            echo $elmns;

            if(file_exists($user_dir)){

                echo'<a class="nav-link" title="'.$staff_username.'" href="#">
             <img src="'.$user_dir.'" class="img-square"></a></li>';

            } else{

            echo '<a class="nav-link" title="'.$staff_username.'" href="#">
                <i class="fa fa-user"></i> '.ucfirst($staff_username).'</a></li>';

            }

            echo "<li class='nav-item'><a href='logout.php' class='nav-link'>"
              ."<i class='fa fa-sign-out'></i> Logout</a></li>";

        }elseif(isset($_SESSION['supervisor-user']) && $_SESSION['ssupervisor-user'] !== ""){

            $supervisor_username = $_SESSION['ssupervisor-user'];

            $user_dir = "users/myaccount/images/".$supervisor_username.".jpg";

            echo $elmns;

            echo '<li class="nav-item">
                    <a class="nav-link" href="/LeaveManager/admin.php?tab=1">
                    <i class="fa fa-arrows-alt"></i> Recommend Pending</a>
                </li>';

            if(file_exists($user_dir)){

                echo'<a class="nav-link" title="'.$supervisor_username.'" href="#">
             <img src="'.$user_dir.'" class="img-square"></a>';

            } else{

            echo '<a class="nav-link" title="'.$supervisor_username.'" href="#">
                <i class="fa fa-user"></i> '.ucfirst($supervisor_username).'</a>';

            }

            echo "<li class='nav-item'><a href='logout.php' class='nav-link'>"
              ."<i class='fa fa-sign-out'></i> Logout</a></li>";

        }else {

            echo "<li class='nav-item'><a href='index.php' class='nav-link'>"
              ."<i class='fa fa-sign-in'></i> Login</a></li>

            <li class='nav-item'><a href='register.php' class='nav-link'>"
              ."<i class='fa fa-lock'></i> Signup</a></li>";
        }
}
        ?>

        </ul>
    </div>
</nav>
    <hr>
