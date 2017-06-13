<!--
This is the main entry/problem display page.
At the top, there is a textarea to allow new problems to be entered. 
-->
<!--
Immediately under the textarea, above the "Submit" button, there is a link 
to a LaTeX hint pdf which will display some common LaTeX language constructs.
--> 
<!--
The "Submit" button will perform the insert of the new problem. 
Due to the field length of the provided database, a unique constraint cannot be 
enforced to prevent duplicate problem entries.
-->
<!--    
Directly under the Problem entry textarea and its "Submit" button is a dropdown 
list and "Query" button to allow the user to limit the displayed problems based upon 
category.
-->
<!--
The rest of the page is used for display of the problems themselves in a paginated 
fashion. Each problem occupies its own row with its problem ID and an "Edit"/"Hide" 
button to allow the problem  to be edited. When the "Edit" button is selected, its 
text value changes to "Hide" and the problem text is displayed for editing in a 
textarea that is normally hidden. The "Hide" button allows the user to back out of edit 
mode. To the right of each problem is a third column which uses a dropdown list and a
"Connect" button to allow the user to associate problems with categories.
-->
<!--
At the bottom of the page are pagination links and a link to the "Edit Categories" 
page.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Math Problem Database</title>
    	
	<!-- Inclusion of MathJax for LaTeX rendering -->
        <script type = "text/javascript">
            window.MathJax = {
                tex2jax:{
                    inlineMath: [["\\(", "\\)"]],
                    processEscapes: true
                }
            };
        </script>
        <script type="text/javascript"
            src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
        </script>
    <!-- End LaTeX handling -->
    
	<!-- Inclusion of my Java Script -->
        <script type="text/javascript" src="mathProbs.js"></script>
    <!-- End my Java Script -->
    
	<!-- Inclusion my my styling elements -->
        <style type="text/css">
            dummydeclaration { padding-left: 4em; } /* Firefox ignores first declaration for some reason */
            tab1 { padding-left: 4em; }
            tab2 { padding-left: 8em; }
            tab3 { padding-left: 12em; }
            tab4 { padding-left: 16em; }
            tab5 { padding-left: 20em; }
            tab6 { padding-left: 24em; }
            tab7 { padding-left: 30em; }
            tab8 { padding-left: 32em; }
            tab9 { padding-left: 36em; }
            tab10 { padding-left: 40em; }
            tab11 { padding-left: 44em; }
            tab12 { padding-left: 48em; }
            tab13 { padding-left: 52em; }
            tab14 { padding-left: 56em; }
            tab15 { padding-left: 60em; }
            tab16 { padding-left: 64em; }
        </style>
    <!-- End my styling elements -->
    </head>
    <body>
    <!-- All body HTML is done with php echoing tags 
         Code is all php in body -->
        <?php
