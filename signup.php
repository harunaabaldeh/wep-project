<?php
session_start();
include('includes/config.php');
include("includes/classes/Constants.php");
include('includes/classes/iSignup.php');
include("includes/classes/Validation.php");
include("includes/classes/SystemError.php");

include("includes/classes/UserSignup.php");
include("includes/classes/BusinessSignup.php");
include("includes/handlers/sanitize.php");

if(isset($_SESSION["email"])) {

	
	// redirect to the index page
	if($_SESSION["isAdmin"] == 0){
		header("Location: index.php");
	}
	else if($_SESSION["isAdmin"] == 1){
		header("Location: admin/dashboard.php");
	}

}

$page_title = "Sign up";

$userSignup = '';
$businessSignup = '';
$success = '';



// Business Signup
if(isset($_POST['business_name']) && isset($_POST['submit'])){
	$business_name = sanitizeFormName($_POST["business_name"]);
    $email = sanitizeFormOther($_POST['email']);

	$password1 = sanitizeFormPassword($_POST['password1']);
	$password2 = sanitizeFormPassword($_POST['password2']);
    
    
    $business_category = $_POST['business_category'];
    $opening_hours = strip_tags($_POST['opening_hours']);
    $contact = strip_tags($_POST['contact']);
    $location = strip_tags($_POST['location']);
    $about = strip_tags($_POST['about']);
   
    $picture = $_FILES['picture'];

    $businessSignup = new BusinessSignup($conn, $business_name, $email, $password1, $password2, 
    $opening_hours, $business_category, $contact, $location, $about, $picture);

	$success = $businessSignup->register();

	if($success == true) {

		header("Location: index.php");
    }
    



}



// User Sigup
if(isset($_POST['username']) && isset($_POST["email"]) && isset($_POST['password1']) && isset($_POST['password2']))
{
	//Register button was pressed

	$username = strip_tags($_POST["username"]);

	
	$email = sanitizeFormOther($_POST['email']);
	$password1 = sanitizeFormPassword($_POST['password1']);
	$password2 = sanitizeFormPassword($_POST['password2']);

    $userSignup = new UserSignup($conn, $username, $email, $password1, $password2);

	$success = $userSignup->register();

	// if($success == true) {
        
	// 	header("Location: index.php");
	// }

	
}



?>

<?php require_once "includes/head.php" ?>
<!-- css files unique to this page -->
<link rel="stylesheet" href="assets/css/index.css">

</head>
<style>
body{
background: url('images/bg3.jpg') center center;
        background-size: cover;  
}
</style>

<body class="layout-top-nav" style="height: auto;">


<div class="wrapper">


    <?php require_once "includes/navbar.php" ?>

</div>


