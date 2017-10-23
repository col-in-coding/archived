<!DOCTYPE html>
<html>
<head>
<title>Calculator</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<style>
    .table{
    	width:660px;
    	margin:auto;
    }
    table tr th{
    	text-align:center;
    }
    #show{
    	text-align:right;
    }
    button{
    	margin:0;
    	width:100%;
    }

</style>
</head>
<body>

<table class="table table-bordered">
	<tr>
		<th colspan="4">Calculator</th>
		
	</tr>
	<tr>
		<th colspan="4" id='show'>0</th>
	</tr>
	
	<tr>
		<td><button class="num" value="1">1</button></td>
		<td><button class="num" value="2">2</button></td>
		<td><button class="num" value="3">3</button></td>
		<td><button class="op" value="+">+</button></td>
	</tr>
	<tr>
		<td><button class="num" value="4">4</button></td>
		<td><button class="num" value="5">5</button></td>
		<td><button class="num" value="6">6</button></td>
		<td><button class="op" value="-">-</button></td>
	</tr>
	<tr>
		<td><button class="num" value="7">7</button></td>
		<td><button class="num" value="8">8</button></td>
		<td><button class="num" value="9">9</button></td>
		<td><button class="op" value="*">*</button></td>
	</tr>
	<tr >
		<td><button class="eq">=</button></td>
		<td><button class="num" value="0">0</button></td>
		<td><button id="reset">R</button></td>
		<td><button class="op" value="/">/</button></td>
	</tr>
</table>
<script>
var nums=[]; // store numbers
var num='0';
var ops=[]; // store operators
var flag=0; // previously 0 for number, 1 for operator
var show_content='0'; // show string

$(document).ready(function(){
	$('#reset').click(function(){
		$('#show').text("0");
		reset_cal();
	})

	$('.op,.num').click(function(){
		// console.log($(this).val());
		var press = $(this).val();
		var class_name = $(this).attr('class');

		if (show_content==='0') {

			// first press 
			if (press==='0') {
				$('#show').text(show_content); // first press is 0
			}else if (class_name==='num') {
				show_content=press; // first press is other number
				$('#show').text(show_content); 
				num=press;
			}else if (class_name==='op') {
				show_content+=press; // first press is operator
				$('#show').text(show_content);
				nums.push('0');
				ops.push(press);
				flag=1;
			}	
		}else{

			// not first press and previous press is a number
			if (flag===0) {
				if (num==='0' && press==='0'){
					// Nothing
				}else if (class_name==='num') {
					show_content+=press;
					$('#show').text(show_content);
					num+=press; //this press is also a number
				}else{
					// this press is an operator
					show_content+=press;
					$('#show').text(show_content);
					nums.push(num);
					num='';
					ops.push(press);
					flag=1;
				}
			}else{
				// not first press and previous press is an operator
				if (class_name==='num') {
					show_content+=press; // this press is a number
					num=press;
					$('#show').text(show_content);
					flag=0;
				}else{
					// this press is also an operator
				}
			}
		}
	})
	
	$('.eq').click(function() {
		if (flag) {
			$('#show').text("ERROR");
			reset_cal();
		}else{
			nums.push(num);
			console.log(nums);
			console.log(ops);

			//call ajax
			$.ajax({
				url: 'do_action.php',
				type: 'POST',
				dataType: 'text',
				data: {'nums': nums, 'ops': ops},
			})
			.done(function(result) {
				//console.log(result);
				$('#show').text(result);
				reset_cal();
			})
			.fail(function() {
				console.log("error");
			});
			



			reset_cal();
		}
	});

function reset_cal(){
		show_content='0';
		flag=0;
		num='0';
		ops=[];
		nums=[];
}
	
});
</script>
</body>
</html>