/* If no category limitation set(first page visit) , display page with all categories */
        if(!isset($_POST{'limit'})){
            /* database connection variables */
            $dbhost = "localhost";
            $dbuser = "root";
            $dbpassword = "";
            $dbname = "mathprobdb";
            /* Number of records to be displayed on each page */
            $rec_limit = 5;

            /* Connection string (die on error and present error message) */
            $con = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Could not connect: " . mysql_error());      

            /* select database (die on error and present error message) */
            mysql_select_db($dbname) or die(mysql_error());

            /* Perform query to obtain record count (die on error and present error message) */
            $sql = "SELECT count(pid) FROM problem";
            $retval = mysql_query($sql, $con) or die (mysql_error()."<p><center><a href=\"math.php\">Home</a></center></p>");

            /* store record count */
            $row = mysql_fetch_array($retval, MYSQL_NUM);
            $rec_count = $row[0];
         
            /* Process url for page variable */
            /* Page passed w/ url */
            if(isset($_GET{'page'})){
                /* set next page */
                $page = $_GET{'page'} + 1;
                /* calculate and store offset */
                $offset = $rec_limit * $page ;
            }
            /* no page passed (first visit) */
            else{
                /* set page and offset to 0 */
                $page = 0;
                $offset = 0;
            }
           
            /* Query all records limited by pagination */
            $query = "SELECT pid, content FROM problem ORDER BY pid desc LIMIT $offset, $rec_limit";
            /* Calculate and store number of records remaining */
            $left_rec = $rec_count - ($page * $rec_limit);

            /* perform query using offset and limit records (die on error and present error message) */
            $result = mysql_query($query, $con) or die("Could not get data: " . mysql_error()."<p><center><a href=\"math.php\">Home</a></center></p>");
            
    /* Entry Area (Allow New Problem Input) */
            echo "<center>"
            	. "<form action=\"enterNewProblem.php?page={$page}\" method=\"post\">"
                	. "<textarea rows=\"10\" cols=\"100\" name=\"addNew\">"
                    	. "Enter New Math Problems Here..."
                    . "</textarea><br>"
                    . "<center><a href = \"hints.php?page={$page}\">LaTeX Entry Hints</a></center>"
                    . "<input type=\"submit\" name=\"submitNew\">"
                . "</form>";
    /* End Entry Area */
	
	/* Drop down list to limit problems based upon category */                
		 	$list = "select id, name from category";
            $listResult = mysql_query($list) or die("Could not get data: " . mysql_error()."<p><center><a href=\"math.php\">Home</a></center></p>");
            echo "Limit Results By Category:<br>"
            	. "<form action=\"math.php\" method=\"POST\">"
                	. "<select name=\"limit\" id=\"limit\">"
                    	. "<option value=\"\">Select A Category Or Query To Clear Filter</option>";
                    	while($catRow = mysql_fetch_array($listResult)){
                        	echo"<option value=\"{$catRow['id']}\">{$catRow['name']}</option>";
                    	}
              		echo "</select>"
                 	. "<center>"
                    	. "<input id=\"limitQ\" type=\"submit\" value=\"Query\"/>"
               		. "</center>"
               	. "</form>"    
            . "</center>";
    /* End Drop down list */
            
    /* Main Problem Display Area */            
            /* Each Problem displayed as a table */
            while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
            	echo "<p>"
                . "<table style=\"width:100%\" border=\"1\">"
                	/* Row containing headers */ 
                    . "<tr>"
                    	. "<th>"
                    		. "Problem ID:"
                    	. "</th>"
                    	. "<th>"
                    	    . "Problem:"
                    	. "</th>"
                    	. "<th>"
                    	    . "Category Association"
                    	. "</th>"
                    ."</tr>"
                          
                     /* Row containing body of ID and math problems */
                     ."<tr>"
                     	/* ID row with button value controlled via .js */
                     	. "<td width=\"10%\">"
                     		. "<center>{$row['pid']}</center><br>"
                     		. "<center><input id =\"edit{$row['pid']}\" type=\"button\" onclick=\"showEditField({$row['pid']})\" value=\"Edit\"/></center>"
                     	. "</td>"
                             
                        /* Problem text with initially hidden editing controlled via .js*/            
                        . "<td width=\"75%\">"
                        	/* Problem Text */
                        	. "<center>{$row['content']}<br>"
                        	/* Initially hidden div containing edit field/submit button */
                        	. "<div id=\"editInput{$row['pid']}\" style=\"display:none\">"
                        		. "<form  action=\"updateProblem.php?pid={$row['pid']}&page={$page}\" method=\"post\">"
                        			. "<center>"
                        				. "<textarea rows=\"10\" cols=\"100\" name=\"updateVal\">"
                        					. "{$row['content']}"
                        				. "</textarea>"
                        			. "</center>"
                        			. "<center>"
                        				. "<input name\"edit\" type=\"submit\" value=\"Update\">"
                        			. "</center>"
                        		. "</form>"                                             
                        	. "</div>"
                        . "</td>"
						
						/* Categoty Mapping dropdown list */
                        . "<td width=\"15%\"><center>";
                        	$catQuery = "select id, name from category";
                        	$catResult = mysql_query($catQuery) or die("Could not get data: " . mysql_error()."<p><center><a href=\"math.php\">Home</a></center></p>");
                        	echo "<form action=\"link.php?pid={$row['pid']}&page={$page}\" method=\"POST\">"
                        		. "<select name=\"category\" id=\"category\">";
                        		while($catRow = mysql_fetch_array($catResult)){
                        	    	echo"<option value=\"{$catRow['id']}\">{$catRow['name']}</option>";
                        		}
                        		echo "</select>"
                        		. "<center>"
                        			. "<input id =\"connect\" type=\"submit\" value=\"Connect\"/>"
                        		. "</center>"
                        	. "</form>"
                        . "</center></td>"
                    . "</tr>"
                . "</table>"
                . "</p>";
            }
    /* End Main Problem Display Area */
            
    /* Pagination */ 
            if( $page > 0 && $left_rec > $rec_limit) {
                $last = $page - 2;
                echo "<p><tab7></tab7><a href=\"math.php?page={$last}\">Previous Page</a><tab1></tab1>|<tab1></tab1>";
                echo "<a href = \"math.php?page={$page}\">Next Page</a></p>";
                echo "<p><center><a href=\"math.php\">Home</a></center></p>";
            }
            else if($page == 0 && $left_rec > $rec_limit) {
                echo "</p><center><a href=\"math.php?page={$page}\">Next Page</a></center></p>";
                echo "<p><center><a href=\"math.php\">Home</a></center></p>";
            }
            if ($left_rec < $rec_limit && $page > 0) {
                $last = $page - 2;
                echo "<p><center><a href=\"math.php?page={$last}\">Previous Page</a></center></p>";
                echo "<p><center><a href=\"math.php\">Home</a></center></p>";
            }
    /* End Pagination */
            
            /* Category Entry Page Link */
            echo "<p><center><a href=\"categories.php?page={$page}\">Edit Categories</a></center></p>";
            
            /* Cleanup/Close database */
            mysql_close($con);
        }
        
