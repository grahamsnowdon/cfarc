<?php
//This is the script to connect the database displays error on fail.
 mysql_connect("localhost", "CFARC", "CFARC1") or die(mysql_error()); 
 mysql_select_db("CFARC") or die(mysql_error());
