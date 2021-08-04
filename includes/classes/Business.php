<?php

// 100% COMPLETE
class Business{

    private $con;
    private $id;
    private $business_name;

    private $email;

    private $business_category;
    private $opening_hours;
    private $contact;
    private $location;
    private $about;
    private $picture;
    private $is_verified;
    private $is_blocked;

    private $error;
    private $validation;

    public function __construct($con, $id){
        $this->con = $con;
        $this->error = new SystemError();
        $this->validation = new Validation($this->con);

        $this->id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        
        // Fetch the business with this id
        $query = "SELECT * FROM businesses WHERE id = '$this->id'";
        $result = mysqli_query($this->con, $query);
        $business = mysqli_fetch_array($result);

        if(!$result) die($this->con->error);
        $this->business_name = $business["business_name"];
        $this->email = $business["email"];
        $this->business_category = $business['business_category'];
        $this->opening_hours = trim($business['opening_hours']);
        $this->contact = $business['contact'];
        $this->location = $business['location'];
        $this->about = $business['about'];


        $this->is_verified = $business['is_verified'];
        $this->is_blocked = $business["is_blocked"];
        $this->picture = $business["picture"];
    }


    // Higher priority methods -------------------------------------------------------------------------
    public function replyToReview($user_id, $reply){

        $current_time = date("Y-m-d H:i:s");

        $query = "UPDATE `reviews` SET `business_reply`= ?, reply_date = '$current_time' WHERE `user_id` = '$user_id' 
                AND business_id = '$this->id'";

        $stmt = mysqli_stmt_init($this->con);

        if(!mysqli_stmt_prepare($stmt, $query)){
            exit();
        }else{

            $bind = mysqli_stmt_bind_param($stmt, "s", $reply);           
            if($bind)
            {
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                return true;
    
            }
            else{
                mysqli_stmt_close($stmt);
                return false;
            }
            

        }


        return false;
    }

    public function editProfile($business_name, $email, $opening_hours,
    $business_category, $contact, $location, $about, $picture){


        $this->business_name = $business_name;
        $this->email = $email;
       
        $this->opening_hours = $opening_hours;
        $this->business_category = filter_var($business_category, FILTER_SANITIZE_NUMBER_INT);
        $this->location = $location;
        $this->contact = $contact;
        $this->about = $about;
        $temp_picture = $picture;

        // do image check last.. always unlink and resave
        $this->error->pushError($this->validation->validateEmailUpdate('email', 'businesses', $this->email, $this->id));
        $this->error->pushError($this->updateImage($temp_picture));

        // echo $this->error->getErrorCount();
        if($this->error->getErrorCount() == 0) {
            //Insert into db
            return $this->sendUpdates();

        }
        else {
            return false;
        }

    }

    private function sendUpdates(){
        $query = "UPDATE businesses SET
        `business_name`= ?, `opening_hours`=?, `location`=?,`about`=?, 
        `business_category`='$this->business_category',`email`='$this->email',
        `contact`='$this->contact' WHERE `id` = '$this->id'";

        $stmt = mysqli_stmt_init($this->con);

        if(!mysqli_stmt_prepare($stmt, $query)){
            exit();
        }else{

            mysqli_stmt_bind_param($stmt, "ssss", $this->business_name, $this->opening_hours, $this->location, $this->about);           
            mysqli_stmt_execute($stmt);
        
            
            mysqli_stmt_close($stmt);
            return true;
    
            
            

        }

        return false;

    }

    private function updateImage($temp_picture){

        if(is_uploaded_file($temp_picture['tmp_name']))
        {
            $picName = $temp_picture["name"];
            $picType = $temp_picture["type"];
            $picTmp_Name = $temp_picture["tmp_name"];
            $picSize = $temp_picture["size"];
            $picError = $temp_picture["error"];
    
            //get the uploaded pic's extension
            $picExt = explode(".", $picName);
            $uploadedPicExten = strtolower(end($picExt)); 
            
            //specify extensions
            $allowedExten = array("jpg", "jpeg", "png");
    
            if(in_array($uploadedPicExten, $allowedExten)){
                if($picError === 0){
                    if($picSize < 100000000){
                        //start the file upload
    
                        //create a unique id using the uniqid function which inturns works with the time function
                        $newPicName = uniqid("", true). "." . $uploadedPicExten;

                        $picFinalPath = "images/businesses/" . $newPicName;

                        

                        //upload  to database
                        $query = "UPDATE businesses SET picture='$newPicName' 
                        WHERE id = '$this->id' ";
                       
                       $stmt = mysqli_stmt_init($this->con);

                       if(!mysqli_stmt_prepare($stmt, $query)){
                           exit();
                       }else{

                            if(mysqli_stmt_execute($stmt)){

                                $old_pic = "images/businesses/" . $this->picture;
                                unlink($old_pic);
        
                                //move the file to the destination
                                move_uploaded_file($picTmp_Name, $picFinalPath);
                                $this->picture = $newPicName;
        
        
                                return true;
                            }
                           
                       }
                        

                    }
                    else{
    
                        return Constants::$genericError;
                    }
    
                }
    
                else{
                    return Constants::$genericError;
                }
            }
    
            else{
                return Constants::$genericError;
            }
    
        }
        
        return true;
        
       
    }

