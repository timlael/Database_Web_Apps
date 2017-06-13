<!-- 
This script inserts associations into the prob_cat_mapping table 
Associations must be unique or the user will get an error.
Problems can be associated with any number of categories as long
as the unique key is not violated.
-->
<?php
/* 
category id posted from form and pid fetched from url 
Together they are used for building insert statement.
*/
$concept = mysql_real_escape_string(filter_input(INPUT_POST, 'concept'));
$start = mysql_real_escape_string(filter_input(INPUT_POST, 'start'));
$duration = mysql_real_escape_string(filter_input(INPUT_POST, 'duration'));
$vidid = intval(filter_input(INPUT_GET, 'vidid')); 


/* database connection variables */
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "proj23";
            
/* Connection string (die on error and present error message) */
$con = mysql_connect($dbhost, $dbuser, $dbpassword) or die('Could not connect: ' . mysql_error());
      
/* select database (die on error and present error message) */
mysql_select_db($dbname) or die(mysql_error());

/* Insert statement with null id (auto increment handled) and pid and catId from calling form */
$sql = "INSERT INTO video_concept_map (id, videoid, conceptid, start, duration) VALUES (null, $vidid, $concept, $start, $duration)";

/* Perform insert (die on error and present error message) */
mysql_query($sql) or die (mysql_error()."<p><center><a href=\"playlist.php\">Home</a></center></p>");

/* Allow user to return to calling page */
header("Location: playlist.php"); 

mysql_close($con);