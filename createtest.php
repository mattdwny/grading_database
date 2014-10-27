<?php
session_start();
require("killnoninstructors.php");
require("curlRequest.php");
require("backrequire.php");

function formatQuestions($obj, $type)
{
	$formatted = "";
	$i = 0;
	
	$formatted.="<table>";
	$formatted.="<tr><td></td>";

	$formatted.="<td>Question</td>";
	$formatted.="<td>Answer</td>";
	$formatted.="<td>A</td>";
	$formatted.="<td>B</td>";
	$formatted.="<td>C</td>";
	$formatted.="<td>D</td>";
	$formatted.="<td>E</td></tr>";

	for($i = 0; $i < count($obj); $i++)
	{	

		$temp = get_object_vars($obj[$i]);

		$formatted.="<tr><td><input type=\"checkbox\" name=\"q".$i."\" id=\"q".$i."\" value=\"q".$i."\"></td>";
		$formatted.="<td>".$temp['question']."</td>";
		$formatted.="<td>".$temp['answer']."</td>";
		$formatted.="<td>".$temp['a']."</td>";
		$formatted.="<td>".$temp['b']."</td>";
		$formatted.="<td>".$temp['c']."</td>";
		$formatted.="<td>".$temp['d']."</td>";
		$formatted.="<td>".$temp['e']."</td>";
	}
	$formatted.="</table>";

	return $formatted;
}

?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="table.css">
	<script type="text/javascript">
		function getQuestions(type)
		{
			var qt = document.getElementById('qt').value;


			<?php
				$conn = retConn();
				$author = getUser($conn, $_SESSION['user']);
				
			?>
		}



		function drawQuestions()
		{
			<?php
			$conn = retConn();
			$author = getUser($conn, $_SESSION['user']);
			$result = json_decode(fetchQuestions($conn, $author, 'MC'));
			?>

			document.getElementById('variable').innerHTML = "<?php
			echo "Changed version";
			?>";
		}
</script>

</head>


<style>
body
	{
		background-color: #C80000 ;
	}

table {
    border-collapse: collapse;
    background-color: white;
}

table, td, th {
    border: 1px solid black;
}

</style>


	<div class="border">
	
		<h2>Create test</h2>
		
		<form action="" method="POST">
		
			<label>Test name :</label>
				<input type="text" id="testname" name="testname"/><br>
				
			<br><p id="testInfo" name="testInfo">This is a paragraph</p>
			
			<br><label>Question type: </label>
				<select id="qt" name="qt" onclick="">
					<option value="MC">Multiple Choice</option>
					<option value="TF">True False</option>
					<option value="FB">Fill in the Blank</option>
					<option value="OE">Open Ended</option>
				</select>
			<br>

			<?php
			
			if(isset ($_POST['qt']) && !empty ($_POST['qt']))
			{
				$conn = retConn();
				$author = getUser($conn, $_SESSION['user']);
				$result = json_decode(fetchQuestions($conn, $author, 'MC'));
				echo formatQuestions($result, 'MC');
			}
			
			?>

			<p id="variable" name="variable">
				This will change
			</p>

			<br>
			<div class="button">
				<input type="submit" value="Submit test " onclick="">
			</div>
			
		</form>
	</div>
</html>