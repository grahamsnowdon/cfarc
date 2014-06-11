<?php 

//Connects to the MySQL DB 
include 'connect.php';
//This script runs when the login form is submitted 
if (isset($_POST['lg-submit'])) { // if form has been submitted
	// makes sure they filled it in
	if(!$_POST['username'] | !$_POST['pass']){
 		die('Please check you filled in all required fields.');
	}
  		// checks it against the database
	if (!get_magic_quotes_gpc()){ //This has been included to support legacy PHP versions, 
		//the system doesn't need it as it's running on php 5.5.3-1 however this may not be the case in the future
    	$_POST['email'] = addslashes($_POST['email']);
	}
  $usrlowered = strtolower($_POST['username']);
	$check = mysql_query("SELECT * FROM users WHERE username = '".$usrlowered."'")or die(mysql_error());
	//Gives error if user dosen't exist and provides an email link to the system owner with relevant subject.
	$check2 = mysql_num_rows($check);
		if ($check2 == 0){
			die('That user does not exist in our database. <a href="mailto:anthony@constructfilms.co.uk?subject=Forgotten Password">Forgotten login details?</a>');
		}
		while($info = mysql_fetch_array($check)){
			$_POST['pass'] = stripslashes($_POST['pass']);
			$info['password'] = stripslashes($info['password']);
			$_POST['pass'] = md5($_POST['pass']);
			//Displays an alert if the password is wrong and asks user to try again.
  			if ($_POST['pass'] != $info['password']){
  				$message = "Please check your password and try again";
				echo "<script type='text/javascript'>alert('$message');</script>";
  			}
  		// if login is ok and user is an administrator then adds a cookie and directs them to the admin page
  		elseif ($info['admin'] == '1'){
     		$_POST['username'] = stripslashes($_POST['username']);
        $_POST['username'] = strtolower($_POST['username']);
     		$hour = time() + 3600; 
     		setcookie(cfarcusr, $_POST['username'], $hour); 
     		setcookie(cfarcpass, $_POST['pass'], $hour);
     		header("Location: admin.html.php");
  		}
  		//if the user has had their account archived then an error message is displayed and provides an email link to the system owner with relevant subject.
  		elseif ($info['admin'] == '2'){
  			echo "<br /><br /><br /><br /><br /><br />";
			echo "Sorry that account is disabled, please contact the <a href='mailto:anthony@constructfilms.co.uk?subject=Disabled Account'> System Administrator </a> to re-enable the account" ;
  		}
  		//Finally if all is well we redirect the user to the interface for their account
  		else{ 
     	$_POST['username'] = stripslashes($_POST['username']); 
      $_POST['username'] = strtolower($_POST['username']);
     	$hour = time() + 3600; 
     	setcookie(cfarcusr, $_POST['username'], $hour); 
     	setcookie(cfarcpass, $_POST['pass'], $hour);	 
     	header("Location: members.php"); 
      	} 
	} 
} 
else{	 
 //if they are not logged in we give them the login page
 ?> 
 <!DOCTYPE html>
 <html>
 <head>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="js/vendor/jquery-1.10.2.min.js"></script>
    <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    <script src="js/main.js"></script>
    <!--Stylesheet loaded last to make previous versions of IE work-->
 </head>
 <body>
 	<?php
 	//This script continues from the previous to deal with visit counts, earlier versions were only going to display the privacy policy to new users 
 	//however this has been DEPRECIATED since v0.3.9 and all users are displayed the privacy link.
}
       if (!isset($_COOKIE['countingVisit'])){
           $_COOKIE['countingVisit'] = 0;
       }
       $visits = $_COOKIE['countingVisit'] + 1;
       setcookie('countingVisit', $visits, time() + 3600 * 24 * 1);
      // echo '<div id="cookies">This site uses cookies. By continuing to use this site, you are agreeing to our use of cookies. <a href="privacy.html">Learn More</a></div>';

?>
 	 <div id='mainLogin'> <!--This is the html for the login page, this layout has all been specified in the wireframes given from the client-->
 		<!--<img src='assets/cflogo_small.jpeg' /><!--client's logo -->
 		<h2>Archive login</h2>
       <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> <!--Form to login -->
              <table border="0">
				<tr><td>Project</td>
					<td><input type="text" name="username" value="" maxlength="40"></td></tr> 
			    <tr><td>Password</td>
			    	<td><input type="password" name="pass" value="" maxlength="50"></td></tr>
			    <tr><td class='smlTD' colspan="2" align="right"><!--<a href="mailto:anthony@constructfilms.co.uk?subject=Forgotten Password">Forgotten login details?</a>--></td></tr>
			    <tr><td colspan="2" align="right"><button name="lg-submit" value="Login">Login</button></td></tr>
		      </table>
             <!-- <span class='smlTD'>Go to <a href='http://www.constructfilms.co.uk'>Construct Films main website</a></span><!--As per wireframes -->
       </form>
   </div>

 </body>
 </html>
