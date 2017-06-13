<!-- 
This Page is the main Category Edit/Entry HTML. Depending on user operation, 
either updateCategory.php or enterNewCategory.php functionality will be called.
When visited, the user will see all current categories with an "Edit" button for each.
When the "Edit" button is pressed, it will change to a "Hide" button and the category 
will be displayed in a text edit box with an "Update" button below it to commit changes.
The "Hide" button will allow the user to back out of edit mode and will change the "Hide"
button back to an "Edit" button.
There is also a text entry box that is always visible which allows the user to enter new 
categories. A "Submit New Category" button below this text box allows the user to commit
the new category. 
Categories must be unique. User will get an error message on non-unique category submission.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Math Problem Categories</title>
        <!-- Inclusion of my Java Script -->
        <script type="text/javascript" src="mathProbs.js"></script>
        <!-- End my Java Script -->
    </head>
    <body>
        <?php
            /* Page number variable to allow return to the proper page */    
            $page = intval(filter_input(INPUT_GET, "page"));
        
            /* database connection variables */
            $dbhost = "localhost";
            $dbuser = "root";
            $dbpassword = "";
            $dbname = "mathprobdb";
            
            /* Connection string (die on error and present error message) */
            $con = mysql_connect($dbhost, $dbuser, $dbpassword) or die('Could not connect: ' . mysql_error());      

            /* select database (die on error and present error message) */
            mysql_select_db($dbname) or die(mysql_error());
            
            /* Perform query to obtain categories (die on error and present error message) */
            $query="SELECT id, name FROM category";
            $results = mysql_query($query, $con) or die("Could not get data: " . mysql_error()."<p><center><a href=\"math.php\">Home</a></center></p>");

            /* List current categories in a table */
            echo"<center><h2>Problem Categories</h2></center>";
            while($row = mysql_fetch_array($results, MYSQL_ASSOC)){
                echo"<center><table style=\"width:25%\" border=\"1\">";
                	echo "<tr>"
                    	. "<td width=\"10%\"><center><input id =\"edit{$row['id']}\" type=\"button\" onclick=\"showEditField({$row['id']})\" value=\"Edit\"/></center></td>"
                        . "<td width=\"90%\">"
                        	. "<center>{$row['name']}</center>"
                            	/* Initially hidden div containing edit text field/submit button */
                           	. "<div id=\"editInput{$row['id']}\" style=\"display:none\">"
                                . "<form  action=\"updateCategory.php?id={$row['id']}&page={$page}\" method=\"post\">"
                                	. "<center><textarea rows=\"1\" cols=\"44\" name=\"updateVal\">"
                                    	. "{$row['name']}"
                                    . "</textarea></center>"
                                    . "<center>"
                                    	. "<input type=\"submit\" value=\"Update\">"
                                    . "</center>"
                                . "</form>"
                            . "</div>"
                        . "</td>"
                    . "</tr>";
            }
                echo"</table></center>";            
      		echo "<br>"
        	/* Provide method for new categories to be entered */
         	. "<center><form action=\"enterNewCategory.php?page={$page}\" method=\"post\">"
                    . "<input type=\"text\" name=\"newCategory\" size=\"44\" />"
                    . "<br>"
                    . "<input type=\"submit\" value=\"Submit New Category\"/>"
         	. "</form></center>";
            
            /* Allow user to return to calling page */
            if($page > 0){
                /* set next page */
                $page = $page - 1;
                echo "<p><center><a href = \"math.php?page={$page}\">Back To Problems</a></center></p>";
            }
            else{
                echo "<p><center><a href = \"math.php\">Back To Problems</a></center></p>";  
            }
        /* Close database connection */
        mysql_close($con);
        ?>
    </body>
</html>
