<!-- 
This is the script to perform updates of existing categories 
Categories must be unique or the user will get an error
-->
<?php
/* Data from category entry text box */
$val = mysql_real_escape_string(filter_input(INPUT_POST, 'updateVal'));
/* Category id fetched from url to build update statement */
$id = intval(filter_input(INPUT_GET, 'id'));
/* Page fetched from url to drop the user back to where they came from */
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
$sql="update category set name='$val' where id=$id";

/* Perform update (die on error and present error message) */
mysql_query($sql) or die (mysql_error()."<p><center><a href=\"math.php\">Home</a></center></p>");

/* Allow user to return to calling page */
if($page >= 0){
    header("Location: categories.php?page={$page}");
}
else{
    header("Location: categories.php");
}

mysql_close($con);
