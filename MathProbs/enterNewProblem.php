<!-- This is the script to perform inserts of new problems -->
<?php
/* Page number to drop user back where they came from */
$page = intval(filter_input(INPUT_GET, 'page'));
/* Data from problem entry text box */
$val = mysql_real_escape_string(filter_input(INPUT_POST, 'addNew'));

/* database connection variables */
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "mathprobdb";
            
/* Connection string (die on error and present error message) */
$con = mysql_connect($dbhost, $dbuser, $dbpassword) or die('Could not connect: ' . mysql_error());
      
/* select database (die on error and present error message) */
mysql_select_db($dbname) or die(mysql_error());

/* Insert statement with null pid (auto increment handled) and data from text box */
$sql="INSERT INTO problem (pid, content) VALUES (null, '$val')";

/* Perform insert (die on error and present error message) */
mysql_query($sql) or die (mysql_error()."<p><center><a href=\"math.php\">Home</a></center></p>");

/* Allow user to return to calling page */
if($page >= 0){
    header("Location: math.php?page={$page}");
}
else{
    header("Location: math.php");
}

mysql_close($con);
