<?php
session_start();
require_once("killnoninstructors.php");
require_once("curlRequest.php");

if (isset($_POST['question']) && !empty($_POST['question']))
{
	$question=$_POST['question'];

	$data = array('url' => 'addoequestion', 'author' => $_SESSION['id'], 'type' => 'OE', 'question' => $question);

	$response = curlRequestF(json_encode($data));
	
	//TODO: adding unit test cases
	//Question: "Write a palindrome script that returns "true" when it finds a palindrome and "false" when the inputted string is not a palindrome. The function does not need to handle upper/lower case or spaces.
	//test case1: Race car => false
	//test case2: racecar => true
	//test case3: mom => true
	
	echo $response;
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