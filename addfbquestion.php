<?php
session_start();
require("killnoninstructors.php");
require("curlRequest.php");

if (isset($_POST['question']) && !empty($_POST['question'])
	&& isset($_POST['answer']) && !empty($_POST['answer']))
{
	$question=$_POST['question'];
	$answer=$_POST['answer'];

	echo "frontworks";


	$data=array('question' => $question, 'answer' => $answer, 'author' => $_SESSION['user']);

	$response=curlReqJxJ("web.njit.edu/~ss2563/verifyfbquestion.php", $data);
	echo "everythinglese works";

}
?>
<html>
	<head>
		<title>Add Fill in the Blank Questions</title>
	</head>
	<body>

<div class="border">
		<h2>Add Fill in the Blank Questions</h2>
			<form action="" method="POST">
				<label>Question:</label>
					<input type="text" id="question" name="question"/><br>
				<label>Answer: </label>
					<input type="text" id="answer" name="answer"/><br><br>

				<div class="button">
					<input type="submit" value=" Add question " onclick="">
				</div>
			</form>
	</div>
		
	</body>
	</html>