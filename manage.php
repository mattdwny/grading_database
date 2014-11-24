<?php
session_start();
require_once("killnoninstructors.php");
require_once("curlRequest.php");

$tid = $_POST['tid'];
if(isset($tid) && !empty($tid))
{
	$arr = array( 'url' => 'manage', 'flag' => 'close', 'tid' => $tid);
	
	echo curlRequestF(json_encode($arr));
}
?>

<html>
	<script>
	function CloseTest(tid)
	{
		document.getElementById("tid").value = tid;
		document.getElementById("data").submit();
	}
	</script>
	<style>
	body
	{
		background-color: #C80000 ;
	}
	</style>
	
	<body>
		<p>
			<?php echo formatQuestions(); ?>
		</p>
		
		<form id="data" method="POST">
			<input type="hidden" name="tid" id="tid">
		</form>
	</body>
</html>

<?php

function formatQuestions()
{
	$arr = array( 'url' => 'manage', 'flag' => 'fetch', 'uid' => $_SESSION['id']);
	
	//return curlRequestF(json_encode($arr));
	$obj = json_decode(curlRequestF(json_encode($arr)));
	
	$formatted = "";
	$i = 0;
	
	$formatted .= '<table><tbody id="search">';
	$formatted .= "<tr name=\"rows\">";
	
	$formatted .= "<td name=\"cols\">Test Name</td>";
	$formatted .= "<td hidden name=\"cols\">ID</td>";
	$formatted .= '<td name="cols"><input hidden type="button" value="Close Test"></td>'; //TODO points
	
	for($i = 0; $i < count($obj); $i++)
	{	
		$row = get_object_vars($obj[$i]);

		$formatted.="<tr name=\"rows\">";
		
		$formatted .= "<td name=\"cols\">".$row['testName']."</td>";
		$formatted .= "<td hidden name=\"cols\">".$row['tid']."</td>";
		$formatted .= '<td name="cols"><input type="button" value="Close Test" style="height: 100%; width: 100%;" onclick="CloseTest('.$row['tid'].')"></td>'; //TODO points
		
		$formatted .= "</tr>";
	}
	$formatted .= "</tbody></table>";
	
	return $formatted;
}

?>