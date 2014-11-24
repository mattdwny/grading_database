<?php

error_reporting(E_ALL); //Error settings
ini_set('display_errors', '1');

$descriptorspec = array( 0 => array("pipe", "r"), 1 => array("pipe", "w"), 2 => array("pipe", "w") );

$process = proc_open('javac hello.java', $descriptorspec, $pipes, getcwd());

if (is_resource($process)) 
{
	fclose($pipes[0]);
	$out = stream_get_contents($pipes[1]);
	fclose($pipes[1]);
	$err = stream_get_contents($pipes[2]);
	fclose($pipes[2]);
}
$return_value = proc_close($process);


echo "Hello World";
//var_dump(exec("javac /afs/cad.njit.edu/u/m/d/md369/public_html/hello.java 2>&1", $output, $resultCode));
exec("javac web.njit.edu/~md369/hello.java", $output);
var_dump($output);

//var_dump(exec("java /afs/cad.njit.edu/u/m/d/md369/public_html/hello 2>&1", $output, $resultCode));
exec("java web.njit.edu/~md369/public_html/hello", $output);
var_dump($output);

//http://stackoverflow.com/questions/4842684/how-to-compile-run-java-program-in-another-java-program

/*exec("javac hello.java 2>&1", $output, $resultCode);
echo "Hello World!";
//exec("vi other.java 2>&1", $output2, $resultCode2);
//touch("web.njit.edu/~md369/other.java");
var_dump($output);
var_dump($resultCode);
//var_dump($output2);
//var_dump($resultCode2);*/

/**
 * javac then java $fileName
 */
 /*
	function CompileAndRun($cmd,$descriptorspec,$cwd,$env,$filename, $format, $cases, $answers)
	{
		$results = array();
		$process = proc_open('javac '.$filename.'.java', $descriptorspec, $pipes, $cwd, $env);
		if (is_resource($process)) 
		{
			fclose($pipes[0]);
			$results['c1'] = stream_get_contents($pipes[1]);
			fclose($pipes[1]);
			$results['c2'] = stream_get_contents($pipes[2]);
			fclose($pipes[2]);
			$return_value = proc_close($process);
			$results['crv'] = $return_value;
		}
	
		if ($return_value == 0)
		{
			$results['results'] = array();
			$len = count($cases);
			for ($i = 0; $i < $len; $i++)
			{
				$result = array();
				$process = proc_open("java ".$filename." ".getParams($format,$cases[$i],$answers[$i]), $descriptorspec, $pipes, $cwd, $env);
				
				if (is_resource($process)) 
				{
					fclose($pipes[0]);
					$result['e1'] = explode(" ",stream_get_contents($pipes[1]),2);
					fclose($pipes[1]);
					$result['e2'] = stream_get_contents($pipes[2]);
					fclose($pipes[2]);
					$return_value = proc_close($process);
					$result['erv'] = $return_value;
					
					array_push($results['results'],$result);
				}
			}
			
			//DELETE .class
			unlink($filename.'.class');
		}
		return $results;
	}
*/
?>