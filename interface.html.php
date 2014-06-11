<!DOCTYPE html>
<!--This page is the main body of the interface -->
<html>
<head>
	<title>Construct Films - Interface</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="js/vendor/modernizr-2.6.2.min.js"></script>
</head>
<body>
	<div id='usrSelection'>
        <!--This is the main user selection div -->
        <form id="timeSel">
            <!--This is the user selection form -->
            <label><?php  echo "<strong>" . $username . "</strong>"; //display the username as per wireframes from client?></label>
			<input id="imageDate" name="imageDate" type="text" placeholder="YYYY/MM/DD"><!-- The placeholder to assist none chrome users -->
            <select name="cfCam" id="cam"></select><!--The camera selector -->
            <select name="cfTime" id="selTime"></select><!--The time selector -->
            <span id='message'></span><!--A message to assist users in the process -->
            <div id='dateRange'></div><!--Not yet in use, the user will eventually see the first date on the contract here -->
        </form>
    </div>
    <div id="imgDisplay">
        <!--This is the containing div for the displayed image -->
        <img id='output' class='output'/><!--The image itself -->
    </div>
    <!--jQuery script references at the end of the page so all is ran after the DOM is loaded -->
    <script src="js/vendor/jquery-1.10.2.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="js/main.js"></script>
     <!--Placing this here has fixed IE rendering problems with the page loading incorrectly in IE -->
</body>
</html>