<?php

// 100% COMPLETE
class BusinessSignup implements iSignup{

    private $con;
    private $business_name;

    private $email;
    private $password1;
    private $password2;
    private $hashed_password;

    private $business_category;
    private $opening_hours;
    private $contact;
    private $location;
    private $about;
    private $picture;

    private $error;
    private $validation;

    
    public function __construct($con, $business_name, $email, $password1, $password2, $opening_hours,
    $business_category, $contact, $location, $about, $picture){
        $this->con = $con;
        $this->business_name = $business_name;
        $this->email = $email;
        $this->password1 = $password1;
        $this->password2 = $password2;
        $this->hashed_password = password_hash($password1, PASSWORD_DEFAULT);

        $this->opening_hours = $opening_hours;
        $this->business_category = filter_var($business_category, FILTER_SANITIZE_NUMBER_INT);
        $this->location = $location;
        $this->contact = $contact;
        $this->about = $contact;
        $this->picture = $picture;

        $this->error = new SystemError();
        $this->validation = new Validation($this->con);
        
    }


    public function register(){

        $this->error->pushError($this->validation->validateEmail('email', 'businesses', $this->email));
        $this->error->pushError($this->validation->validatePasswords($this->password1, $this->password2));
        $this->error->pushError($this->uploadImage());


        if($this->error->getErrorCount() == 0) {
            //Insert into db
            return $this->sendDetails();
        }
        else {
            return false;
        }

    }

    public function sendDetails(){
        $query = "INSERT INTO businesses(business_name, email, `password`, opening_hours, business_category, 
        `location`, contact, about, picture) VALUES (?, '$this->email', '$this->hashed_password', ?, '$this->business_category', ? ,
        '$this->contact', ?, '$this->picture')";

        // $query = "INSERT INTO businesses(business_name, email, `password`, opening_hours, business_category, 
        // `location`, contact, about, picture) VALUES ('$this->business_name', '$this->email', '$this->hashed_password', '$this->opening_hours', '$this->business_category',
        //     '$this->location', '$this->contact', '$this->about', '$this->picture')";

        // echo $query . '<br> '; 
        // $result = mysqli_query($this->con, $query);
        // $business = mysqli_fetch_array($result);

        // if(!$result) die($this->con->error);
        $stmt = mysqli_stmt_init($this->con);

        if(!mysqli_stmt_prepare($stmt, $query)){
            exit();
        }else{

            $bind = mysqli_stmt_bind_param($stmt, "ssss", $this->business_name, $this->opening_hours, $this->location, $this->about);           
            if($bind)
            {
                mysqli_stmt_execute($stmt);
                $query = "SELECT id FROM businesses WHERE email = '$this->email'";
                $result = mysqli_query($this->con, $query);
                $business = mysqli_fetch_array($result);
        
                if(!$result) die($this->con->error);
                
                $_SESSION["id"] = $business["id"];
                $_SESSION["email"] = $this->email;
                $_SESSION["business_name"] = $this->business_name;
                mysqli_stmt_close($stmt);
                return true;
     
            }
            

        }

    }

    public function getError($error, $type){
        return $this->error->getErrorWithType($error, $type);
    }

    private function uploadImage(){
        if(is_uploaded_file($this->picture['tmp_name']))
        {
            $picName = $this->picture["name"];
            $picType = $this->picture["type"];
            $picTmp_Name = $this->picture["tmp_name"];
            $picSize = $this->picture["size"];
            $picError = $this->picture["error"];
    
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

    
                        //move the file to the destination
                        move_uploaded_file($picTmp_Name, $picFinalPath);
                        $this->picture = $newPicName;
                        return true;
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
        
        
        return Constants::$genericError;
    }
}


?>