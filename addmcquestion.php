<?php
session_start();
require("killnoninstructors.php");
require("curlRequest.php");

if (isset($_POST['question']) && !empty($_POST['question'])
	&& isset($_POST['answer']) && !empty($_POST['answer'])
	&& isset($_POST['a']) && !empty($_POST['a'])
	&& isset($_POST['b']) && !empty($_POST['b'])
	&& isset($_POST['c']) && !empty($_POST['c'])
	&& isset($_POST['d']) && !empty($_POST['d'])
	&& isset($_POST['e']) && !empty($_POST['e'])	)
{
	$question=$_POST['question'];
	$answer=$_POST['answer'];
	$a=$_POST['a'];
	$b=$_POST['b'];
	$c=$_POST['c'];
	$d=$_POST['d'];
	$e=$_POST['e'];
	echo "frontworks";



	$data=array('question' => $question, 'answer' => $answer,
				'a' => $a, 'b' => $b, 'c' => $c, 'd' => $d, 'e' => $e,
		'author' => $_SESSION['user']);

	$response=curlReqJxJ("web.njit.edu/~md369/verifymcquestion.php", $data);
	echo "everythinglese works";

}
?>

<html>
	<head>
		<title>Add Multiple Choice Questions</title>
	</head>
	<body>

	<div class="border">
		<h2>Add Multiple Choice Questions</h2>
			<form action="" method="POST">
				<label>Question:</label>
					<input type="text" id="question" name="question"/>
				<label>Answer: </label>
					<select id="answer" name="answer">
  					  <option value="A">A</option>
					  <option value="B">B</option>
					  <option value="C">C</option>
					  <option value="D">D</option>
					  <option value="E">E</option>
					</select>
				<br>
				<br><label>A)</label>
					<input type="text" id="a" name="a"/>
				<br><label>B)</label>
					<input type="text" id="b" name="b"/>
				<br><label>C)</label>
					<input type="text" id="c" name="c"/>
				<br><label>D)</label>
					<input type="text" id="d" name="d"/>
				<br><label>E)</label>
					<input type="text" id="e" name="e"/></br>
				<br>
				<div class="button">
					<input type="submit" value=" Add question " onclick="">
				</div>
			</form>
	</div>
		
	</body>
</html>