<?php

// 100% COMPLETE
class Account{


    private $con;
    private $error;

    public function __construct($con){
        $this->con = $con;
        $this->error = new SystemError();
    }

    public function login($un, $pw){

        $queries = array('SELECT id, is_admin, `password`, username, email, is_blocked FROM users WHERE username=? or email=?', 
        'SELECT id, `password`, email, business_name, is_blocked FROM businesses WHERE email=?');


        for($i = 0; $i < 2; $i++){

            $query = $queries[$i];

            $result = mysqli_query($this->con, $query);

            $stmt = mysqli_stmt_init($this->con);
    
            if(!mysqli_stmt_prepare($stmt, $query)){
                $this->error->pushError(Constants::$loginFailed);
                
            }
            else
            {
    
                if($i == 0){
                    mysqli_stmt_bind_param($stmt, "ss", $un, $un);
                }
                else if($i == 1){
                    mysqli_stmt_bind_param($stmt, "s", $un);
                }

                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
     
                if(mysqli_num_rows($result) > 0){
                
                    #get the user's password from the database
                    $row = mysqli_fetch_assoc($result);
            
                    $hashed_password = $row["password"];
        
                    if(password_verify($pw, $hashed_password))
                    {
        
                        if($row["is_blocked"] == 0){
                            $_SESSION["email"] = $row["email"];
                            $_SESSION['id'] = $row['id'];

                            // the user account
                            if($i == 0){

                                $is_admin = $row["is_admin"];
                                $_SESSION["username"] = $row["username"];
                                $_SESSION["is_admin"] = $is_admin;
            
                                if($is_admin == 0)
                                {
                                    header("Location: index.php");
                                    mysqli_stmt_close($stmt);
                                    return true;
                                }
                        
                                elseif($is_admin == 1)
                                {
                        
                                    header("Location: admin/dashboard.php");
                                    mysqli_stmt_close($stmt);
                                    return true;
                                }
                            }

                            // the business account
                            else if($i == 1){

                                $_SESSION["business_name"] = $row["business_name"];

                                header("Location: index.php");
                                mysqli_stmt_close($stmt);
                                return true;
                            }

                        }
            
                        else{
                            
                            mysqli_stmt_close($stmt);
                            $this->error->pushError(Constants::$accountBlocked);
                           
                        }
                    }
                    else
                    {
                        mysqli_stmt_close($stmt);
                        $this->error->pushError(Constants::$loginFailed);
                       
                    }
                    
            
                }

            
                
            }
      

        }


        // $this->error->pushError(Constants::$loginFailed);

    }
    
    public function getError($error, $type) {
        return $this->error->getErrorWithType($error, $type);
    }
    
    
}



?>