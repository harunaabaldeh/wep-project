<?php
session_start();
include('../config.php');
include("../classes/Account.php");
include("../classes/Constants.php");
include("../classes/Validation.php");
include("../classes/SystemError.php");

include("../handlers/sanitize.php");


include("../classes/Business.php");
include("../classes/User.php");


if(isset($_POST['reply']) && isset($_POST['user_id']) && isset($_SESSION['business_name'])){

    $reply = strip_tags($_POST['reply']);
    $user_id = $_POST['user_id'];

    $business_id = $_SESSION['id'];
    
    $business = new Business($conn, $business_id);


    $success = $business->replyToReview($user_id, $reply);
    
    
    if($success){
        header("Location: ../../business.php?business_id=$business_id");
    }

}




?>