<?php
include_once("header.php");
?>
<div class="container my-5">
    <div class="card col-md-8">
        <h1 class="text-center">Leave Manager - Docs</h1>
        <p>This page describes the structure and layout of this application and how 
            pages are constructed to give the user the easiest possible navigational 
            experience. We tried as much as possible to present the material in the best 
        and simplest format possible so users feel satisfied while using this system.</p>
        
        <p>As a result of the above, pages are rendered and adjusted for the different users 
        we're asked to provide functionality for - Admin, Normal Staff, Supervisors. Each 
        is explained in the upcoming sections.</p>
        <p>You can click the links provided below to jump to a particular definition.</p>
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
       
        <h3>Normal Staff Dashboard</h3>
        <ul>
            <li><a href="#staff">Dashboard</a>
                <ul>
                    <li><a href="#account">Account</a></li>
                    <li><a href="#notifs">Leave Notifications</a></li>
                    <li><a href="#leave">Leave Actions</a></li>
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
                    <li><a href="#desc">Job Description</a></li>
                    <li><a href="#admin">Recommend Leaves</a></li>
                </ul>
            </li>
        </ul>
        <hr>
        <h3>Descriptions</h3>
        <h1>Admin Dashboard</h1>
        <div class="container">
            <h4><a id="admin">#Dashboard</a></h4>
            <p>This is the default page that's shown when the overall boss(admin) 
            logs in to his account. It shows nothing but an introductory message 
            and greeting to the admin.</p>
            <h4><a id="account">#Account</a></h4>
            <p>Clicking this tab opens the page that contains the admin's details 
            as provided in the database.</p>
             <h4><a id="pending">#Pending Leaves</a></h4>
            <p>This is where the admin can see who has applied for a leave. It contains 
                every info needed for the admin to approve/disapprove the leave.</p>
            
             <h4><a id="type">#New Leave Type</a></h4>
            <p>With this tab, the admin can easily create a new leave type and add it to 
            the system. As soon as a leave type is created, users can apply for that 
            leave type.</p>
            
            <h4><a id="assign-sup">#Assign New Supervisor</a></h4>
            <p>The page where admin will be able to assign a supervisor to either 
            a newly registered member or change the supervisor of any staff. It is also possible 
            to create a new user and assign him directly to any staff chosen.</p>
            
            <h4><a id="approve">#Approve Registered Staff</a></h4>
            <p>Any member who has been registered will be part of the unapproved 
            staff until he/she is approved by the admin. This is added to prevent 
            global registration and approval of individuals who are not actual members 
            of the institution.</p>
            <p>When a member is approved, he may either be given a supervisor role 
            or an ordinary staff role.</p>
            
            <h4><a id="new-desc">#New job description</a></h4>
            <p>Staff job descriptions can be added by the admin on this page. There 
            is a select box with dropdown so admin can choose the the user level(supervisor 
            or non-supervisor) in addition to other fields necessary for staff details and 
            leave info to be available in the system.</p>
            
            <h4><a id="new-sup">#New Supervisor</a></h4>
            <p>New supervisor roles can be assigned by navigating to this page. Admin 
            has the sole privilege of making and assigning user roles in the system. 
            Therefore, no other user(supervsior or non-supervisor) and make/unmake roles</p>
            
            <h4><a id="meta">#Staff Leave Meta</a></h4>
            <p>Maximum number of days each staff level can request for a leave can be added 
            or updated here. It includes interfaces to both monthly maximum number of 
            days and annual maximum number of days.</p>
        </div>
    </div>
</div>

<?php
include_once("footer.php");
?>