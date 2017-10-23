<?php
require_once(__DIR__ . "/../config/config.php");
require_once(__DIR__ . "/../model/domain.php");
require_once(__DIR__ . "/../util/security.php");

if(DATASOURCE_TYPE === DATASOURCE_JSON){
	require_once(__DIR__ . "/../model/json_data_access.php");
} else if(DATASOURCE_TYPE === DATASOURCE_CSV) {
	require_once(__DIR__ . "/../model/csv_data_access.php");
} else if(DATASOURCE_TYPE === DATASOURCE_MYSQL){
	require_once(__DIR__ . "/../model/mysql_data_access.php");
}

/**
	User Methods
*/

//Has to be called before newUser
function verify_username_availability($userName){
	$exists = false;
	
	if(get_user($userName)){
		$exists = true;
	}
	
	return $exists;
}

function new_todo_user($firstName,$lastName,$email,$password){
	return new_user($firstName,$lastName,$email,$password,user_type_USER);
}

function new_admin($firstName,$lastName,$email,$password){
	return new_user($firstName,$lastName,$email,$password,user_type_ADMIN);
}

//Username is assumed to be unique. Private. //Ensure that $email does not exist in the system
function new_user($firstName,$lastName,$email,$password,$userType){	
	$salt = generate_salt();
	$encPassword = encrypt_password($password,$salt);
	
	$user = create_user_object($firstName,$lastName,$email,$encPassword,$salt,$userType);
	//var_dump($user);
 	save_user_object($user);

	return $user;
}

function get_users() {
	return get_user_array();
}

//Username is assumed to be unique
function get_user($userName){
	return get_user_object($userName);
}

/**
 * Create a new todo and save it
 * @param string $description
 * @param timestream $date
 * @param string $owner
 * @return unknown[]|string[]
 */
function new_todo($description, $date, $owner) {
    $filename = __DIR__."/../data/".$owner.".json";
    $id = generate_todo_id($owner,$filename);
	$todo = create_todo_object($id,$description,$date);
	//var_dump($todo);
	save_todo_object($todo,$filename);
}

function get_todos($owner){
	return get_todo_array($owner);
}

/**
 * Fetch the todo contents by todoId and userId
 * @param unknown $todoId
 */
function get_todo($todoId){
	return get_todo_info($todoId);
}

function update_todo($description, $status, $todoId){
    return edit_todo($description, $status, $todoId);
}

function delete_todo($todoId){
    del_todo($todoId);
}
?>
