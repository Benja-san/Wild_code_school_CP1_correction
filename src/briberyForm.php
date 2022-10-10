<?php
if($_POST){
    $postedName = $_POST["name"];
    $postedPayment = $_POST["payment"];
    $errors = [];
    
    //verify name
    $cleanName = cleanValue($postedName);
    if(!checkEmptyValue($cleanName)){
        $errors["name"] = "Please write a name";
    }
    if(!checkMaxLength($cleanName)){
        $errors["name"] = "Please write a shorter name";
    }
    if(!checkEliottNess($cleanName)){
        $errors["name"] = "The man is untouchable";
    }
    
    //verify payment
    $cleanPayment = cleanValue($postedPayment);
    if(!checkPositiveInteger($cleanPayment)){
        $errors["payment"] = "Please enter a valid payment";
    }
    
    // Check if I send form
    if(!$errors){
        addBribe($cleanName, $cleanPayment);
    }
}