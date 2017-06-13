<!-- This is the script to perform inserts of new problems -->
<?php
/* Data from problem entry text box */
$title = mysql_real_escape_string(filter_input(INPUT_POST, 'title'));
$description = mysql_real_escape_string(filter_input(INPUT_POST, 'description'));
$youid = mysql_real_escape_string(filter_input(INPUT_POST, 'youid'));

/* database connection variables */
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "proj23";
            
/* Connection string (die on error and present error message) */
$con = mysql_connect($dbhost, $dbuser, $dbpassword) or die('Could not connect: ' . mysql_error());
      
/* select database (die on error and present error message) */
mysql_select_db($dbname) or die(mysql_error());

/* Insert statement with null pid (auto increment handled) and data from text box */
$sql="INSERT INTO videos (videoid, title, description, youid) VALUES (null, '$title', '$description', '$youid')";

/* Perform insert (die on error and present error message) */
mysql_query($sql) or die (mysql_error()."<p><center><a href=\"playlist.php\">Home</a></center></p>");

/* Allow user to return to calling page */    
header("Location: playlist.php");

mysql_close($con);
