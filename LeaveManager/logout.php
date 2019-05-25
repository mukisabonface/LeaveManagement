<?php
session_start();

if(session_id()){

    if(session_destroy()){

        header("Location:index.php");
    }
    
}
?>