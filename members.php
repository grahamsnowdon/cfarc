<?php 
//Connects to the Database
include 'connect.php';
//checks cookies to make sure they are logged in 
if(isset($_COOKIE['cfarcusr'])){ 
    $username = $_COOKIE['cfarcusr']; 
    $pass = $_COOKIE['cfarcpass']; 
    $check = mysql_query("SELECT * FROM users WHERE username = '$username'")or die(mysql_error()); 
    //if the cookie has the wrong password, they are taken to the login page 
        while($info = mysql_fetch_array( $check )){ 
                if ($pass != $info['password']){
                    header("Location: login.php"); 
                } 
        //otherwise they are given the interface     
                else{
                    echo "<div id='nav'><a href='logout.php'><button name='lg-logout'>logout</button></a></div>";
                    include 'interface.html.php';
                } 
        } 
} 
//if the cookie does not exist, take user to the login page 
else{            
    header("Location: login.php"); 
}  
?>