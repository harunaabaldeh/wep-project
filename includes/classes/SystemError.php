<?php


// 100% COMPLETE
class SystemError{

    private $error_array;

    public function __construct(){
        $this->error_array = array();
        
    }

    public function pushError($error){
        if($error !== true && !in_array($error, $this->error_array)) {
            array_push($this->error_array, $error);
        }

    }


    public function getErrorWithType($error, $type) {
        $msg = "";
        if(in_array($error, $this->error_array))
        {

            if($type == 1){
                $msg = '<div class="alert alert-danger-1 col-12 col-12-xsmall alert-dismissible" role="alert"> 
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.
                $error .
                '</div>';
                return $msg;
            }

            else if($type == 2){

                return "<span class='errorMessage'>". $error . "</span>";
            }
        }
        return $msg;
    }
    

    public function getErrorCount(){
        return count($this->error_array);
    }    

}


?>