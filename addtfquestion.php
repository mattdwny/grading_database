<?php
session_start();
require("killnoninstructors.php");
require("curlRequest.php");


if (isset($_POST['question']) && !empty($_POST['question']))
{
	$question=$_POST['question'];
	$answer=$_POST['answer'];
	$data=array('question' => $question, 'answer' => $answer, 'author' => $_SESSION['user']);
	echo $_SESSION['user'];

	$response=curlReqJxJ("web.njit.edu/~md369/verifytfquestion.php", $data);

	echo $response->message;
	//->message;
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