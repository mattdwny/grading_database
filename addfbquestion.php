<?php
session_start();
require_once("killnoninstructors.php");
require_once("curlRequest.php");

if (isset($_POST['question']) && !empty($_POST['question'])
	&& isset($_POST['answer']) && !empty($_POST['answer']))
{
	$question=$_POST['question'];
	$answer=$_POST['answer'];

	$data = array('url' => 'addfbquestion', 'author' => $_SESSION['id'], 'type' => 'FB', 'question' => $question, 'answer' => $answer);

	$response = curlRequestF(json_encode($data));
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