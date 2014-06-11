<?php
// This script is called by a crontab job as root and handles automatic population of the database.
//connect to the server
$con=mysql_connect("localhost", "CFARC", "CFARC1") or die(mysql_error()); 
// Select the correct db
mysql_select_db("CFARC") or die(mysql_error());
//Select the users into a variable
	$result = mysql_query("SELECT * FROM users")or die(mysql_error());
//While loop to init the usernames into seperate variables
	while ($row = mysql_fetch_assoc($result)){
		//usernames
		$clientFromDB = $row['username'];
		//userID's
		$clientFromDBID = $row['userID'];
		//this accesses the file that is created with a crontab job, which grabs all the image files and locations in the file structure ready to manipulate
		$filename="$_SERVER[DOCUMENT_ROOT]/data.file";
		//opens the file in read only mode
		$fh=fopen($filename, "r");
			//This loops through each line of the file and creates an array of the line of string
			while(!feof($fh)){
			$line_of_text=fgets($fh);
			$imageFileNames = array();
			//pushes the line of text into seperate array elements
			array_push($imageFileNames, $line_of_text);
			//this foreach loop then explodes the array elements into further sub elements of the file locations and file names
				foreach ($imageFileNames as $i) {
					//this breaks the string up by /'s for sub folders
					$breakDown=explode("/", $i);
					//this breaks out the client range
					$client=$breakDown[3];
					//this breaks out the camera range
					$cam=$breakDown[4];
					//this breaks out the range of file names 
					$ifileName=$breakDown[5];
					//this takes the previous and breaks out the time range
					$fnBreakDown=explode("_", $ifileName);
					//this takes the previous and breaks out the time range further into eaxct times
					$fnBreakDown1=explode("-", $ifileName);
					//this grabs the elements from the array and allocates them to more variables for further field value generation for the date
					$imgDate=$fnBreakDown[1];
					//this grabs the elements from the array and allocates them to more variables for further field value generation for the time
					$imgTime=$fnBreakDown[2];
					//gets rid of the filename extension as I'm only interested in the name not the extension
					$timeBreak=explode(".", $imgTime);
					//takes the first element of the array
					$recTime=$timeBreak[0];
					//now replaces the -'s from the file name with :'s so it represents a time sensibly
					$recTime=preg_replace("/-/", ":", $recTime);
					}
					//the following checks that a user account with the folder name from above exists and if it does then it populates the database with all the records found 
					// in the file for that user.
					if($client === $clientFromDB){
						$clientID = $clientFromDBID;
						mysql_query("INSERT IGNORE INTO 
									images (
										userID, 
										cam, 
										imageDate, 
										imageTime, 
										imageName
										) 
						VALUES ('$clientID', 
								'$cam', 
								'$imgDate', 
								'$recTime' , 
								'$ifileName'
								)");
					}
			}
		//closes the file
		fclose($fh);
	};
//closes the connection to the database
mysqli_close($con);	
echo "Scrape file";
?>