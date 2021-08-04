<?php
session_start();
include('../config.php');
include("../classes/Account.php");
include("../classes/Constants.php");
include("../classes/SystemError.php");

include("../handlers/sanitize.php");


include("../classes/Business.php");
include("../classes/User.php");


if(isset($_POST['rating']) && isset($_POST['review']) && isset($_SESSION['id'])){
    $rating = $_POST['rating'];
    $review = strip_tags($_POST['review']);
    $business_id = $_POST['business_id'];
  
    $user = new User($conn, $_SESSION['id']);

    $success = $user->giveReview($business_id, $rating, $review);
    
    if($success){
        header("Location: ../../business.php?business_id=$business_id");
    }

}


?>