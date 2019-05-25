<?php

include_once('connection.php');
include_once('functions.php');

if(isset($_POST['remove']) || isset($_POST['delete'])){

      $page = strip_tags($_POST['page']);
      
      if(var_set($_POST['id']) && is_numeric($_POST['id']) && var_set($_POST['table'])){

            $id = intval(strip_tags($_POST['id']));

            $tbl = strip_tags($_POST['table']);

            $sql = $db_con->query("DELETE FROM $tbl WHERE id = $id");

            $rows = $db_con->affected_rows;

            if($rows == 1){

                  $msg = urlencode("Deleted successfully");

                  header("Location:$page?&msg=$msg");

            } else{

                  $error = urlencode("Couldn't delete item, try again");

                  redirect_user("$page&error=$error");

            }

      }else{

          redirect_user($page);
      }

}else{
      echo "<script>history.go(-1)</script>";
}
?>
