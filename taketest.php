<?php
session_start();
require_once("killnonstudents.php");
require_once("curlRequest.php");

$test = $_POST['test'];
if(isset($test) && !empty($test))
{
	$decoded = json_decode($test);
	if(!empty($decoded->tid))
	{
		$decoded->url = 'taketest';
		$decoded->uid = $_SESSION['id'];
		$decoded->flag = 'submit'; 
		$stuff = curlRequestF(json_encode($decoded));
		echo $stuff;
	}
}
?>

<html>
<head>
	<script type="text/javascript">

		function InitQuestions()
		{
			document.getElementById('test').value = '{"tid":"","MC":[],"TF":[],"FB":[],"OE":[]}';
			//'{"tid":"17","MC":["question":{"fid":"10","answer":""}],"TF":[],"FB":[],"OE":[]}';
			
			var test = document.getElementById('test').value;
			var obj = JSON.parse(test);
			
			var MC = document.getElementById("MC");
			var TF = document.getElementById("TF");
			var FB = document.getElementById("FB");
			var OE = document.getElementById("OE");
			
			obj.tid = <?php echo $_GET['tid']; ?>;
			
			for(var i = 1; i < MC.rows.length; i++)
			{
				AddQuestion(obj.MC, MC.rows[i].cells[1].innerHTML);
			}

			for(var i = 1; i < TF.rows.length; i++)
			{
				AddQuestion(obj.TF, TF.rows[i].cells[1].innerHTML);
			}
		
			for(var i = 1; i < FB.rows.length; i++)
			{
				AddQuestion(obj.FB, FB.rows[i].cells[1].innerHTML);
			}
		
			for(var i = 1; i < OE.rows.length; i++)
			{
				AddQuestion(obj.OE, OE.rows[i].cells[1].innerHTML);
			}
			
			document.getElementById('test').value = JSON.stringify(obj);
		}
		
		function QAPair (fid)
		{
			this.fid = fid;
			this.answer = "";
		}
		
		function AddQuestion(object, fid)
		{
			object.push(new QAPair(fid));
		}
		
		function SetQuestion(object, i, answer)
		{
			if(answer == "") return false; //bad form
			object[i].answer = answer;
			return true;
		}
		
		function btnClick()
		{
			if(isValidForm()) document.getElementById("formTest").submit();
			else			  alert('You need to attempt all questions before submitting.')
		}
		
		function isValidForm()
		{	
			var test = document.getElementById('test').value;
			var obj = JSON.parse(test);
			
			var MC = document.getElementById("MC");
			var TF = document.getElementById("TF");
			var FB = document.getElementById("FB");
			var OE = document.getElementById("OE");
			
			for(var i = 1; i < MC.rows.length; i++)
			{
				if(!SetQuestion(obj.MC, i-1, MC.rows[i].cells[7].children[0].value)) return false; //if you couldn't set a question, fail out
			}
			
			document.getElementById('test').value = JSON.stringify(obj);
			
			for(var i = 1; i < TF.rows.length; i++)
			{
				if(!SetQuestion(obj.TF, i-1, TF.rows[i].cells[2].children[0].value)) return false;
			}
		
			for(var i = 1; i < FB.rows.length; i++)
			{
				if(!SetQuestion(obj.FB, i-1, FB.rows[i].cells[2].children[0].value)) return false;
			}
		
			for(var i = 1; i < OE.rows.length; i++)
			{
				if(!SetQuestion(obj.OE, i-1, OE.rows[i].cells[2].children[0].value)) return false;
			}
			
			document.getElementById('test').value = JSON.stringify(obj);
			
			return true;
		}
		
		window.onload = InitQuestions;
</script>

</head>


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
		<h2>Take test</h2>
		<body>
			<p>
				<?php echo GetQuestions("MC"); ?>
			</p>
			<p>
				<?php echo GetQuestions("TF"); ?>
			</p>
			<p>
				<?php echo GetQuestions("FB"); ?>
			</p>
			<p>
				<?php echo GetQuestions("OE"); ?>
			</p>
			<form id="formTest" method="POST">
				
				<input type="hidden" name="test" id="test">
				
				<div class="button">
					<input type="button" value="Submit test" onclick="return btnClick();">
				</div>	
			</form>
		</body>
</html>

<?php
function GetQuestions($type)
{
	//TODO: tagging system for questions, Query using like keyword search of question in SQL & tagging
	$arr = array( 'url' => 'taketest', 'flag' => 'fetch', 'tid' => $_GET['tid'] //$_SESSION['id']
				, 'uid' => $_SESSION['id'], 'type' => $type);
	
	//return curlRequestF(json_encode($arr));
	$obj = json_decode(curlRequestF(json_encode($arr)));
	
	$formatted = "";
	$i = 0;
	
	
	$formatted .= '<table ';
	if(count($obj) == 0) $formatted .= 'style="display:none;" ';
	$formatted .= 'id="'.$type.'"><tbody>';
	$formatted .= "<tr name=\"rows\">";
	
	
	//$formatted .= '<table id="'.$type.'"><tbody>';
	//$formatted .= "<tr name=\"rows\">";
	
	$formatted .= "<td name=\"cols\">Question</td>";
	$formatted .= "<td hidden name=\"cols\">ID</td>";
	if($type == 'MC') $formatted .= "<td name=\"cols\">A</td>";
	if($type == 'MC') $formatted .= "<td name=\"cols\">B</td>";
	if($type == 'MC') $formatted .= "<td name=\"cols\">C</td>";
	if($type == 'MC') $formatted .= "<td name=\"cols\">D</td>";
	if($type == 'MC') $formatted .= "<td name=\"cols\">E</td>";
	$formatted .='<td name="cols">Answer</td></tr>';	
	
	for($i = 0; $i < count($obj); $i++)
	{	
		$temp = get_object_vars($obj[$i]);

		$formatted.="<tr name=\"rows\">";
		
		$formatted .= "<td name=\"cols\">".$temp['question']."</td>";
		$formatted .= "<td hidden name=\"cols\">".$temp['fid']."</td>";
		if($type == 'MC') $formatted .= "<td name=\"cols\">".$temp['a']."</td>";
		if($type == 'MC') $formatted .= "<td name=\"cols\">".$temp['b']."</td>";
		if($type == 'MC') $formatted .= "<td name=\"cols\">".$temp['c']."</td>";
		if($type == 'MC') $formatted .= "<td name=\"cols\">".$temp['d']."</td>";
		if($type == 'MC') $formatted .= "<td name=\"cols\">".$temp['e']."</td>";
		
		if($type == "MC") $formatted .='<td name="cols">
										<select name="data" style="height: 100%; width: 100%;">
											<option value="" style="display:none;"></option>
											<option value="A">A</option>
											<option value="B">B</option>
											<option value="C">C</option>
											<option value="D">D</option>
											<option value="E">E</option>
										</select>
									</td>';
		else if($type == "TF") $formatted .='<td name="cols">
											<select name="data" style="height: 100%; width: 100%;">
												<option value="" style="display:none;"></option>
												<option value="T">T</option>
												<option value="F">F</option>
											</select>
										</td>';
		else if($type == "FB") $formatted .= '<td name="cols"><input type="text" name="data" style="height: 100%; width: 100%;"></td>';
		else if($type == "OE") $formatted .= '<td name="cols"><textarea name="data" style="height: 100%; width: 100%;"></textarea></td>';
		$formatted .= "</tr>";
	}
	$formatted .= "</tbody></table>";
	
	if(count($obj) != 0) $formatted .= "<br><br>";
	
	return $formatted;
}
?>