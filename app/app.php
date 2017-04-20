<?php
	$process = proc_open('php runner.php >> runner.log &', array(), $pipes);
	$var = proc_get_status($process);
	proc_close($process);
	$pid = intval($var['pid']) + 1;
	var_dump($pid);
