<?php
include_once("connection.php");
/* 
 * Copyright (C) 2018 kamil.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

$query = "CREATE TABLE IF NOT EXISTS job_description(id INT NOT NULL 
    AUTO_INCREMENT PRIMARY KEY, staff_id BIGINT NOT NULL,
    staff_level ENUM('supervisor','non-supervisor') NOT NULL, salary_level 
    DECIMAL(100,2) NOT NULL, date_joined VARCHAR(25) NOT NULL,
    annual_leave_days_allowed INT NOT NULL, total_leave_days INT NOT NULL, 
    total_taken_leaves INT NOT NULL)";

$result = $db_con->query($query);

if(!$result){
    
    $eror = $db_con->error;
    echo "<h1>You have an error in your statement. Error $eror</h1>";
}