<?php

//error_reporting(E_ALL); //Error settings
//ini_set('display_errors', '1');



$server="sql1.njit.edu"; //Set up a connection
$user = "ss2563";
$pass = "3XLprl2A2";

$conn = mysql_connect($server,$user,$pass);
if(!$conn) die('Could not connect: ' . mysql_error());
mysql_select_db('ss2563') or die("didnt select database");



function AddQuestion($data) //instructor adds question
{
	$conn = getConn();
	$type = $data->type;
	
	if($type == 'MC')      					$query="INSERT INTO cs490q$type VALUES('', '$data->author', '$data->question', '$data->answer', '$data->a', '$data->b', '$data->c', '$data->d', '$data->e');";
	else if($type == 'TF' || $type == 'FB') $query="INSERT INTO cs490q$type VALUES('', '$data->author', '$data->question', '$data->answer');";
	else									$query="INSERT INTO cs490q$type VALUES('', '$data->author', '$data->question');";
	mysql_query($query, $conn);
}

function CloseTest($data) //instructor closes exam
{
	$conn = getConn();
	
	$sql = "UPDATE cs490test 
			SET closed = '1'  
			WHERE tid = '".$data->tid."';";
	
	echo $sql;
	
	mysql_query($sql, $conn);
}

function CreateTest($data) //instructor makes exam
{
	$conn = getConn();
	$sql = "INSERT INTO cs490test VALUES('','".$data->id."','".$data->testName."','0','".$data->minutes."');";
	$sql_result = mysql_query($sql, $conn);
	$sql = "SELECT cs490test.tid FROM cs490test WHERE cs490test.uid = \"".$data->id."\" AND cs490test.testName = \"".$data->testName."\";";
	$sql_result = mysql_query($sql, $conn);
	$tid = mysql_fetch_assoc($sql_result)['tid'];
	
	
	
	foreach ($data->MC as &$mc)
	{
		$sql = "INSERT INTO cs490testbank VALUES('','".$tid."','".$mc."','MC','4.00');";
		$sql_result = mysql_query($sql, $conn);
	}
	
	foreach ($data->TF as &$tf)
	{
		$sql = "INSERT INTO cs490testbank VALUES('','".$tid."','".$tf."','TF','3.00');";
		$sql_result = mysql_query($sql, $conn);
	}
	
	foreach ($data->FB as &$fb)
	{
		$sql = "INSERT INTO cs490testbank VALUES('','".$tid."','".$fb."','FB','8.00');";
		$sql_result = mysql_query($sql, $conn);
	}
	
	foreach ($data->OE as &$oe)
	{
		$sql = "INSERT INTO cs490testbank VALUES('','".$tid."','".$oe."','OE','25.00');";
		$sql_result = mysql_query($sql, $conn);
	}

	echo 'running';
}

function FetchQuestions($data, $instructor) //instructor get questions
{
	$conn = getConn();
	$sql = 'SELECT *
			FROM cs490q'.$data->type.' '.
			'WHERE cs490q'.$data->type.'.uid = "'.$data->author.'";';
	
	$sql_result = mysql_query($sql, $conn);
	
	return sql2json($sql_result, $instructor);
}

function FetchTests($data) //instructor fetch exams
{
	$conn = getConn();

	$sql = "SELECT *
			FROM cs490test
			WHERE uid = '".$data->uid."'
			AND closed = '0';";
	
	$sql_result = mysql_query($sql, $conn);
	
	return sql2json($sql_result, $instructor);
}

function FetchTestQuestions($data, $instructor) //student get questions
{
	$conn = getConn();

	//find if the test is open, if not return immediately
	$sql = "SELECT *
			FROM  cs490test
			WHERE cs490test.tid = '".$data->tid."' AND cs490test.closed = '0';";
	
	$sql_result = mysql_query($sql, $conn);
	
	if(mysql_fetch_assoc($sql_result) === false) return "[]"; //test is closed
	
	
	
	//find if the student can take the test, if not return immediately
	$now = date_create();
	$timeStamp = $now->getTimestamp();
	$sql = "SELECT *
			FROM  cs490testgrade
			WHERE (cs490testgrade.submitTime > '0' OR cs490testgrade.closeTime < '".$timeStamp."')
					AND cs490testgrade.tid = '".$data->tid."'
					AND cs490testgrade.uid = '".$data->uid."';";
	
	$sql_result = mysql_query($sql, $conn);

	if(mysql_fetch_assoc($sql_result) !== false) return "[]"; //test is closed

	
	
	//find if the student already has a test grade in the database for the test
	$sql = "SELECT *
			FROM  cs490testgrade
			WHERE cs490testgrade.uid = '".$data->uid."' AND cs490testgrade.tid = '".$data->tid."';";

	$sql_result = mysql_query($sql, $conn);

	if($instructor === false && mysql_fetch_assoc($sql_result) === false)
	{
		//find the minutes allowed to take the test
		$sql = "SELECT * 
			FROM  cs490test
			WHERE cs490test.tid = '".$data->tid."';";

		$sql_result = mysql_query($sql, $conn);
	
		$now = date_create();
		$closeTime = $now->getTimestamp() + 60*mysql_fetch_assoc($sql_result)['minutes'];
		//Create a student grade in the database with an appropriate closeTime
		$sql = "INSERT INTO cs490testgrade VALUES ('','".$data->uid."','".$data->tid."','0','','".$closeTime."');";
		$sql_result = mysql_query($sql, $conn);
	}
	
	//Load all questions and return them to the student.
	$sql =  'SELECT * '.
			'FROM cs490q'.$data->type.', cs490testbank '.
			'WHERE cs490q'.$data->type.'.fid = cs490testbank.fid '. 
			'AND cs490testbank.tid = "'.$data->tid.'" AND cs490testbank.type = "'.$data->type.'";';
	
	$sql_result = mysql_query($sql, $conn);

	return sql2json($sql_result, $instructor);
}

