<?php

//http://stackoverflow.com/questions/4842684/how-to-compile-run-java-program-in-another-java-program

exec("javac hello.java 2>&1", $output, $resultCode);
echo "Hello World!";
//exec("vi other.java 2>&1", $output2, $resultCode2);
//touch("web.njit.edu/~md369/other.java");
var_dump($output);
var_dump($resultCode);
//var_dump($output2);
//var_dump($resultCode2);