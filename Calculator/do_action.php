<?php
$nums=$_POST['nums'];
$ops=isset($_POST['ops'])?$_POST['ops']:array();



// $nums=['1','2','3'];
// $ops=['+','*'];

// do the division and mutiplication first
while (in_array('*', $ops) || in_array('/', $ops)) {
	foreach ($ops as $index => $operator) {
		if ($operator==='*') {
			$value=$nums[$index]*$nums[$index+1];
			array_splice($nums, $index, 2, $value);
			array_splice($ops, $index,1);
			break;
		}else if($operator==='/'){
			if ($nums[$index+1]=='0') {
				exit('ERROR');
			}else{
				$value=$nums[$index]/$nums[$index+1];
				array_splice($nums, $index, 2, $value);
				array_splice($ops, $index,1);
				break;
			}
		}
	}
}

while (in_array('+', $ops) || in_array('-', $ops)) {
	foreach ($ops as $index => $operator) {
		if ($operator==='+') {
			$value=(int)$nums[$index]+(int)$nums[$index+1];
			array_splice($nums, $index, 2, $value);
			array_splice($ops, $index,1);
			break;
		}else if($operator==='-'){
			$value=(int)$nums[$index]-(int)$nums[$index+1];
			array_splice($nums, $index, 2, $value);
			array_splice($ops, $index,1);
			break;
		}
	}
}

if (!$ops) {
	echo $nums[0];
}

