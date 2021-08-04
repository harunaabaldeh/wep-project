<?php

// 100% COMPLETE
class Validation{

    private $con;
   

    public function __construct($con){
        $this->con = $con;
        
    }

    
    public function validateUsername($column, $table, $username) {

        if(strlen($username) > 25 || strlen($username) < 5) {
            return Constants::$usernameCharacters;
        }

        // make le query an array
        $query = "SELECT " . $column . " FROM " . $table . " WHERE username='$username'";
        $result = mysqli_query($this->con, $query);

        if(mysqli_num_rows($result) != 0) {
            
            return Constants::$usernameTaken;
        }

        return true;

    }

    public function validateEmail($column, $table, $em) {

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {

            return Constants::$emailInvalid;
        }
        
        $query = "SELECT " . $column . " FROM " . $table . " WHERE email='$em'";
        $result = mysqli_query($this->con, $query);
        if(mysqli_num_rows($result) != 0) {
            
            return Constants::$emailTaken;
        }

        return true;

    }

    public function validatePasswords($pw1, $pw2) {
		
        if($pw1 != $pw2) {
          
            return Constants::$passwordsDoNoMatch;
        }

        if(strlen($pw1) > 30 || strlen($pw1) < 5) {

            return Constants::$passwordCharacters;
        }

        return true;

    }

    public function validateEmailUpdate($column, $table, $em, $id){

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {

            return Constants::$emailInvalid;
        }
        $query = "SELECT " . $column . " FROM " . $table . " WHERE email='$em' AND id <>'$id'";
        $result = mysqli_query($this->con, $query);
        if(mysqli_num_rows($result) != 0) {
            
            return Constants::$emailTaken;
        }

        return true;
    }


}


?>