<?php

// COMPLETE
class User{

    private $con;
    private $id;
    private $username;
    private $email;

    private $is_admin;
    private $is_blocked;
    private $picture;
    private $register_date;

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
        $this->is_blocked = $user["is_blocked"];
        $this->picture = $user["picture"];
        $this->register_date = $user['register_date'];
        
    }



    // Higher priority methods -------------------------------------------------------------------------
    public function giveReview($business_id, $rating, $review){
        // save the stars if they are between the range 1 -5
        if($rating >= 1 && $rating <= 5){

            $query = "SELECT * FROM reviews WHERE `user_id` = '$this->id' AND `business_id` = '$business_id'";

            $result = mysqli_query($this->con, $query);
            

            $rowsCount = mysqli_num_rows($result);

            // implies new review
            // $isReviewed = Review::isReviewExist($this->con, $business_id, $this->id);
            $isReviewed = $this->isReviewExist($business_id);
            
            if(!$isReviewed){
                
                $query = " INSERT INTO reviews(`user_id`,  business_id, `rating`, `user_comment`) VALUES 
                ('$this->id', '$business_id', '$rating', ?) ";

            
            }
            // implies review edit
            else{
                $query = "UPDATE `reviews` SET `user_comment`= ?,`rating`='$rating' WHERE `user_id` = '$this->id' 
                AND business_id = '$business_id'";
            }


            $stmt = mysqli_stmt_init($this->con);

            if(!mysqli_stmt_prepare($stmt, $query)){
                exit();
            }else{

                $bind = mysqli_stmt_bind_param($stmt, "s", $review);           
                if($bind)
                {
                    mysqli_stmt_execute($stmt);
                    
                    return true;
        
                }
                else{
                    mysqli_stmt_close($stmt);
                    return false;
                }
                

            }


            return false;

        }
       
    }

    public function makeBookmark($business_id){

        $query = "INSERT INTO `bookmarks`(`user_id`, `business_id`) VALUES ('$this->id', '$business_id')";
        $result = mysqli_query($this->con, $query);
        
        if(!$result) die($this->con->error);
        return true;
    }

    public function removeBookmark($business_id){

        $query = "DELETE FROM `bookmarks` WHERE `user_id` = '$this->id' AND `business_id` = '$business_id'";
        $result = mysqli_query($this->con, $query);

        if(!$result) die($this->con->error);
        return true;
    }

    public function isBookmark($business_id){
        $query = "SELECT * FROM bookmarks WHERE `user_id` = '$this->id' AND `business_id` = '$business_id'";

        $result = mysqli_query($this->con, $query);
        

        if(mysqli_num_rows($result) > 0){
            return true;
        }
        else{
            return false;
        }
    }
    
    // check if user has a review for select business
    public function isReviewExist($business_id){
        $query = "SELECT * FROM reviews WHERE `user_id` = '$this->id' AND `business_id` = '$business_id'";

        $result = mysqli_query($this->con, $query);
        

        $rowsCount = mysqli_num_rows($result);

        if($rowsCount == 0){
            return false;
        }

        else{
            return true;
        }
    }


    public function getTotalReviewsCount(){
        $query = "SELECT * FROM reviews WHERE user_id = '$this->id'"; 
        $result = mysqli_query($this->con, $query);
        
        return mysqli_num_rows($result);
    }


    // Static methods ----------------------------------------------------------------------------------
    public static function getAllUsers($con){
        $query = "SELECT id FROM users"; 
        $result = mysqli_query($con, $query);
        
        return $result;
    }

    public static function getActiveUsers($con){
        $query = "SELECT id FROM users WHERE is_blocked = 0"; 
        $result = mysqli_query($con, $query);
        
        return $result;
    }

    public static function getBlockedUsers($con){
        $query = "SELECT id FROM users WHERE is_blocked = 1"; 
        $result = mysqli_query($con, $query);
        
        return $result;
    }
    

    
    // Getters -----------------------------------------------------------------------------------------

    public function getBookmarks(){
        $query = "SELECT business_id FROM bookmarks WHERE `user_id` = '$this->id'";
        $result = mysqli_query($this->con, $query);

        return $result;
    }


    public function getUsername()
    {
        return $this->username;
    }
    
    public function getEmail()
    {
        return $this->email;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Get the value of register_date
     */ 
    public function getRegisterDate()
    {
        return $this->register_date;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }
}

?>