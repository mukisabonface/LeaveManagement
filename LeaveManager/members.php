<?php
include("header.php");

if(session_id() == ""){
    redirect_user("login.php");
}

$members = array("Alhassan Kamil"=>"FMS/2173/15","Abdul-Hamid Adnan"=>"FMS/0002/16",
    "Anane Foster"=>"FMS/2181/15","Odzeyem Evans"=>"FMS/2013/14",
        "Anane Prince"=>"FMS/2182/15","Bello Olaniyi Y."=>"FMS/1851/14","Alhassan Adija"=>"FMS/0004/16",
    "Alezumah Eric"=>"FMS/2171/15","Agyeman Gyan"=>"FMS/2160/15");
?>
<div class="container my-5">
    <div class="card">
        <table class="table table-bordered table-responsive-xl">
            <thead class="thead-light">
           
            <th>Name</th>
            <th>ID</th>
            </thead>
            
            <?php
            foreach($members as $key=>$value){
                
            echo "<tr><td>$key</td><td>$value</td></tr>";
            
            }
        echo "</table>      
            
    </div>
</div>";
        ?>
