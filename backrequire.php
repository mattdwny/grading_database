<?php

function getUser($conn, $name){

	$sql = "SELECT cs490users.uid FROM cs490users
				WHERE cs490users.username = \"$name\"";

	$sql_result = mysql_fetch_assoc(mysql_query( $sql, $conn ));
	return $sql_result['uid'];
}

function AddMCQuestion($conn, $author, $question, $answer, $a, $b, $c, $d, $e){
	//INSERT INTO cs490qmc VALUES('',2, "who am i", "B", "matt", "suel", "dylan", "nicholson", "gehani");
	$query="INSERT INTO cs490qmc VALUES('', '$author', '$question', '$answer', '$a', '$b', '$c', '$d', '$e');";
	mysql_query( $query, $conn );
}

function AddTFQuestion($conn, $author, $question, $answer){
	$query="INSERT INTO cs490qtf VALUES('', '$author', '$question', '$answer');";
	mysql_query( $query, $conn );
}

function AddOEQuestion($conn, $author, $question){
	$query="INSERT INTO cs490qopen VALUES('', '$author', '$question');";
	mysql_query( $query, $conn );
}

function AddFBQuestion($conn, $author, $question, $answer){
	$query="INSERT INTO cs490qfillin VALUES('', '$author', '$question', '$answer');";
	mysql_query( $query, $conn );
}

function fetchQuestions($conn, $author, $type)
{
	$arr=array();
	if ($type == "MC")
	{
		$sql = "SELECT cs490qmc.fid, cs490qmc.question, cs490qmc.answer,
					   cs490qmc.a, cs490qmc.b, cs490qmc.c, cs490qmc.d, cs490qmc.e
				FROM cs490qmc
				WHERE cs490qmc.uid = \"$author\";";
	
		/*while ($row = mysql_fetch_assoc($sql_result)) {
			$temp = array(	'id'=>$row['fid'],
							'question'=>$row['question'],
							'answer'=>$row['answer'],
							'a'=>$row['a'],
							'b'=>$row['b'],
							'c'=>$row['c'],
							'd'=>$row['d'],
							'e'=>$row['e'] );
			array_push($arr, $temp);
		}*/
	}
	else if ($type == "TF")
	{
		$sql = "SELECT cs490qtf.fid, cs490qtf.question, cs490qtf.answer
				FROM cs490qtf
				WHERE cs490qtf.uid = \"$author\";";
	}
	else if ($type == "FB")
	{
		$sql = "SELECT cs490qfillin.fid, cs490qfillin.question, cs490qfillin.answer
				FROM cs490qfillin
				WHERE cs490qfillin.uid = \"$author\";";
	}
	else if ($type == "OE")
	{
		$sql = "SELECT cs490qopen.fid, cs490qopen.question
				FROM cs490qopen
				WHERE cs490qopen.uid = \"$author\";";
	}
	
	$sql_result = mysql_query($sql, $conn);
	

	/*$arr = mysql_fetch_assoc($sql_result);
	while ($row = mysql_fetch_assoc($sql_result)) {
			array_push($arr, $row);
	}*/

	return sql2json($sql_result);
}



function retConn(){
	$server="sql.njit.edu";
	$user = "ss2563";
	$pass = "3XLprl2A2";

	$conn = mysql_connect($server,$user,$pass);

	if(! $conn )
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('ss2563') or die("didnt select database");

	return $conn;
}


function sql2json($data_sql) {
    $json_str = ""; //Init the JSON string.

    if($total = mysql_num_rows($data_sql)) { //See if there is anything in the query
        $json_str .= "[\n";

        $row_count = 0;    
        while($row = mysql_fetch_assoc($data_sql)) {
            //if(count($row) > 1) $json_str .= "\"q".$row_count."\":{\n";
            if(count($row) > 1) $json_str .= "{\n";

            $count = 0;
            foreach($row as $key => $value) {
                //If it is an associative array we want it in the format of "key":"value"
                if(count($row) > 1) $json_str .= "\"$key\":\"$value\"";
                else $json_str .= "\"$value\"";

                //Make sure that the last item don't have a ',' (comma)
                $count++;
                if($count < count($row)) $json_str .= ",\n";
            }
            $row_count++;
            if(count($row) > 1) $json_str .= "}\n";

            //Make sure that the last item don't have a ',' (comma)
            if($row_count < $total) $json_str .= ",\n";
        }

        $json_str .= "]\n";
    }

    //Replace the '\n's - make it faster - but at the price of bad redability.
    $json_str = str_replace("\n","",$json_str); //Comment this out when you are debugging the script

    //Finally, output the data
    return $json_str;
}

?>