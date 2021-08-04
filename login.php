<?php
session_start();
include('includes/config.php');
include("includes/classes/Constants.php");
include("includes/classes/Validation.php");
include("includes/classes/SystemError.php");


include("includes/handlers/sanitize.php");

include("includes/classes/Account.php");



if(isset($_SESSION["email"])) {

	
	// redirect to the index page
	if($_SESSION["isAdmin"] == 0){
		header("Location: index.php");
	}
	else if($_SESSION["isAdmin"] == 1){
		header("Location: admin/dashboard.php");
	}

}
$page_title = "Login";



$account = new Account($conn);



if(isset($_POST['usernameOrEmail'])){
	$username =  sanitizeFormOther($_POST["usernameOrEmail"]);
	$password = $_POST['password'];    

    $result = $account->login($username, $password);


}
?>

<?php require_once "includes/head.php" ?>
<!-- css files unique to this page -->
</head>


<style>
body{
background: url('images/bg3.jpg') center center;
        background-size: cover;  
}
</style>
<body class="layout-top-nav " style="height: auto;">






<div class="wrapper">


    <?php require_once "includes/navbar.php" ?>

</div>


<div class="login-page" style=''>

        <div class="login-box">
        <!-- /.login-logo -->
            <div class="card text-dark">
                <div class="card-body login-card-body">


                    <?php echo $account->getError(Constants::$loginFailed, 1); ?>
                    <?php echo $account->getError(Constants::$accountBlocked, 1); ?>
                    <form action="login.php" method="post">
                        <div class="input-group mb-3">

                            <input type="text" name='usernameOrEmail' class="form-control" placeholder="Username or Email">
                            <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                            </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name='password' class="form-control" placeholder="Password">
                            <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-default btn-block base1">Login</button>
                        </div>
                        <!-- /.col -->
                        </div>
                    </form>

                    <!-- <div class="social-auth-links text-center mb-3">
                        <p>- OR -</p>
                        <a href="#" class="btn btn-block btn-primary text-white">
                        <i class="fab fa-facebook mr-2"></i> Login using Facebook
                        </a>
                        <a href="#" class="btn btn-block btn-danger text-white">
                        <i class="fab fa-google-plus mr-2"></i> Login using Google+
                        </a>
                    </div> -->
                <!-- /.social-auth-links -->
                </div>

                <div class="card-footer text-center">
                    Not a member yet? <a href='signup.php' style='color: #802bb1;' >Register here</a>
                </div>

            <!-- /.login-card-body -->
            </div>



        </div>

</div>





<!--                        MODALS                                       -->



<!-- Scripts -->
<?php require_once "includes/footer_scripts.php" ?>


<!-- password verfication with javascript check later -->
</body>
</html>

