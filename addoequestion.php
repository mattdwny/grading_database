<?php
session_start();
require("killnoninstructors.php");
require("curlRequest.php");

if (isset($_POST['question']) && !empty($_POST['question']))
{
	$question=$_POST['question'];

	echo "frontworks";

	$data=array('question' => $question, 'author' => $_SESSION['user']);

	$response=curlReqJxJ("web.njit.edu/~md369/verifyoequestion.php", $data);
	echo "everythinglese works";

}
?>
<html>
	<head>
		<title>Add Open Ended Questions</title>
	</head>
	<body>

<div class="border">
		<h2>Add Open Ended Questions</h2>
			<form action="" method="POST">
					<div class="button">
						<input type="submit" value=" Add question " onclick="">
					</div><br>
				<textarea id="question" name="question" type="text" rows="20" cols="60"></textarea>
				<br>
				<br>
			</form>
	</div>
		
	</body>
	</html>