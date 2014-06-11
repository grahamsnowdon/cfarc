<?php 
//This page just destroys live cookies and redirects the users to the login page
 $past = time() - 3600; 

 //this makes the time in the past to destroy the cookie 

 setcookie(cfarcusr, gone, $past); 

 setcookie(cfarcpass, gone, $past); 

 header("Location: index.php"); 

 ?> 