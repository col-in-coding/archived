<?php
require_once(__DIR__ . "/../config/constants.php");
//require_once(__DIR__ . "/domain.php");
error_reporting(E_ALL);

$users_db_file = __DIR__ . "/../data/users.json";


$users_json_string = file_get_contents($users_db_file);
$usersDB = json_decode($users_json_string);

$todosDB = array();

function get_current_user_id(){
	if(session_id() == '' || !isset($_SESSION)) {
	    // session isn't started
	    session_start();
	}

	if(isset($_SESSION[CURRENT_USER])){
		$cusr = $_SESSION[CURRENT_USER];
		$split = explode("@",$cusr);
		return $split[0];
	}
	return false;
} 

function save_user_object($user){
    //rewrite the users file
    $filename=__DIR__ . "/../data/users.json";
    $users=json_decode(file_get_contents($filename));
    $newUser=(object)$user;
    //     var_dump($newUser);
    //     var_dump($users);
    array_push($users, $newUser);
    var_dump($users);
    $data=json_encode($users);
    //     var_dump($data);
    file_put_contents($filename, $data);
    
    //Create empty todo list
    $todoFile=__DIR__ . "/../data/".strstr($user["email"], "@",true).".json";
    $tododata='{"nextId": 1,"todos": []}';
    file_put_contents($todoFile, $tododata);
}

function get_user_array(){
	return array (
		//map,
		//map
	);
}

function get_user_object($userId){
	global $usersDB;
	$userCount = count($usersDB);
	
	if($userCount > 0) {
		$user = false;
		for($index=0;$index<$userCount;$index++){
			$usr = $usersDB[$index];			
			if($usr->email===$userId){
				//convert $usr to map
				$user = convert_usr_stdclass_to_map($usr);
				break;
			}
		}

		return $user;
	}

	return false;
}

function convert_usr_stdclass_to_map($usr){
	return array(
		user_FIRST_NAME=> $usr->firstName,
		user_LAST_NAME=> $usr->lastName,
		user_EMAIL=> $usr->email,
		user_PASSWORD=> $usr->password,
		user_SALT=> $usr->salt,
		user_TYPE=> $usr->type,
		user_ENABLED=> $usr->enabled
	);
}

function convert_todo_stdclass_to_map($tdo){
	return array(
		todo_ID=> $tdo->id,
		todo_DESCRIPTION=> $tdo->desc,
		todo_DATE=> $tdo->date,
		todo_STATUS=> $tdo->status
	);
}

/**
 * load todo list data into a global variable todosDB (map)
 * todosDB[
 *      "nextId" => number,
 *      "todos" => array()
 * ]
 */
function init_todos_db(){
	global $todosDB;
	if(!$todosDB){
		$currentUserId = get_current_user_id(); // email name before "@"
		if(!$currentUserId){
			trigger_error("Please login before trying to access your To Do list");
		}
		$todos_db_file = __DIR__ . "/../data/${currentUserId}.json";
		
		$todos_json_string = file_get_contents($todos_db_file);
		$tmpDB = json_decode($todos_json_string);

		$stdTodos = $tmpDB->todos;
		//print_r($stdTodos);

		$todoCount = count($stdTodos);
		//print_r($todoCount);

		if($todoCount > 0) {
			$todosDB = array(
				"nextId"=>$tmpDB->nextId				
			);

			$tmpTodos = array();
			for($index=0;$index<$todoCount;$index++){
				$tdo = $stdTodos[$index];
				$todoObj = convert_todo_stdclass_to_map($tdo);
				array_push($tmpTodos, $todoObj);
			}

			$todosDB["todos"] = $tmpTodos;
		}else {
		    $todosDB = array(
		        "nextId"=>1,
		        "todos"=>array()
		    );
		}
	}
}

/**
 * Save JSON record
 * @param map $todo
 */
function save_todo_object($todo,$filename){
    global $todosDB;
    init_todos_db();
// 	var_dump($todo);
 	//var_dump($todosDB);
	$data = $todosDB;
	$data['nextId']++;
	array_push($data['todos'], $todo);
	file_put_contents($filename, json_encode($data));
}

function get_todo_info($todoId){
    global $todosDB;
	init_todos_db();
	$todos=$todosDB['todos'];
 	var_dump($todoId);
	foreach ($todos as $todo){
	    if ((string)$todo['id']===$todoId){
	        return $todo;
	        exit;
	    }
	}
	die("todoId fault");
}

function get_todo_array($userName){	
    global $todosDB;
	init_todos_db();
	//save the todos in $todosDB["todos"]
	return $todosDB["todos"] ? $todosDB["todos"] : array() ;
}

/**
 * Generate the new todo id number
 * @param string $owner
 */
function generate_todo_id($owner,$filename){
	$data = json_decode(file_get_contents($filename));
	return $data->nextId;
}

function edit_todo($description, $status, $todoId){
    $result=true; // update success
//     var_dump($description);
//     var_dump($status);
//     var_dump($todoId);
    global $todosDB;
    init_todos_db();
    $data=$todosDB;
//     var_dump($todosDB['todos']);
    for ($i=0;$i<count($data['todos']);$i++){
        if ($data['todos'][$i]['id']==$todoId){
            $data['todos'][$i]['desc']=$description;
            $pre_status=$data['todos'][$i]['status'];
            switch ($status){
                case 'N': 
                    if ($pre_status=='Not Started'){
                        $result = true;
                    }else {
                        $result = false;
                    }
                    break;
                case 'S': 
                    if ($pre_status=='Not Started' || $pre_status=='Started'){
                        $data['todos'][$i]['status']='Started';
                    }else {
                        $result = false;
                    }
                    break;
                case 'M': 
                    if ($pre_status=='Started' || $pre_status=='Mid-way'){
                        $data['todos'][$i]['status']='Mid-way';
                    }else {
                        $result = false;
                    }
                    break;
                case 'C': 
                    if ($pre_status=='Mid-way' || $pre_status=='Completed'){
                        $data['todos'][$i]['status']='Completed';
                    }else {
                        $result = false;
                    }
                    break;
            }
        }
    }
//     var_dump($_SESSION);
    $filename=__DIR__ . "/../data/".$_SESSION['CURRENT_USER'].".json";
    file_put_contents($filename, json_encode($data));
    return $result;
}

function del_todo($todoId){
    global $todosDB;
    init_todos_db();
    $data=$todosDB; //map

    for ($i=0;$i<count($data['todos']);$i++){
        if ($data['todos'][$i]['id']==$todoId){
            array_splice($data['todos'], $i,1);
        }
    }    
    //var_dump($data);
    //die();    
    $filename=__DIR__ . "/../data/".$_SESSION['CURRENT_USER'].".json";
    file_put_contents($filename, json_encode($data));

}

?>