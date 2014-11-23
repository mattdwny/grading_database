<?php
require_once("curlRequest.php");
$encoded = file_get_contents('php://input');

if(isset($encoded) && !empty($encoded))
{	
	$decoded = json_decode($encoded);
	if($decoded->flag == "fetch") echo curlRequestM($encoded);
	else
	{
		echo "middle working...";
		
		$save = clone $decoded;
		$save->flag = 'store';
		$storage = curlRequestM(json_encode($save));
		echo $storage;
		
		$correct = array( 'url' => 'taketest', 'type' => 'MC', 'tid' => $decoded->tid, 'flag' => 'correct' );
		$correctMC = json_decode(curlRequestM(json_encode($correct)));
		
		$correct = array( 'url' => 'taketest', 'type' => 'TF', 'tid' => $decoded->tid, 'flag' => 'correct' );
		$correctTF = json_decode(curlRequestM(json_encode($correct)));
		
		var_dump($correctTF);
		
		$correct = array( 'url' => 'taketest', 'type' => 'FB', 'tid' => $decoded->tid, 'flag' => 'correct' );
		$correctFB = json_decode(curlRequestM(json_encode($correct)));
		
		var_dump($correctFB);
		
		//$testcases = array( 'url' => 'taketest', 'type' => 'MC', 'tid' => $decoded->tid, 'flag' => 'correct' );
		//$correctOE = json_decode(curlRequestM(json_encode($correct)));

		
		$total = 0;
		$sum = 0;
		
		foreach ($correctMC as $index => &$mc1)
		{
			$mc2 = &$decoded->MC[$index];
			echo '['.$mc1->answer.', '.$mc2->answer.']';
			
			if($mc1->answer == $mc2->answer) $sum += $mc1->points;
			$total += $mc1->points;
		}
		
		foreach ($correctTF as $index => &$tf1)
		{
			$tf2 = &$decoded->TF[$index];
			echo '['.$tf1->answer.', '.$tf2->answer.']';
			
			if($tf1->answer == $tf2->answer) $sum += $tf1->points;
			$total += $tf1->points;
		}
		
		foreach ($correctFB as $index => &$fb1)
		{
			$fb2 = &$decoded->FB[$index];
			echo '['.$fb1->answer.', '.$fb2->answer.']';
			
			if($fb1->answer == $fb2->answer) $sum += $fb1->points;
			$total += $fb1->points;
		}
		
		echo $sum.'/'.$total;
		//echo $total;
		
		
		//Add grade calculations!
		//Compile OE, run test cases
	}
}

?>