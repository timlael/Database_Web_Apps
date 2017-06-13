<!-- This is the script to perform updates of existing problems -->
<?php

$val = mysql_real_escape_string(filter_input(INPUT_POST, 'updateVal'));
$pid = intval(filter_input(INPUT_GET, 'pid'));
$page = intval(filter_input(INPUT_GET, 'page'));

/* database connection variables */
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "mathprobdb";
            
/* Connection string (die on error and present error message) */
$con = mysql_connect($dbhost, $dbuser, $dbpassword) or die('Could not connect: ' . mysql_error());      

/* select database (die on error and present error message) */
mysql_select_db($dbname) or die(mysql_error());

/* Build update statement */
$sql="update problem set content='$val' where pid=$pid";

/* Perform update (die on error and present error message) */
mysql_query($sql) or die (mysql_error()."<p><center><a href=\"math.php\">Home</a></center></p>");

/* Allow user to return to calling page */
if($page >= 0){
    header("Location: math.php?page={$page}");
}
else{
    header("Location: math.php");
}

mysql_close($con);
