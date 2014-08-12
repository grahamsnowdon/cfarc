<?php
//This script is used to add new users to the database
//Runs when the user clicks submit
if (isset($_POST['submit'])) { 
//Performs validation on the fields to ensure the user hasn't left any blank
    if (!$_POST['username'] | !$_POST['pass'] | !$_POST['pass2'] | !$_POST['email'])
    {
	die('You did not complete all of the required fields');
    }
 //Performs verification on username to make sure it's not already in the database
    if (!get_magic_quotes_gpc())
    {
	$_POST['username'] = addslashes($_POST['username']);
    }
    $usercheck = $_POST['username'];
    $check = mysql_query("SELECT username FROM users WHERE username = '$usercheck'") 
    or die(mysql_error());
    $check2 = mysql_num_rows($check);
    //Throws an error to warn the username exists
    if ($check2 != 0)
    {
        die('Sorry, the username '.$_POST['username'].' is already in use.');
    }
    //Checks the passwords both match
    if ($_POST['pass'] != $_POST['pass2'])
    {
        die('Your passwords did not match. ');
    }
    //This encrypts the passwords using md5 and adds slashes where needed
    $_POST['pass'] = md5($_POST['pass']);
    if (!get_magic_quotes_gpc())
    {
        $_POST['pass'] = addslashes($_POST['pass']);
	$_POST['username'] = addslashes($_POST['username']);
    }
    //Inserts the user details to the users table in the database and directs the admin back to the admin page
    $insert = "INSERT INTO users (username, password, email)
    VALUES ('".$_POST['username']."', '".$_POST['pass']."', '".$_POST['email']."')";
    $add_member = mysql_query($insert);
    $newuser = $_POST['username'];
 header("Location: admin.html.php");
 } 
 else 
 {	
    //This is the start of the else (to display the enter user details form)
 ?>
 <!--This is the form to enter the new user details -->
 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
 <table border="0">
    <tr><td>Username:</td><td><input type="text" name="username" maxlength="60"></td></tr>
    <tr><td>email</td><td><input type="email" name="email" maxlength="255"></td></tr>
    <tr><td>Password:</td><td><input type="password" name="pass" maxlength="10"></td></tr>
    <tr><td>Confirm Password:</td><td><input type="password" name="pass2" maxlength="10"></td></tr>
    <tr><th colspan=2><input type="submit" name="submit" value="add user"></th></tr>
 </table>
 </form>

 <?php
 }
 // Closes the else method
 ?>