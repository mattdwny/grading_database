<?php
session_start();
require_once("killnoninstructors.php");
require_once("curlRequest.php");


if (isset($_POST['question']) && !empty($_POST['question']))
{
	$question=$_POST['question'];
	$answer=$_POST['answer'];
	
	$data = array('url' => 'addtfquestion', 'author' => $_SESSION['id'], 'type' => 'TF', 'question' => $question, 'answer' => $answer);

	$response = curlRequestF(json_encode($data));
	
	echo $response;
}
?>

<html>
	<head>
		<title>Add True-False Questions</title>
	</head>
	<body>

	<div class="border">
		<h2>Add True-False Questions</h2>
			<form action="" method="POST">
				<label>Question:</label>
					<input type="text" id="question" name="question"/>
				<label>Answer: </label>
					<select id="answer" name="answer">
  					  <option value="T">T</option>
					  <option value="F">F</option>
					</select>
				<br>
				<div class="button">
					<input type="submit" value=" Add question " onclick="">
				</div>
			</form>
	</div>
		
	</body>
	</html>