<div class="login-page">

        <div class="container">

            <div class="row d-flex justify-content-center">
                <div id='businessCard' class="card col card-outline card-dark" style='display:none; height: 650px; overflow-y: scroll;'>
                    <div class="card-body">
                    <h3 class="login-box-msg">Register as a business</h3>

                    <div class="card border-0">

                        <div class="card-body register-card-body">
                            <form action="signup.php" method="post" enctype="multipart/form-data"  >
                        
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name='business_name' placeholder="Business Name">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-building"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="email" class="form-control" name='email' placeholder="Email">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>


                                <?php if($success === false && $businessSignup != ''){
                                    echo $businessSignup->getError(Constants::$passwordCharacters, 1);
                                    echo $businessSignup->getError(Constants::$passwordsDoNoMatch, 1);
                                    }
                                ?>                                
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" name='password1' placeholder="Password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" name='password2' placeholder="Retype password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <select class="form-control" name='business_category' placeholder="Category">
                                        <option value="">Select Category</option> 
                                        <?php
                                        // Queries
                                        $query = "SELECT * FROM categories ORDER BY category_name";
                                        $categories= mysqli_query($conn, $query);

                                        while($row = mysqli_fetch_assoc($categories)){?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['category_name'] ?></option>
                                        <?php
                                        }  
                                        ?>

                                        
                                    </select>
                                    
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-building"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name='location' placeholder="Location">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-map-marker-alt"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name='contact' placeholder="Contact">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-phone-alt"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Opening Hours -->
                                <div class="input-group mb-3">
                                    <textarea class="form-control" name='opening_hours' placeholder="Opening hours" style=' height: 75px;'></textarea>
                                </div>

                                <!-- About -->
                                <div class="input-group mb-3">
                                    <textarea class="form-control" name='about' placeholder="About the business" style=' height: 75px;'></textarea>
                                </div>
                                

                                <?php if($success === false && $businessSignup != ''){
                                    echo $businessSignup->getError(Constants::$genericError, 1);
                                    }
                                ?>      
                                <!-- Upload Pic -->
                                <div class="input-group mb-3">
                                  

                                    <div class="image-container mx-auto">
                                        <div class="image-wrapper">
                                            <div id='image' class="image">
                                                <!-- <img id='selectedImage' src="" alt=""> -->
                                            </div>

                                            <div id="cancel-btn"><i class="fas fa-times"></i></div>
                                            <div class="file-name" >File name here</div>
                                        </div>

                                    </div>



                                </div>

                                <div class="input-group">
                                    <label for="file"> Select Image</label>
                                    <input id="file" name='picture' type="file" onchange='showSelected()' hidden>

                                </div>

                                <div class="row">
                                <div class="col-12">
                                    
                                    <p class='pt-5'>
                                    By signing up you are agreeing to our <a href="#" style='color: #802bb1;'>terms and condition</a>
                                    </p>
                                </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-12">
                                    <button type="submit" name='submit' class="btn btn-default btn-block base1">Register</button>
                                </div>
                                <!-- /.col -->
                                </div>
                            </form>
                        </div>
                        
                        <div class="card-footer text-center">
                            <a href="#" id='toUserCard' class="" style='color: #802bb1;'>Sign up as a user instead</a>
                        </div>
                    <!-- /.form-box -->
                    </div>

                    <!-- /.card-body -->
                </div>




                <div id='userCard' class="card card-outline card-dark">
                    <div class="card-header text-center">
                    <h3 class="login-box-msg">Sign up as a User</h3>
                    </div>

                    <div class="card border-0">


                        <!-- <div class="card-header border-0">
                            <div class="float-left">
                            
                                <a href="#" class="btn btn-block btn-primary text-white">
                                <i class="fab fa-facebook mr-2"></i>
                                Sign up using Facebook
                                </a>

                            </div>

                            <div class="float-right">

                                <a href="#" class="btn btn-block btn-danger text-white">
                                <i class="fab fa-google-plus mr-2"></i>
                                Sign up using Google+
                                </a>
                            </div>

                        </div>
                        <p class="text-center">- OR -</p> -->


                        <div class="card-body register-card-body">
                            <form action="signup.php" method="post">
                                <?php if($success === false && $userSignup != ''){
                                    echo $userSignup->getError(Constants::$usernameCharacters, 1);
                                    }
                                ?>                            
                                <div class="input-group mb-3">
                                <input type="text" class="form-control" name='username' placeholder="Username">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                    </div>
                                </div>
                                </div>

                                <?php if($success === false && $userSignup != ''){
                                    echo $userSignup->getError(Constants::$emailInvalid, 1);
                                    echo $userSignup->getError(Constants::$emailTaken, 1); 
                                    }
                                ?>
                                <div class="input-group mb-3">
                                <input type="email" class="form-control" name='email' placeholder="Email">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                                </div>

                                <?php if($success === false && $userSignup != ''){
                                    echo $userSignup->getError(Constants::$passwordCharacters, 1);
                                    echo $userSignup->getError(Constants::$passwordsDoNoMatch, 1);
                                    }
                                ?>
                                <div class="input-group mb-3">
                                <input type="password" class="form-control" name='password1' placeholder="Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                </div>
                                <div class="input-group mb-3">
                                <input type="password" class="form-control" name='password2' placeholder="Retype password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-12">
                                    
                                    <p>
                                    By signing up you are agreeing to our <a href="#" style='color: #802bb1;'>terms and condition</a>
                                    </p>
                                </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-12">
                                    <button type="submit" class="btn btn-default btn-block base1">Register</button>
                                </div>
                                <!-- /.col -->
                                </div>
                            </form>
                        </div>
                        
                        <div class="card-footer text-center">
                            <a href="#" id='toBusinessCard' class="" style='color: #802bb1;'>Sign up as a business instead</a>
                        </div>
                    <!-- /.form-box -->
                    </div>



                </div>




            
            </div>



        </div>

</div>




<!--                        MODALS                                       -->



<!-- Scripts -->
<?php require_once "includes/footer_scripts.php" ?>

<script>
    $(document).ready(function () {

        $("#toBusinessCard").click(function(){
        
            $("#userCard").hide();
            $("#businessCard").fadeIn();
        });
        
        $("#toUserCard").click(function(){
        
            $("#businessCard").hide();
            $("#userCard").fadeIn();
        
    });
    });

</script>

<script>
    showSelected = function() {
        var input = document.getElementById('file');
        var upload_div = document.getElementById('image');

        console.log(URL.createObjectURL(input.files[0]));
        upload_div.innerHTML = '<img class="px-2" src=' + URL.createObjectURL(input.files[0]) + ' alt=' + input.files.item(0).name  +' >';
       
    }
</script>
<!-- password verfication with javascript check later -->
</body>
</html>

