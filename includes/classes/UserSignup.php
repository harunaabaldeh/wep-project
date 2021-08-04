<?php

// 100% COMPLETE
class UserSignup implements iSignup{

    private $con;
    private $username;
    private $email;
    private $password1;
    private $password2;
    private $hashed_password;
    private $error;
    private $validation;


    public function __construct($con, $username, $email, $password1, $password2){
        $this->con = $con;
        $this->username = $username;
        $this->email = $email;
        $this->password1 = $password1;
        $this->password2 = $password2;
        $this->hashed_password = password_hash($password1, PASSWORD_DEFAULT);
        $this->error = new SystemError();
        $this->validation = new Validation($this->con);
        
    }


    public function register(){
        

        $this->error->pushError($this->validation->validateUsername('username', 'users',$this->username));
        $this->error->pushError($this->validation->validateEmail('email', 'users', $this->email));
        $this->error->pushError($this->validation->validatePasswords($this->password1, $this->password2));

        if($this->error->getErrorCount() == 0) {
            //Insert into db
            return $this->sendDetails();
        }
        else {
            return false;
        }
    }

    public function sendDetails(){

        $query = "INSERT INTO users(username,  email, `password`) VALUES (?, ?, ?)";
        
        $stmt = mysqli_stmt_init($this->con);

        if(!mysqli_stmt_prepare($stmt, $query)){
            exit();
        }else{

            mysqli_stmt_bind_param($stmt, "sss", $this->username, $this->email, $this->hashed_password);
            mysqli_stmt_execute($stmt);

            $_SESSION["email"] = $this->email; 
            $_SESSION["is_admin"] = 0; 
            $_SESSION["username"] = $this->username;

            $query = "SELECT id FROM users WHERE email = '$this->email'";
            $result = mysqli_query($this->con, $query);
            $user = mysqli_fetch_array($result);
    
            if(!$result) die($this->con->error);
            $_SESSION["id"] = $user["id"];

            header("Location: index.php");

            
        }
    }

    public function getError($error, $type){

        return $this->error->getErrorWithType($error, $type);
    }
}


?>