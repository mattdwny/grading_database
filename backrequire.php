<?php

function AddQuestion($data)
{
	$conn = getConn();
	$type = $data->type;
	
	if($type == 'MC')      					$query="INSERT INTO cs490q$type VALUES('', '$data->author', '$data->question', '$data->answer', '$data->a', '$data->b', '$data->c', '$data->d', '$data->e');";
	else if($type == 'TF' || $type == 'FB') $query="INSERT INTO cs490q$type VALUES('', '$data->author', '$data->question', '$data->answer');";
	else									$query="INSERT INTO cs490q$type VALUES('', '$data->author', '$data->question');";
	mysql_query($query, $conn);
	mysql_close($conn);
}

function FetchQuestions($data)
{
	$conn = getConn();
	$sql = 'SELECT *
			FROM cs490q'.$data->type.' '.
			'WHERE cs490q'.$data->type.'.uid = "'.$data->author.'";';
	
	$sql_result = mysql_query($sql, $conn);
	mysql_close($conn);
	
	return sql2json($sql_result);
}



function getConn(){
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

function Login($data)
{
	$conn = getConn();

	$sql = 'SELECT cs490users.uid, cs490users.type, cs490users.username
			FROM cs490users, cs490pass
			WHERE cs490users.uid = cs490pass.uid AND
				  cs490pass.password = "'.$data->pass.'" AND
				  cs490users.username = "'.$data->user.'";';

				  
	//echo $sql;
	
	$sql_result = mysql_query( $sql, $conn);		  
	
	if(! $sql_result ) die('Could not get data: ' . mysql_error());

	$encoded = sql2json($sql_result);
	
	mysql_close($conn);

	return $encoded;
}

function SaveTest($user, $testName, $mc, $tf, $fb, $oe)
{
	$conn = retConn();
	$author = getUser($conn, $user);
	
}

function sql2json($data_sql)
{
    $json_str = ""; //Init the JSON string.

    if($total = mysql_num_rows($data_sql)) //See if there is anything in the query
	{
        if(mysql_num_rows ($data_sql) != 1) $json_str .= "[\n";

        $row_count = 0;
        while($row = mysql_fetch_assoc($data_sql))
		{
            if(count($row) > 1) $json_str .= "{\n";

            $count = 0;
            foreach($row as $key => $value)
			{
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

        if(mysql_num_rows ($data_sql) != 1) $json_str .= "]\n";
    }

    //Replace the '\n's - make it faster - but at the price of bad readability.
    $json_str = str_replace("\n","",$json_str); //Comment this out when you are debugging the script

	//echo $json_str;
	
    //Finally, output the data
    return $json_str;
}
?>