<?php
//This script returns the fullpath of the image selected from all the information gathered via AJAX this far.
session_start();
include 'connect.php';
    $username = $_COOKIE['cfarcusr']; 
    $imageDate = $_COOKIE['selDate'];
    $cam = $_COOKIE['selCam'];
    $imageTime = $_COOKIE['selTime'];
    $result = mysql_query("
        SELECT DISTINCT
            imageName
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
        AND
            i.imageTime = '$imageTime'
        ") or die(mysql_error());
    //Return the fullpath information so jQuery can display the image
    while ($row = mysql_fetch_assoc($result)) {    
        $fullPath = '/' . $username . '/' . $cam . '/' . $row['imageName'];
    }
    echo $fullPath;
?>