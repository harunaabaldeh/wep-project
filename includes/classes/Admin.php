<?php

// 0% COMPLETE
class Admin{


    private $con;
    private $id;
    private $username;
    private $email;

    private $is_admin;
    private $picture;

    private $error;

    public function __construct($con, $id){
        $this->con = $con;
        $this->error = new SystemError();
        
        $this->id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        
        // Fetch the user with this id
        $query = "SELECT * FROM users WHERE id = '$this->id'";
        $result = mysqli_query($this->con, $query);
        $user = mysqli_fetch_array($result);

        if(!$result) die($this->con->error);
        $this->username = $user["username"];
        $this->email = $user["email"];
        $this->is_admin = $user["is_admin"];
       
        $this->picture = $user["profile_pic"];
        
    }
    

    public function approveBusiness($business_id){
        $query = "UPDATE `businesses` SET `is_verified`= 1, is_blocked = 0  WHERE id = '$business_id'";
        
        mysqli_query($this->con, $query);
    
    }

    public function blockBusiness($business_id){
        $query = "UPDATE `businesses` SET is_blocked = 1  WHERE id = '$business_id'";
        // echo $query;
        mysqli_query($this->con, $query);
    }

    public function addCategory($new_name){
        $query = "INSERT INTO `categories`(`category_name`) VALUES ('$new_name')";
        mysqli_query($this->con, $query);
    
    }

    public function editCategory($category_id, $new_name){

        $query = "UPDATE `categories` SET `category_name`='$new_name' WHERE id='$category_id'";
        mysqli_query($this->con, $query);

    }

    public function unBlockUser($user_id){

        $query = "UPDATE `users` SET is_blocked = 0  WHERE id = '$user_id'";
        mysqli_query($this->con, $query);
      
    }
    public function blockUser($user_id){

        $query = "UPDATE `users` SET is_blocked = 1  WHERE id = '$user_id'";
        mysqli_query($this->con, $query);
      
    }

    // GETTERS 


    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the value of picture
     */ 
    public function getPicture()
    {
        return $this->picture;
    }


}


?>