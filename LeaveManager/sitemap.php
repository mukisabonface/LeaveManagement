<?php
include_once("header.php");
?>
<div class="container my-5">
    <div class="card col-md-8">
        <h1 class="text-center">Sitemap - List of pages</h1>
        <p>This page lists the structure and layout of this application and how 
            pages are constructed to give the user the easiest possible navigational 
            and pictographic experience. We tried as much as possible to present the material in the best 
        and simplest format possible so users feel satisfied while using this system.</p>
      
        <h3>Admin Dashboard</h3>
        <ul>
            <li><a href="#admin">Dashboard</a>
                <ul>
                    <li><a href="#account">Account</a></li>
                    <li><a href="#pending">Pending Leaves</a></li>
                    <li><a href="#type">New Leave Type</a></li>
                    <li><a href="#assign-sup">Assign New Supervisor</a></li>                   
                    <li><a href="#approve">Approve Registered Staff</a></li>                    
                    <li><a href="#new-desc">New Job Description</a></li>
                    <li><a href="#new-sup">New Supervisor</a></li>
                    <li><a href="#meta">Staff Leave Meta</a></li>
                </ul>
            </li>
        </ul>
       
        <h3>Staff Dashboard</h3>
        <ul>
            <li><a href="#staff">Dashboard</a>
                <ul>
                    <li><a href="#account">Account</a></li>
                    <li><a href="#notifs">Leave Notifications</a></li>
                    <li><a href="#leave">Leave Actions</a></li>
                        <ul style="list-style: square">
                            <li><a>New Leave</a></li>
                            <li><a>Leave Archives</a></li>
                            <li><a>Generate Report</a></li>
                        </ul>
                    <li><a href="#desc">Job Description</a></li>
                </ul>
            </li>
        </ul>
        
        <h3>Supervisor Dashboard</h3>
        <ul>
            <li><a href="#staff">Dashboard</a>
                <ul>
                    <li><a href="#account">Account</a></li>
                    <li><a href="#notifs">Leave Notifications</a></li>
                    <li><a href="#leave">Leave Actions</a></li>
                        <ul style="list-style: square">
                            <li><a>New Leave</a></li>
                            <li><a>Leave Archives</a></li>
                            <li><a>Generate Report</a></li>
                        </ul>
                    <li><a href="#desc">Job Description</a></li>
                    <li><a href="#admin">Recommend Leaves</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<?php
include_once("footer.php");
?>