function getConn() //getting a SQL connection to access database //Make this a singleton like object that uses isset()
{
	global $conn;
	return $conn;
}

function GetGradeID($uid, $tid)
{
	$conn = getConn();

	$sql = "SELECT cs490testgrade.gid
			FROM cs490testgrade
			WHERE 
				  cs490testgrade.uid = \"$uid\" AND
				  cs490testgrade.tid = \"$tid\";";
	
	$sql_result = mysql_query( $sql, $conn);		  
	
	if(!$sql_result) die('Could not get data: ' . mysql_error());
	
	return mysql_fetch_assoc($sql_result)['gid'];
}

function Login($data) //student/instructor login
{
	$conn = getConn();

	$sql = 'SELECT cs490users.uid, cs490users.type, cs490users.username
			FROM cs490users, cs490pass
			WHERE cs490users.uid = cs490pass.uid AND
				  cs490pass.password = "'.$data->pass.'" AND
				  cs490users.username = "'.$data->user.'";';
	
	$sql_result = mysql_query( $sql, $conn);		  
	
	if(! $sql_result) die('Could not get data: ' . mysql_error());

	$encoded = sql2json($sql_result, true);

	return $encoded;
}

function SelectGrades($data)
{
	$conn = getConn();
	
	$star = "t.tid, t.uid, t.testName, t.closed, t.minutes, tg.gid, tg.grade, tg.submitTime, tg.closeTime"; //all but tg.tid and tg.uid which are repeats
	
	$sql = "SELECT * FROM
			(SELECT $star FROM cs490test AS t
				LEFT  OUTER JOIN cs490testgrade AS tg ON t.tid = tg.tid
					AND tg.uid = ".$data->uid." 
			UNION
			SELECT $star FROM cs490test AS t
				RIGHT OUTER JOIN cs490testgrade AS tg ON t.tid = tg.tid
					AND tg.uid = ".$data->uid." 
			WHERE t.tid IS NOT NULL) AS joined
				WHERE joined.closed = 1
					AND joined.submitTime <> 0;";
			
	//echo $sql;
	
	$sql_result = mysql_query( $sql, $conn);	
	
	return sql2json($sql_result, true);
}

function SelectGrade($data)
{
	//(cs490testbank join cs490qMC) join cs490qStored
	
	//{ [(fid / type) join (actual question)] join [user response to question] }
	
	//This is olympian-ultra-mega-god-psychedelic-super-hyper-mega-tier query
	
	$conn = getConn();
	$gid = GetGradeID($data->uid, $data->tid);
	
	$join = "OUTER JOIN cs490testbank AS tb ON tb.fid = qXX.fid 
				AND tb.tid = ".$data->tid." AND 
				tb.type = '".$data->type."'";
	
	$star1 = "qXX.question,";
	
	if($data->type != "OE") $star1 .= "qXX.answer,";
	if($data->type == "MC") $star1 .= "qXX.a,";
	if($data->type == "MC") $star1 .= "qXX.b,";
	if($data->type == "MC") $star1 .= "qXX.c,";
	if($data->type == "MC") $star1 .= "qXX.d,";
	if($data->type == "MC") $star1 .= "qXX.e,";
	
	$star1 .= "tb.qid, tb.tid, tb.fid, tb.type, tb.points";
	
	$joined =  "(SELECT * FROM (SELECT $star1 FROM cs490q".$data->type." AS qXX
					LEFT  $join 
				UNION 
				SELECT $star1 FROM cs490q".$data->type." AS qXX
					RIGHT $join 
				WHERE qXX.question IS NOT NULL) AS temp
				WHERE temp.qid IS NOT NULL) AS joined";
	
	$star2 = "joined.question,";
	
	if($data->type != "OE") $star2 .= "joined.answer,";
	if($data->type == "MC") $star2 .= "joined.a,";
	if($data->type == "MC") $star2 .= "joined.b,";
	if($data->type == "MC") $star2 .= "joined.c,";
	if($data->type == "MC") $star2 .= "joined.d,";
	if($data->type == "MC") $star2 .= "joined.e,";
	
	$star2 .= "joined.qid, joined.tid, joined.fid, joined.type, joined.points,";
	
	$star2 .= "qS.response";
	
	$sql = "SELECT $star2 FROM $joined 
				LEFT  OUTER JOIN cs490qStored AS qS ON joined.qid = qS.qid 
					AND qS.gid = ".$gid." 
			UNION 
			SELECT $star2 FROM $joined 
				RIGHT OUTER JOIN cs490qStored AS qS ON joined.qid = qS.qid 
					AND qS.gid = ".$gid." 
			WHERE joined.question IS NOT NULL;";
	
	//echo $sql;
	
	$sql_result = mysql_query($sql, $conn);
			
	return sql2json($sql_result, true);
}