    public function calculateRating(){
        // get all the stars for this Business
        $query = "SELECT rating FROM reviews WHERE `business_id` = '$this->id'"; 
        $result = mysqli_query($this->con, $query);
        $total_reviews = mysqli_num_rows($result);
        $average = 0;
       

        if($total_reviews > 0){
            $count = 0;
            while($row = mysqli_fetch_assoc($result)){
                $count += (int) $row['rating'];
            }
            // find their average and return that
            $average = $count / $total_reviews;
        }
        
        $percent = ($average / 5) * 100;
        
       
        return $percent;
    }

    // Static methods ----------------------------------------------------------------------------------

    // return the ids of the top rated businesses
    public static function getTopRated($con){

      
        $query = "SELECT id FROM businesses WHERE is_verified = 1 AND is_blocked = 0"; 
        $result = mysqli_query($con, $query);
        $ratings = array();
        while($row = mysqli_fetch_assoc($result)){

            $business = new Business($con, $row['id']);
            
            $entry = round($business->calculateRating()) . '.' . $row['id'];
            // echo $entry . ' ' ;
            array_push($ratings, $entry);
            
        }
        arsort($ratings);
        $ratings = array_slice($ratings, 0, 9);
        $topRatedIds = array();

        for($i=0; $i < count($ratings); $i++) {

            $start_pos = strpos($ratings[$i], '.') + 1;

            $index = substr($ratings[$i], $start_pos); 
            
            array_push($topRatedIds, $index);
 
          }
        
        return $topRatedIds;

    }

    public static function getAllUnderCategory($con, $category_id){
        $query = "SELECT id FROM businesses WHERE business_category = '$category_id' AND is_verified = 1 AND is_blocked = 0"; 
        $result = mysqli_query($con, $query);
        // $business_ids = mysqli_fetch_array($result);
        
        return $result;
    }
    
    public static function getAllBusinesses($con){
        $query = "SELECT id FROM businesses"; 
        $result = mysqli_query($con, $query);
        
        return $result;
    }

    public static function getPendingApprovals($con){
        $query = "SELECT id FROM businesses WHERE is_verified = 0 AND is_blocked = 0"; 
        $result = mysqli_query($con, $query);

        return $result;
    }
    
    public static function getApprovedBusinesses($con){
        $query = "SELECT id FROM businesses WHERE is_verified = 1 AND is_blocked = 0"; 
        $result = mysqli_query($con, $query);

        return $result;
    }

    public static function getBlockedBusinesses($con){
        $query = "SELECT id FROM businesses WHERE is_blocked = 1"; 
        $result = mysqli_query($con, $query);

        return $result;

    }



    // Getters ------------------------------------------------------------------------------------------
    

    public function getReviews(){
        $query1 = "SELECT * FROM reviews WHERE business_id = '$this->id'"; 
        $result1 = mysqli_query($this->con, $query1);
        $temp_array = array();
        $temp_start = '';
      
        // $test = mysqli_fetch_assoc($result1);
        while($row =  mysqli_fetch_assoc($result1)){

            if(isset($_SESSION['id']) && $row['user_id'] == $_SESSION['id']){
             
                $temp_start =$row['id'] ;
            }
            else{
                array_push($temp_array, $row['id']);
            }
            
        }
        // var_dump($temp_array);
        if($temp_start != ''){
            array_push($temp_array, $temp_start);
            $temp_array = array_reverse($temp_array);
        }


        return $temp_array;
        
    }

    public function getBusinessName(){

        return $this->business_name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getBusinessCategory()
    {
        $query = "SELECT category_name FROM categories WHERE id = '$this->business_category'";
        $result = mysqli_query($this->con, $query);
        $category = mysqli_fetch_array($result);

        return $category['category_name'];
    }

    public function getOpeningHours()
    {
        return $this->opening_hours;
    }

    public function getContact()
    {
        return $this->contact;
    }
 
    public function getLocation()
    {
        return $this->location;
    }

    public function getAbout()
    {
        return $this->about;
    }

    public function getPicture()
    {
        return $this->picture;
    }
    
    public function getError($error, $type)
    {
        return $this->error->getErrorWithType($error, $type);
    }

    /**
     * Get the value of is_verified
     */ 
    public function getIsVerified()
    {
        return $this->is_verified;
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