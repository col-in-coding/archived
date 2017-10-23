<?php

require_once(__DIR__ . "/../config/constants.php");
require_once(__DIR__ . "/../controller/ensure_session.php");
require_once(__DIR__ . "/../util/web.php");
//require_once(__DIR__ . "/../util/security.php");
require_once(__DIR__ . "/../service/registration_service.php");//data validation
require_once(__DIR__ . "/../service/data_service.php");//config
//var_dump($_POST);
// var_dump($_SESSION);
if (!isset($_POST["action"])) {
    redirect(VIEWS . "/home.php");
}

$action = $_POST["action"];
// Add the data into todo list (id, description, date, status)
if ($action == "Add") {
    if (isset($_POST["description"])) {
        $owner = $_SESSION[CURRENT_USER];
        $description = $_POST["description"];
        //validate task description
        //var_dump($description);
        $valid = validate_decription($description); //max lengh
        //$valid = true;
        if ($valid) {
            $scheduledDate = time();
            if (isset($_POST["scheduledDate"]) && strlen(trim($_POST["scheduledDate"])) > 0) {
                $scheduledDate = strtotime($_POST["scheduledDate"]);
            }
            //var_dump($scheduledDate);
   
            //var_dump($_SESSION);
            
            new_todo($description, $scheduledDate, $owner);
        } else {
            $_SESSION["error"] = "Task description is required and can have upto 120 characters";
        }
    }
    redirect(VIEWS . "/home.php");
} else if ($action == "Edit") {

// Edit the content of selected todo;
    if (isset($_POST["taskId"])) {
        $todoId = $_POST["taskId"];
        $todo = get_todo($todoId);
        //var_dump($todo);
        
        $_SESSION['todo_info']=$todo;
        var_dump($todoId);
        $_SESSION['todo_id']=$todoId;        
        redirect(VIEWS . "/update_task.php");
    } else {
        $_SESSION["error"] = "Select a task";
        redirect(VIEWS . "/home.php");
    }

// Delete
} else if ($action == "Delete") {
    if (isset($_POST["taskId"])) {
        $todoId = $_POST["taskId"];
        
        delete_todo($todoId);
    } else {
        $_SESSION["error"] = "Select a task";
    }
    redirect(VIEWS . "/home.php");
} else if ($action == "Update") {

// Update
    if (isset($_POST["taskId"])) {
        $todoId = $_POST["taskId"];
        $description = $_POST["description"];
        $status = $_POST["status"];
        
        $updated=update_todo($description, $status, $todoId);
        if (!$updated){
            $_SESSION['error']='You can only change the status by the ordor "Not Started=>Started=>Mid-way=>Completed"<br/>Completed task is read only'; 
        }
    } else {
        $_SESSION["error"] = "Select a task";
    }
    redirect(VIEWS . "/home.php");
}
?>