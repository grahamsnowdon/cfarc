<?php

//This script will eventually return the population of the earliest date available in the interface for that specific customers contract
//But currently does nothing.
session_start();
$username = $_COOKIE['cfarcusr']; 
include 'connect.php';
    $resultFirst = mysql_query("
        SELECT DISTINCT
            cam
        FROM
            images AS i
        INNER JOIN
            users AS u ON i.userID = u.UserID
        WHERE
            u.username = '$username'
        ORDER BY
        imageDate
        ASC
        LIMIT
        1
    ") or die(mysql_error());
    // populate the date range div
    while ($row = mysql_fetch_assoc($resultFirst)) { 
        echo $row['imageDate'];
    }
?>