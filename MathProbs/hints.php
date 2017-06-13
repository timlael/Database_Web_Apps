<!-- This script displays some of LaTeX's constructs to assist the user with entry -->
<?php
/* Page number to drop user back where they came from */
$page = intval(filter_input(INPUT_GET, 'page'));
if ($page > 0){
    $page = $page - 1;
}

/* Allow user to return to calling page displayed at the top of the inline pdf */
if($page >= 0){
    echo "<p><center><a href = \"math.php?page={$page}\">Back To Problems</a></center></p>";
}
else{
    echo "<p><center><a href=\"math.php\">Back To Problems</a></center></p>";  
}

/* Display the pdf inline */
echo "<iframe src=\"Symbols.pdf\" width=\"100%\" style=\"height:100%\"></iframe>";

/* Allow user to return to calling page displayed at the bottom of the inline pdf */
if($page >= 0){
    echo "<p><center><a href = \"math.php?page={$page}\">Back To Problems</a></center></p>";
}
else{
    echo "<p><center><a href = \"math.php\">Back To Problems</a></center></p>";  
}