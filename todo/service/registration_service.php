<?php

function validate_registration_form($form) {
    $errors = [];
    
    $firstName = $form["firstName"];
    $lastName = $form["lastName"];
    $userName = $form["userName"];
    $password = $form["password"];

    if(!$firstName) {
        $errors["firstName"] = "First name is required";
    }
    
    if(!$lastName) {
        $errors["lastName"] = "Last name is required";
    }
    
    $userNameValid = filter_var($form["userName"], FILTER_VALIDATE_EMAIL);
    if(!$userNameValid) {
        $errors["userName"] = "User name is required and should be a valid email address";
    }

    $passwordValid = verify_password($password);
    if(!$passwordValid) {
        $errors["password"] = "Password is required at least 1 alpha and at least 1 numeric. It should have at least 6 characters and no more than 12 characters. No special characters (except $, _)";
    }
    
    
        
    return $errors;
}

/**
 * Password Verify
 *      6 to 12 characters
 *      alpha numeric (at least 1 alpha and at least 1 numeric)
 *      special characters ($, _)
 * @param string $password
 */
function verify_password($password){
    $valid=true;
    $length=strlen($password);
    if ($length<6 || $length>12){
        $valid = false;
    }
    if (!preg_match('/[a-zA-Z]/',$password) || !preg_match('/[0-9]/',$password)){
        $valid = false;
    }
    if (preg_match('/'.preg_quote('^\'£$%^&*()}{@#~?><,@|-=-_+-¬', '/').'/', $password)){
        $valid = false;
    }
    return $valid;
}

function validate_decription($description){
    $len=strlen($description);
    if ($len==0 || $len>120){
        return false;
    }else {
        return true;
    }
}
?>
