<?php
//This script is called using AJAX from interface.html.php and displays the cameras for the user on the date already selected, 
//if more than one camera displays the other cameras too, if only one camera on the contract then displays just that camera
session_start();
$username = $_COOKIE['cfarcusr']; 
include 'connect.php';
    $imageDate = mysql_real_escape_string($_POST['imageDate']);
    setcookie(selDate, $_POST['imageDate'], $hour); //Sets the selected date to a session cookie
    $result = mysql_query("
        SELECT DISTINCT
            cam
        FROM
            images AS i
        INNER JOIN
            users AS u ON i.userID = u.UserID
        WHERE
            u.username = '$username'
        AND 
            i.imageDate = '$imageDate'
        ORDER BY
        imageTime
        ASC
    ") or die(mysql_error());
    // populate the imageSelector div with a time selector
    while ($row = mysql_fetch_assoc($result)) { 
        echo "<option>" . $row['cam'] . "</option>";
    }
?>