<?php
// This page is used to handle the users, it displays all users including admin and archived users

//first a connection to the database is created by calling the connect.php script 
include 'connect.php';

?>
<!DOCTYPE>
<!-- This page is still ugly and rough, this page will require further development in the next version-->
<html>
    <head>
        <title>Admin Page</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div>
            <h3>List of users</h3>
            <table>
                <!--This table displays the users and relevant information about them-->
                <thead>
                    <tr>
                        <td>userID</td><td>User</td><td>email</td><td>Type (0 = standard 1 = admin 2 = archive)</td><td>Archive</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //Select query to populate the table with users
                    $allUsers = mysql_query("SELECT * FROM users")or die(mysql_error());
                        while($info = mysql_fetch_array($allUsers)) 
                        {
                            $dbUser =  $info['username'];
                            $dbAdmin = $info['admin'];
                            $dbEmail = $info['email'];
                            $dbID = $info['userID'];
                            echo "<tr><td>$dbID</td><td>$dbUser</td><td>$dbEmail</td><td>$dbAdmin</td><td><input type=\"checkbox\" name=\"archive\"></td></tr>";
                        } ?>
                    </tr>
                </tbody>
            </table>
            <?php
            // Still need to fix the following so that the admin user can archive off customers using a nice interface rather than using phpmyadmin
            
            $allUsers = mysql_query("SELECT * FROM users")or die(mysql_error());
            if (isset($_POST['saveChanges']))
            {
                if(isset($_POST['archive']))
                {
                    $dbID = $info['userID'];
                    $selArch = $_POST['archive'];
                    $allUsers = mysql_query("UPDATE admin FROM users WHERE userID = '" .$dbID."'")or die(mysql_error());
                }
                else
                {
                    echo "No user selected";
                }
            }
                ?>
            <input type="submit" name="saveChanges" value="Save Changes">
        </div>
        <div>
            <h3>Add user</h3>
            <!-- Include the add user page(single admin portal) -->
            <?php include 'add.php'; ?>
        </div>
    </body>
</html>