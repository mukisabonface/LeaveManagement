<?php
require_once("connection.php");

/*
 * Initializing @var $results to array. We want to create many tables so
 * this @var will be used to query the @db
 */
$results = array();

/*
 * These are the tables that are needed. Although automatically generated and
 * filled, some tables need to be ACTIVATED either by admin or the user.
 * ACTIVATED here means by pressing one or more buttons or entering text into
 * various input/text boxes
 */

/******************** TO BE ACTIVATED BY ADMINISTRATOR *************************/

$query = "CREATE TABLE IF NOT EXISTS leaves(id INT NOT NULL AUTO_INCREMENT
    PRIMARY KEY, leave_id BIGINT NOT NULL UNIQUE, leave_type ENUM('annual',
    'sick','maternity','paternity','study','emergency','casual','special',
    'examinations','sports','absense','short_embark_disembark',
    'long_embark_disembark') NOT NULL, allowed_days BIGINT NOT NULL,
    current_days INT NOT NULL, allowed_monthly_days BIGINT NOT NULL,
    for_staff_level VARCHAR(200) NOT NULL,auto_update BIGINT NOT NULL)";

$results[] = $db_con->query($query);

$stmt = "CREATE TABLE IF NOT EXISTS leave_applications(id INT NOT NULL AUTO_INCREMENT
    PRIMARY KEY, leave_id BIGINT NOT NULL, staff_id BIGINT NOT NULL,
    leave_type VARCHAR(250) NOT NULL,leave_start_date VARCHAR(25) NOT NULL,
    leave_end_date VARCHAR(25) NOT NULL, action ENUM('accept','reject'),
    date_requested VARCHAR(25) NOT NULL)";

$results[] = $db_con->query($stmt);


/*********************** AUTO-GENERATED TABLES *******************************/
/**
 * These tables are automatically created and filled based on the actions of the
 * admin or staff/supervisor
 */

$res = "CREATE TABLE IF NOT EXISTS user_leave_metadata(id INT NOT NULL AUTO_INCREMENT
    PRIMARY KEY, leave_id BIGINT NOT NULL UNIQUE, staff_id BIGINT NOT NULL,
    leave_type VARCHAR(250) NOT NULL,total_yr_leave_count BIGINT NOT NULL,
    total_month_leave_count BIGINT NOT NULL, yr_leave_left BIGINT NOT NULL,
    month_leave_left BIGINT NOT NULL, total_leave_left_staff BIGINT NOT NULL)";

$results[] = $db_con->query($res);


$querry = "CREATE TABLE IF NOT EXISTS accepted_leaves(id INT NOT NULL AUTO_INCREMENT
    PRIMARY KEY, leave_id BIGINT NOT NULL, staff_id BIGINT NOT NULL,
    leave_type VARCHAR(250) NOT NULL, num_days INT NOT NULL,
    date_accepted VARCHAR(25) NOT NULL)";

$results[] = $db_con->query($querry);

$q = "CREATE TABLE IF NOT EXISTS password_recovery_meta(id INT NOT NULL AUTO_INCREMENT
    PRIMARY KEY, token VARCHAR(2000) NOT NULL, expiry BIGINT, email VARCHAR(1000) NOT NULL)";

$results[] = $db_con->query($q);

$qry = "CREATE TABLE IF NOT EXISTS rejected_leaves(id INT NOT NULL AUTO_INCREMENT
    PRIMARY KEY, leave_id BIGINT NOT NULL, staff_id BIGINT NOT NULL,
    leave_type VARCHAR(250) NOT NULL,
    reason_reject VARCHAR(1000), date_rejected VARCHAR(25) NOT NULL)";

$results[] = $db_con->query($qry);

$sqlquery = "CREATE TABLE IF NOT EXISTS recommended_leaves(id INT NOT
    NULL AUTO_INCREMENT PRIMARY KEY, leave_id BIGINT NOT NULL,
    leave_type VARCHAR(250) NOT NULL,staff_id BIGINT NOT NULL,num_days INT NOT NULL,
    recommended_by VARCHAR(250) NOT NULL,why_recommend VARCHAR(1000),
    date_recommended VARCHAR(25) NOT NULL,status ENUM('accepted','rejected'))";

$results[] = $db_con->query($sqlquery);

$sql_query = "CREATE TABLE IF NOT EXISTS job_description(id INT NOT NULL
    AUTO_INCREMENT PRIMARY KEY, staff_id BIGINT NOT NULL,
    staff_level ENUM('supervisor','non-supervisor') NOT NULL, salary_level
    DECIMAL(45,2) NOT NULL, date_joined VARCHAR(25) NOT NULL,
    annual_leave_days_allowed INT NOT NULL, total_leave_days INT NOT NULL,
    total_taken_leaves INT NOT NULL)";

$results[] = $db_con->query($sql_query);

$sql = "CREATE TABLE IF NOT EXISTS employee(id INT NOT NULL AUTO_INCREMENT
    PRIMARY KEY, staff_id BIGINT NOT NULL UNIQUE, title VARCHAR(20) NOT NULL,
    fname VARCHAR(150) NOT NULL, lname VARCHAR(150) NOT NULL,
    username VARCHAR(70) NOT NULL UNIQUE,password VARCHAR(250) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE, country_code VARCHAR(4) NOT NULL,
    phone INT(10) UNSIGNED NOT NULL UNIQUE, supervisor VARCHAR(200),
    staff_level ENUM('supervisor','non-supervisor'),
    date_registered DATE NOT NULL)";

$results[] = $db_con->query($sql);

$stmt = "CREATE TABLE IF NOT EXISTS admin(id INT NOT NULL AUTO_INCREMENT
    PRIMARY KEY, admin_id BIGINT NOT NULL UNIQUE, title VARCHAR(20) NOT NULL,
    fname VARCHAR(150) NOT NULL, lname VARCHAR(150) NOT NULL,
    username VARCHAR(70) NOT NULL UNIQUE,password VARCHAR(250) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,phone INT(10) UNSIGNED NOT NULL UNIQUE,
    date_registered DATE NOT NULL)";

$results[] = $db_con->query($stmt);
?>
