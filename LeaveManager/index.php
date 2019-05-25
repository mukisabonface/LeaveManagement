<?php session_start();

 include_once("functions.php");
 
if(session_id() !== ""){

    if(isset($_SESSION['staff-user']) && $_SESSION['staff-user'] !== ""){

        redirect_user("dashboard.php");

    }elseif(isset($_SESSION['supervisor-user']) && $_SESSION['supervisor-user'] !== ""){

        redirect_user("dashboard.php?type=supervisor");

    }elseif(isset($_SESSION['admin-user']) && $_SESSION['admin-user'] !== ""){

        redirect_user("admin.php");
    }
}
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
        <?php
         
        include_once("login.php");

        include_once("scripts.php");

        ?>
        <h1><a  href='admin.php'>admin  |   <a href='index.php'>Staff</h1>
   
</body>
</html>