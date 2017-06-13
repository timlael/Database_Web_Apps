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
$catId = mysql_real_escape_string(filter_input(INPUT_POST, 'category'));
$pid = intval(filter_input(INPUT_GET, 'pid'));

/* Page number to drop user back where they came from */
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

/* Insert statement with null id (auto increment handled) and pid and catId from calling form */
$sql = "INSERT INTO prob_cat_mapping (id, problem_id, category_id) VALUES (null, $pid, $catId)";

/* Perform insert (die on error and present error message) */
mysql_query($sql) or die (mysql_error()."<p><center><a href=\"math.php\">Home</a></center></p>");

/* Allow user to return to calling page */
if($page > 0){
    /* set next page */
    $page = $page - 1;
    header("Location: math.php?page={$page}");
}
else{
    header("Location: math.php");
} 

mysql_close($con);