function SelectTests($data)
{
	$conn = getConn();
	
	$now = date_create();
	$timeStamp = $now->getTimestamp();
	
	//god-tier join function in SQL
	$sql = "SELECT cs490test.tid, cs490test.testName, cs490test.closed, cs490test.minutes
			FROM cs490test
				LEFT JOIN cs490testgrade ON cs490test.tid = cs490testgrade.tid
					AND cs490testgrade.uid = '".$data->uid."'
			WHERE   cs490testgrade.submitTime IS NULL OR
					(cs490testgrade.submitTime = '0' AND
					cs490testgrade.closeTime > '".$timeStamp."' AND 
					cs490test.closed = '0');";
	
	$sql_result = mysql_query( $sql, $conn);		  
	
	
	
	if(! $sql_result ) die('Could not get data: ' . mysql_error());

	$encoded = sql2json($sql_result, true);

	return $encoded;
}

function sql2json($data_sql, $instructor) //turns sql data to json
{
    $json_str = ""; //Init the JSON string.

    if($total = mysql_num_rows($data_sql)) //See if there is anything in the query
	{
        $json_str .= "[\n";

        $row_count = 0;
        while($row = mysql_fetch_assoc($data_sql))
		{
            if(count($row) > 1) $json_str .= "{\n";

            $count = 0;
            foreach($row as $key => $value)
			{
				$count++;
                //If it is an associative array we want it in the format of "key":"value"
				if($instructor || !($key == "uid" || $key == "answer"))
				{
					if(count($row) > 1) $json_str .= "\"$key\":\"$value\"";
					else $json_str .= "\"$value\"";

					//Make sure that the last item don't have a ',' (comma)
					if($count < count($row)) $json_str .= ",\n";
				}
            }
            $row_count++;
            if(count($row) > 1) $json_str .= "}\n";

            //Make sure that the last item don't have a ',' (comma)
            if($row_count < $total) $json_str .= ",\n";
        }

        $json_str .= "]\n";
    }

    //Replace the '\n's - make it faster - but at the price of bad readability.
    $json_str = str_replace("\n","",$json_str); //Comment this out when you are debugging the script
	
    //Finally, output the data
    return $json_str;
}

function StoreQuestions($data) //TODO: fix
{
	$conn = getConn();

	$gid = GetGradeID($data->uid, $data->tid);
	
	foreach ($data->MC as &$mc)
	{
		$sql = "INSERT INTO cs490qStored VALUES ('','".$gid."','".$mc->qid."','".$mc->answer."');";
		$sql_result = mysql_query($sql, $conn);
		if (!$sql_result) echo mysql_error()."!";
	}
	foreach ($data->TF as &$tf)
	{
		$sql = "INSERT INTO cs490qStored VALUES ('','".$gid."','".$tf->qid."','".$tf->answer."');";
		$sql_result = mysql_query($sql, $conn);
		if (!$sql_result) echo mysql_error()."!";
	}
	foreach ($data->FB as &$fb)
	{
		$sql = "INSERT INTO cs490qStored VALUES ('','".$gid."','".$fb->qid."','".$fb->answer."');";
		$sql_result = mysql_query($sql, $conn);
		if (!$sql_result) echo mysql_error()."!";
	}
	foreach ($data->OE as &$oe)
	{
		$sql = "INSERT INTO cs490qStored VALUES ('','".$gid."','".$oe->qid."','".$oe->answer."');";
		$sql_result = mysql_query($sql, $conn);
		if (!$sql_result) echo mysql_error()."!";
	}
}

function SubmitGrade($data) //student submit test for grading //TODO
{
	$conn = getConn();

	$now = date_create();
	$timeStamp = $now->getTimestamp();
	$sql = "UPDATE cs490testgrade 
			SET submitTime = '".$timeStamp."', grade = '".$data->grade."' 
			WHERE uid = '".$data->uid."' AND tid = '".$data->tid."' 
			AND cs490testgrade.closeTime > '".$timeStamp."' 
			AND cs490testgrade.submitTime = '0';";
	 
	$sql_result = mysql_query($sql, $conn);
	
	echo $sql;
}
?>