/* Same as above, except on Category Limitation, or Category Clear */
        else{
            /* Category limitiation variable */
            $catVal = mysql_real_escape_string(filter_input(INPUT_POST, 'limit'));

            /* database connection variables */
            $dbhost = "localhost";
            $dbuser = "root";
            $dbpassword = "";
            $dbname = "mathprobdb";
            /* Number of records to be displayed on each page */
            $rec_limit = 5;

            /* Connection string */
            $con = mysql_connect($dbhost, $dbuser, $dbpassword) or die('Could not connect: ' . mysql_error());       

            /* select database */
            mysql_select_db($dbname) or die (mysql_error());

            /* Perform query to obtain record count for selected category*/
            if ($catVal != NULL){
            $sql = "SELECT count(pid) FROM problem where pid in(select problem_id from prob_cat_mapping where category_id=$catVal)";
            $retval = mysql_query($sql, $con) or die (mysql_error()."<p><center><a href=\"math.php\">Home</a></center></p>");
            }
			/* Perform query to obtain record count */
            else{
            $sql = "SELECT count(pid) FROM problem";
            $retval = mysql_query($sql, $con) or die (mysql_error()."<p><center><a href=\"math.php\">Home</a></center></p>");               
            }

            /* store record count */
            $row = mysql_fetch_array($retval, MYSQL_NUM);
            $rec_count = $row[0];
         
            /* Process url for page variable */
            /* Page passed w/ url */
            if(isset($_GET{'page'})){
                /* set next page */
                $page = $_GET{'page'} + 1;
                /* calculate and store offset */
                $offset = $rec_limit * $page ;
            }
            /* no page passed (first visit) */
            else{
                /* set page and offset to 0 */
                $page = 0;
                $offset = 0;
            }
           
            if($catVal != NULL){
            /* Query all records limited by pagination  and category id*/
            $query = "SELECT pid, content FROM problem where pid in(select problem_id from prob_cat_mapping where category_id=$catVal) ORDER BY pid desc";
            /* Calculate and store number of records remaining */
            $left_rec = $rec_count - ($page * $rec_limit);
            /* perform query using offset and limit records */
            $result = mysql_query($query, $con) or die("Could not get data: " . mysql_error()."<p><center><a href=\"math.php\">Home</a></center></p>");
            $page = $left_rec = $rec_count = 0;
            }
            else{
            /* Query all records limited by pagination */
            $query = "SELECT pid, content FROM problem ORDER BY pid desc LIMIT $offset, $rec_limit";
            /* Calculate and store number of records remaining */
            $left_rec = $rec_count - ($page * $rec_limit);
            /* perform query using offset and limit records */
            $result = mysql_query($query, $con) or die("Could not get data: " . mysql_error()."<p><center><a href=\"math.php\">Home</a></center></p>");
            }
            
            /* Entry Area (Allow New Problem Input) */
            echo "<center>"
            	. "<form action=\"enterNewProblem.php\" method=\"post\">"
            	    . "<textarea rows=\"10\" cols=\"100\" name=\"addNew\">"
            	        . "Enter New Math Problems Here..."
            	    . "</textarea><br>"
            	    . "<center><a href = \"hints.php?page={$page}\">LaTeX Entry Hints</a></center>"
            	    . "<input type=\"submit\" name=\"submitNew\">"
            	. "</form>";
            	
            	/* Allow category selection for display */
            	$list = "select id, name from category";
            	$listResult = mysql_query($list) or die("Could not get data: " . mysql_error()."<p><center><a href=\"math.php\">Home</a></center></p>");
            	echo "Limit Results By Category:<br>"
            	. "<form action=\"math.php\" method=\"POST\">"
            		. "<select name=\"limit\" id=\"limit\">"
            			. "<option value=\"\">Select A Category Or Query To Clear Filter</option>";
            			while($catRow = mysql_fetch_array($listResult)){
            				echo"<option value=\"{$catRow['id']}\">{$catRow['name']}</option>";
            			}
            		echo "</select>"
            		. "<center>"
            			. "<input id=\"limitQ\" type=\"submit\" value=\"Query\"/>"
            		. "</center>"
            	. "</form>"    
            . "</center>";
            /* End Entry Area */
            
            /* Main Problem Display Area */            
            /* Each Problem displayed as a table */
            while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
            echo "<p>"
            	. "<table style=\"width:100%\" border=\"1\">"
            		/* Row containing headers */ 
            		. "<tr>"
            			. "<th>"
            				. "Problem ID:"
            			. "</th>"
            			. "<th>"
            				. "Problem:"
            			. "</th>"
            			. "<th>"
            				. "Category Association"
            			. "</th>"
            		."</tr>"
            		 
            		 /* Row containing body of ID and math problems */
            		."<tr>"
            			/* ID row with button value controlled via .js */
            			. "<td width=\"10%\">"
            				. "<center>{$row['pid']}</center><br>"
            				. "<center><input id =\"edit{$row['pid']}\" type=\"button\" onclick=\"showEditField({$row['pid']})\" value=\"Edit\"/></center>"
            			. "</td>"
            			
            			/* Problem text with initially hidden editing controlled via .js*/            
            			. "<td width=\"90%\">"
            			    /* Problem Text */
            			    . "<center>{$row['content']}<br>"
            			    /* Initially hidden div containing edit field/submit button */
            			    . "<div id=\"editInput{$row['pid']}\" style=\"display:none\">"
            			    	. "<form  action=\"updateProblem.php?pid={$row['pid']}&page={$page}\" method=\"post\">"
            			    		. "<center>"
            			    			. "<textarea rows=\"10\" cols=\"100\" name=\"updateVal\">"
            			    				. "{$row['content']}"
            			    			. "</textarea>"
            			    		. "</center>"
            			    		. "<center>"
            			    			. "<input name\"edit\" type=\"submit\" value=\"Update\">"
            			    		. "</center>"
            			    	. "</form>"                                             
            			    . "</div>"
            			. "</td>"
            			. "<td>";
            				$catQuery = "select id, name from category";
            				$catResult = mysql_query($catQuery) or die("Could not get data: " . mysql_error() ."<p><center><a href=\"math.php\">Home</a></center></p>");
            				echo "<form action=\"link.php?pid={$row['pid']}&page={$page}\" method=\"POST\">"
            					. "<select name=\"category\" id=\"category\">";
            						while($catRow = mysql_fetch_array($catResult)){
            							echo"<option value=\"{$catRow['id']}\">{$catRow['name']}</option>";
            						}
            					echo "</select>"
            					. "<center>"
            						. "<input id =\"connect\" type=\"submit\" value=\"Connect\"/>"
            					. "</center>"
            				. "</form>"
            			. "</td>"
            		. "</tr>"
            	. "</table>"
            . "</p>";
            }
            /* End Main Problem Display Area */
            
            /* Pagination */ 
            if( $page > 0 && $left_rec > $rec_limit) {
                $last = $page - 2;
                echo "<p><tab7></tab7><a href=\"math.php?page={$last}\">Previous Page</a><tab1></tab1>|<tab1></tab1>";
                echo "<a href = \"math.php?page={$page}\">Next Page</a></p>";
                echo "<p><center><a href=\"math.php\">Home</a></center></p>";
            }
            else if($page == 0 && $left_rec > $rec_limit) {
                echo "</p><center><a href=\"math.php?page={$page}\">Next Page</a></center></p>";
                echo "<p><center><a href=\"math.php\">Home</a></center></p>";
            }
            if ($left_rec < $rec_limit && $page > 0) {
                $last = $page - 2;
                echo "<p><center><a href=\"math.php?page={$last}\">Previous Page</a></center></p>";
                echo "<p><center><a href=\"math.php\">Home</a></center></p>";
            }
            if ($catVal != NULL){
                echo "<p><center><a href=\"math.php\">Home</a></center></p>";
            }
            /* End Pagination */
            
            /* Category Entry Page Link */
            echo "<p><center><a href=\"categories.php?page={$page}\">Edit Categories</a></center></p>";
            
            /* Cleanup/Close database */
            mysql_close($con);    
        }
        ?>
    </body>
</html>
