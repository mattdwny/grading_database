<?php
session_start();
require_once("killnonstudents.php");
require_once("curlRequest.php");
?>

<html>
	<style>
	body
	{
		background-color: #C80000 ;
	}
	div
	{
		width: 2000px;
	}
	table
	{
		border-collapse: collapse;
		background-color: white;
	}

	table, td, th
	{
		border: 1px solid black;
	}
	td
	{
		max-width:200px;
	}

	</style>
	
	<body>
		<?php echo SelectGrades("MC") ?>
	</body>
	<body>
		<?php echo SelectGrades("TF") ?>
	</body>
	<body>
		<?php echo SelectGrades("FB") ?>
	</body>
	<body>
		<?php echo SelectGrades("OE") ?>
	</body>
</html>

<?php

function SelectGrades($type)
{
	$info = array( 'url' => 'reviewgrade', 'uid' => $_SESSION['id'], 'tid' => $_GET['tid'], 'type' => $type, 'flag' => 'get_grades' );
	
	$obj = json_decode(curlRequestF(json_encode($info)));
	//$obj = curlRequestF(json_encode($info)); echo $obj; return;
	
	//var_dump($obj);
	
	$formatted = "";
	$i = 0;
	
	
	$formatted .= '<table ';
	if(count($obj) == 0) $formatted .= 'style="display:none;" ';
	$formatted .= 'id="'.$type.'"><tbody>';
	$formatted .= "<tr name=\"rows\">";
	
	
	//$formatted .= '<table id="'.$type.'"><tbody>';
	//$formatted .= "<tr name=\"rows\">";
	
	$formatted .= "<td name=\"cols\">Question</td>";
	if($type != 'OE') $formatted .= "<td name=\"cols\">Correct Answer</td>";
	$formatted .= "<td name=\"cols\">Your Answer</td>";
	$formatted .= "<td name=\"cols\">Points</td>";
	
	for($i = 0; $i < count($obj); $i++)
	{	
		$temp = get_object_vars($obj[$i]);

		$formatted.="<tr name=\"rows\">";
		
		$formatted .= "<td name=\"cols\">".$temp['question']."</td>";
		if($type == 'TF' || $type == 'FB') $formatted .= "<td name=\"cols\">".$temp['answer']."</td>";
		else if($type == 'MC') $formatted .= "<td name=\"cols\">".MC($temp, $temp['answer'])."</td>";
		$correct = ($temp['answer'] == $temp['response']);
		
		$formatted .= "<td name=\"cols\">";
		if($type != 'OE')
		{
			if($correct)	$formatted .= "<font color=\"blue\">";
			else			$formatted .= "<font color=\"red\">";
		}
		if($type != "MC") $formatted .= $temp['response'];
		else 			  $formatted .= MC($temp, $temp['response']);
		if($type != 'OE') $formatted .= "</font>";
		$formatted .= "</td>";
		$formatted .= "<td name=\"cols\">".$temp['points']."</td>";
		$formatted .= "</tr>";
	}
	$formatted .= "</tbody></table>";
	
	if(count($obj) != 0) $formatted .= "<br><br>";
	
	return $formatted;
}

function MC($row, $value)
{
	if($value == "A") return $row['a'];
	if($value == "B") return $row['b'];
	if($value == "C") return $row['c'];
	if($value == "D") return $row['d'];
	if($value == "E") return $row['e'];
}
?>