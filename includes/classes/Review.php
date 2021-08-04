<?php

// 100% COMPLETE
class Review{

    private $con;
    private $id;
    private $business_id;
    private $rating;
    private $user_id;
    private $user_comment;
    private $business_reply;
    private $review_date;
    private $reply_date;

    public function __construct($con, $id){
        $this->con = $con;

        $this->id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        // Fetch the reveiw with this business id and user id
        $query = "SELECT * FROM reviews WHERE id = '$this->id'";
        $result = mysqli_query($this->con, $query);
        $review = mysqli_fetch_array($result);

        if(!$result) die($this->con->error);

        $this->business_id = $review['business_id'];
        $this->user_id = $review['user_id'];
        $this->user_comment = $review["user_comment"];
        $this->rating = $review['rating'];
        $this->business_reply = $review["business_reply"];
        $this->reply_date = $review['reply_date'];
        $this->review_date = $review["review_date"];
    }


    // STATIC METHODS
    // check if a user has a review for select business
    public static function isReviewExist($con, $business_id, $user_id){
        $query = "SELECT * FROM reviews WHERE `user_id` = '$user_id' AND `business_id` = '$business_id'";

        $result = mysqli_query($con, $query);
        

        $rowsCount = mysqli_num_rows($result);

        if($rowsCount == 0){
            return false;
        }

        else{
            return true;
        }
    }
    
    public static function getStaticRating($con, $business_id, $user_id){

    }

    // get the a user's review for select business
    public static function getStaticReview($con, $business_id, $user_id){
        $isReviewed = Review::isReviewExist($con, $business_id, $user_id);
        
        if(!$isReviewed){

            return '';
        }
        else{

            $query = "SELECT `user_comment` FROM reviews WHERE `user_id` = '$user_id' 
            AND `business_id` = '$business_id'";
            $result = mysqli_query($con, $query);
            $review = mysqli_fetch_array($result);
    
            if(!$result) die($con->error);
    
            return trim($review['user_comment']);
        }
    }


    // GETTERS

    public function getUsername(){
        $query = "SELECT `username` FROM users WHERE id = '$this->user_id'";
        $result = mysqli_query($this->con, $query);
        $user = mysqli_fetch_array($result);

        if(!$result) die($this->con->error);

        return $user['username'];
    }


    /**
     * Get the value of business_reply
     */ 
    public function getBusinessReply()
    {
        return $this->business_reply;
    }

    /**
     * Get the value of user_comment
     */ 
    public function getUserComment()
    {
        return $this->user_comment;
    }
    

    /**
     * Get the value of rating
     */ 
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Get the value of review_date
     */ 
    public function getReviewDate()
    {
        return $this->review_date;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Get the value of reply_date
     */ 
    public function getReplyDate()
    {
        return $this->reply_date;
    }
}

?>