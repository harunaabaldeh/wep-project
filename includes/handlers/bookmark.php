<?php
session_start();
include('../config.php');
include("../classes/Account.php");
include("../classes/Constants.php");
include("../classes/SystemError.php");

include("../handlers/sanitize.php");


include("../classes/Business.php");
include("../classes/User.php");


if(isset($_POST['status']) && isset($_SESSION['id'])){
    $status = (int) $_POST['status'];
    $business_id = $_POST['business_id'];
    $page = $_POST['page'];
    $user = new User($conn, $_SESSION['id']);

    if($status == 0){
        $user->removeBookmark($business_id);
    
    }
    else if($status == 1){
        $user->makeBookmark($business_id);
    }

    if($page == "business"){
        header("Location: ../../business.php?business_id=$business_id");
    }

    else if($page == "bookmark"){
        header("Location: ../../bookmarks.php");
    }

    else if($page == 'category'){
        $category_id = $_POST['category_id'];
        $category_name = $_POST['category_name'];
        header("Location: ../../category.php?category_id=$category_id&category_name=$category_name");
    }

}



?>