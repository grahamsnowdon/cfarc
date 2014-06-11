<?php
//This script is called using AJAX from interface.html.php and displays the image times from the selector
session_start();
$username = $_COOKIE['cfarcusr'];
$imageDate = $_COOKIE['selDate'];  
include 'connect.php';
    setcookie(selCam, $_POST['cfCam'], $hour);
    $cam = $_COOKIE['selCam'];
    $result = mysql_query("
        SELECT DISTINCT
            *
        FROM
            images AS i
        INNER JOIN
            users AS u ON i.userID = u.UserID
        WHERE
            u.username = '$username'
        AND 
            i.imageDate = '$imageDate'
        AND
            i.cam = '$cam'
        ORDER BY
        imageTime
        ASC
    ") or die(mysql_error());
    // populate the imagetime selector with all the image times for that date and camera specific to that customer.
    while ($row = mysql_fetch_assoc($result)) { 
        echo "<option>" . $row['imageTime'] . "</option>";
    }
?>