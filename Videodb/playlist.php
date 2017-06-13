<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Video Player</title>
    </head>
<body>
<?php

	$dbhost = "localhost";
	$dbuser = "root";
	$dbpassword = "";
	$dbname = "proj23";

	/* Connection string (die on error and present error message) */
	$con = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Could not connect: " . mysql_error());
	/* select database (die on error and present error message) */
	mysql_select_db($dbname) or die(mysql_error());

if(isset($_POST{'limit'})){
    $catVal = mysql_real_escape_string(filter_input(INPUT_POST, 'limit'));
    $_POST = array();
}
else{
    $catVal = NULL;
}
	$vidArr = array();
	$ytIdArr = array();
	$titArr = array();
	$descArr = array();
	$startArr = array();
	$endArr = array();

	/* Query records */
    if($catVal != NULL){
		/* perform query to retreive subset limited by category */
		$query = "SELECT v.videoid, v.youid, v.title, v.description, vc.start, vc.duration FROM videos v, video_concept_map vc where v.videoid=vc.videoid and v.videoid in(select videoid from video_concept_map where conceptid = '$catVal')";
		$result = mysql_query($query, $con) or die("Could not get data: " . mysql_error()."<p><center><a href=\"playlist.php\">Home</a></center></p>");
		$query2 = "SELECT v.videoid, v.youid, v.title, v.description, vc.start, vc.duration FROM videos v, video_concept_map vc where v.videoid=vc.videoid and v.videoid in(select videoid from video_concept_map where conceptid = '$catVal')";
		$result2 = mysql_query($query2, $con) or die("Could not get data: " . mysql_error()."<p><center><a href=\"playlist.php\">Home</a></center></p>");
		if ($result2) {
                    while ($row = mysql_fetch_assoc($result2)) {
                        $vidArr[] = $row['videoid'];
                        $ytIdArr[] = $row['youid'];
                        $titArr[] = $row['title'];
                        $descArr[] = $row['description'];
                        $startArr[] = $row['start'];
                        $endArr[] = ($row['duration'] + $row['start']);
                    }
		}

		/* Build array of start times for retreived playlist */
		$mystart = "[";
		for ($u = 0; $u < count($startArr); $u++) {
                    $mystart = $mystart . $startArr[$u];
                    if ($u < count($startArr) - 1) {
        		$mystart = $mystart . ", ";
                    }
		}
		$mystart = $mystart . "]";

		/* Build array of end times for retreived playlist */
		$myend = "[";
		for ($u = 0; $u < count($endArr); $u++) {
                    $myend = $myend . ($endArr[$u]);
                    if ($u < count($endArr) - 1) {
                        $myend = $myend . ", ";
                    }
		}
		$myend = $myend . "]";

	}

	if($catVal == NULL){
		/* perform query to retreive subset limited by category */
		$query ="SELECT * FROM videos";
		$result = mysql_query($query, $con) or die("Could not get data: " . mysql_error()."<p><center><a href=\"playlist.php\">Home</a></center></p>");
		$query2 = "SELECT * FROM videos";
		$result2 = mysql_query($query2, $con) or die("Could not get data: " . mysql_error()."<p><center><a href=\"playlist.php\">Home</a></center></p>");
		if ($result2) {
                    while ($row = mysql_fetch_assoc($result2)) {
                        $vidArr[] = $row['videoid'];
        		$ytIdArr[] = $row['youid'];
        		$titArr[] = $row['title'];
        		$descArr[] = $row['description'];
                    }
		}
	}

	/* Build array (playlist) containing youtube videoids */
	$myplaylist = "[";
	for ($u = 0; $u < count($ytIdArr); $u++) {
    	$myplaylist = $myplaylist . "'" . $ytIdArr[$u] . "'";
		if ($u < count($ytIdArr) - 1) {
        	$myplaylist = $myplaylist . ", ";
                }
	}
	$myplaylist = $myplaylist . "]";

	echo "<p><center><a href=\"concepts.php\">Edit/Add Concepts</a></center></p>";

    /* Main Video Display Area */
    echo"<center><h2>Video Database Listing</h2></center>";
    /* Each Video displayed as a table */
    while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
        echo "<p>"
		. "<center><table style=\"width:90%\" border=\"1\">"
        	/* Row containing headers */
        	. "<tr>"
            	. "<th>"
                	. "Video ID:"
                . "</th>"
                . "<th>"
                    . "Video:"
                . "</th>"
                . "<th>"
                    . "Concept/Video Association"
                . "</th>"
            ."</tr>"

            /* Row Videos, Video information and Concept/Video Association Cell */
            ."<tr>"
            	/* ID column */
               	. "<td width=\"10%\">"
                	. "<center>{$row['videoid']}</center><br>"
                . "</td>"
                /* Video and information column */
                . "<td width=\"60%\">"
                	. "<center>{$row['title']}: {$row['description']}<br>Youtube Video ID: {$row['youid']} </center><br>"
                    . "<center><iframe width=\"210\" height=\"160\" src=\"https://www.youtube.com/embed/{$row['youid']}\"></iframe></center>"
                . "</td>"
               	/* Concept Mapping dropdown list */
                . "<td width=\"30%\"><center>";
                $conQuery = "select id, name from concepts";
                $conResult = mysql_query($conQuery) or die("Could not get data: " . mysql_error()."<p><center><a href=\"playlist.php\">Home</a></center></p>");
                	echo "<form action=\"conceptlink.php?vidid={$row['videoid']}\" method=\"POST\">"
                    	. "<legend>Choose Concept</legend>"
                        . "<select name=\"concept\" id=\"concept\">"
                        . "<optgroup label = \"Choose Concept\">";
                        while($conRow = mysql_fetch_array($conResult)){
                        	echo"<option value=\"{$conRow['id']}\">{$conRow['name']}</option>";
                        }
                       	echo "</optgroup></select>"
                        ."<br>"
                        . "Concept Start Time (sec): <input name=\"start\" id=\"start\" size=\"15\" />"
                        ."<br>"
                        . "Duration (sec): <input name=\"duration\" id=\"duration\" size=\"15\" />"
                        . "<center>"
                        	. "<input id =\"connect\" type=\"submit\" value=\"Connect\"/>"
                        . "</center>"
 					. "</form>"
 				. "</center></td>"
			. "</tr>"
		. "</table></center>"
        . "</p>";
    }
    echo "<hr/>";
    /* End Main Video Display Area */

    /* Entry Area (Allow New Video Input) */
    echo "<center><h2>Enter New Videos</h2></center>"
    . "<p align=\"left\">"
		. "<form action=\"enterNewVideo.php\" method=\"post\">"
            . "Title: <input name=\"title\" id=\"title\" size=\"128\"/><br>"
            . "Description: <input name=\"description\" id=\"description\" size=\"121\"/><br>"
            . "Youtube ID: <input name=\"youid\" id=\"youid\" size=\"30\" /><br>"
            . "<input type=\"submit\" name=\"submitNew\">"
        . "</form>"
	."</p>";
    /* End Entry Area */
    echo "<hr /><br><center><h2>Select A Lesson</h2></center>";
    	/* Drop down list to limit lesson based upon category */
	$list = "select id, name from concepts";
    $listResult = mysql_query($list) or die("Could not get data: " . mysql_error()."<p><center><a href=\"math.php\">Home</a></center></p>");
    echo "<center>Study By Concept:<br>"
    	. "<form action=\"playlist.php\" method=\"POST\">"
        	. "<select name=\"limit\" id=\"limit\">"
            	. "<option value=\"\">Select A Concept Or Query To Clear Filter</option>";
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
echo"<hr/>" .
    "<center><h2>Selected Lesson</h2></center>" .
    "<center><div id=\"player\"></div></center>" .
    "<br>" .
    "<hr/>" .
        "<script>
            var tag = document.createElement('script');

            tag.src = 'https://www.youtube.com/iframe_api';
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            var playlist = $myplaylist;";
            if($catVal != NULL){
                echo"var start = $mystart;
                var end = $myend;";
            }
            echo"var player;
            function onYouTubeIframeAPIReady(){
                if (playlist.length > 0){
                    player = new YT.Player('player', {
                        height: '390', width: '640',
                        videoId: playlist[0],";
			if($catVal != NULL){
                            echo"playerVars: {start:start[0], end:end[0]},";
			}
			if($catVal == NULL){
                            echo"playerVars: {'autoplay': 0},";
			}                        echo"events: {
                            'onReady': onPlayerReady,
                            'onStateChange': onPlayerStateChange
                        }
                    });
                }
            }

            function onPlayerReady(event) {
            }

            function onPlayerStateChange(event){
                if (event.data == YT.PlayerState.ENDED){
                    if (playlist.length == 0){
                        return;
                    }
                    if (playlist[0] != ''){";
                        if($catVal == NULL){
                            echo"player.loadVideoById(playlist[0]);";
			}
                        else if($catVal != NULL){
                            echo"player.loadVideoById({videoId:playlist[0], startSeconds:start[0], endSeconds:end[0]});";
			}
                echo"}
                }
                if (event.data == 1){
                    playlist = playlist.slice(1, playlist.length);";
                    if($catVal != NULL){
                    echo"start = start.slice(1, start.length);
                    end = end.slice(1, end.length);";
                    }
            echo"}
            }
            function stopVideo() {
                player.stopVideo();
            }
            function pauseVideo() {
                player.pauseVideo();
            }
    </script>";

        /* Concept Entry Page Link */
        echo "<p><center><a href='concepts.php'>Edit/Add Concepts</a></center></p>";

mysql_close($con);
?>
</body>
</html>
