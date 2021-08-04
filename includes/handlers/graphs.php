<?php
session_start();
include('../config.php');
include("../classes/Account.php");
include("../classes/Constants.php");
include("../classes/Validation.php");
include("../classes/SystemError.php");

include("../handlers/sanitize.php");


include("../classes/Business.php");

if($_POST['type'] == 1){
    $query = "SELECT * FROM categories";
    $categories= mysqli_query($conn, $query);

   
    $data = array();

    while($row = mysqli_fetch_assoc($categories) ){
    $category_id = $row['id'];
    $query = "SELECT * FROM categories INNER JOIN businesses ON businesses.business_category = categories.id
        WHERE categories.id = '$category_id'";
    
    $result = mysqli_query($conn, $query);

    $data[$row['category_name']] = mysqli_num_rows($result);

    }

    echo json_encode($data);
}
if($_POST['type'] == 2){
    



    $query = "SELECT DISTINCT email FROM reviews INNER JOIN users ON reviews.user_id = users.id";
    $activeUsersCount = mysqli_num_rows(mysqli_query($conn, $query)) ;
    

    $query = "SELECT * FROM users";
    $allUsersCount = mysqli_num_rows(mysqli_query($conn, $query)) ;
   
    $query = "SELECT DISTINCT email FROM bookmarks INNER JOIN users ON bookmarks.user_id = users.id";
    $bookmarkUsersCount = mysqli_num_rows(mysqli_query($conn, $query)) ;
    


    $data = array(
        'Active Users' => $activeUsersCount,
        'Passive Users' => ($allUsersCount - $activeUsersCount),
        'Users with bookmarks' => $bookmarkUsersCount
    );
    
   
    echo json_encode($data);
}

if($_POST['type'] == 3){
    $query = "SELECT * FROM businesses";
    $businesses= mysqli_query($conn, $query);

    $data = array();

    while($row = mysqli_fetch_assoc($businesses) ){
        $business = new Business($conn, $row['id']);


        $rating =  number_format($business->calculateRating(), 2);
        if($rating > 0){
            $data[$row['business_name']] = $rating;
        }
       
    
    }
   
    echo json_encode($data);
}
?>