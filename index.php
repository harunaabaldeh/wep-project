<?php
session_start();
include('includes/config.php');
include("includes/classes/Constants.php");
include("includes/classes/Validation.php");
include("includes/classes/SystemError.php");

include("includes/classes/Business.php");

if(isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1){
	header("Location: admin/dashboard.php");
}

$page_title = "Vision Business Directory";


// Queries
$query = "SELECT * FROM categories";
$categories= mysqli_query($conn, $query);
$categoriesCount = mysqli_num_rows($categories);

// icons
$icons = array(
    '1' => '1.png',
    '2' => '2.png',
    '3' => '3.png',
    '4' => '4.png',
    '5' => '5.png',
    '6' => '6.png',
    'default' => 'default.png'
);

// Get top rated ..work in progress
$top_rated_ids = Business::getTopRated($conn);

// Get categories

?>

<?php require_once "includes/head.php" ?>
<!-- css files unique to this page -->
<link rel="stylesheet" href="assets/css/index.css">

</head>


<body class="layout-top-nav" style="height: auto;">

<div class="wrapper">



            <div class="subwrap1" >
                <div class="subwrap1-gradient">

                <!-- Navbar -->
                    <nav class="main-header navbar navbar-expand-md border-bottom-0 pt-4">
                        <div class="container">
                            <a href="index.php" class="navbar-brand">
                            <!-- <img alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
                            <span class="brand-text font-weight-light">Vision Business Directory</span>
                            </a>
                    
                            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                            <!-- Left navbar links -->
                            <ul class="navbar-nav">
                                <?php
                                if(isset($_SESSION["email"]) && isset($_SESSION["is_admin"]))
                                {?>
                                <li class="nav-item">
                                    <a href="bookmarks.php" class="nav-link">Bookmarks</a>
                                </li>
                                <?php 
                                }
                                else if(isset($_SESSION["email"]) && isset($_SESSION["business_name"])){
                                    ?>
                                    <li class="nav-item">
                                        <a href="business.php?business_id=<?php echo $_SESSION["id"] ?>"class="nav-link">Profile</a>
                                    </li>
                                    <?php    
                                } 
                                ?>
                            </ul>

                            </div>
                    
                            <!-- Right navbar links -->
                            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                                <!-- Messages Dropdown Menu -->
                                <?php
                                if(!isset($_SESSION["email"]))
                                {?>
                                <li class="nav-item">
                                    <a href="login.php" class="nav-link">Login</a>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="btn btn-default signup">
                                        <a href="signup.php" class="">Sign up</a>
                                    </button>
                                </li>
                                <?php 
                                } 
                                else{
                                ?>
                                <li class="nav-item">
                                    <!-- <a href="logout.php" class="nav-link">Logout</a> -->
                                    <button type="button" class="btn p-0 btn-default signup"  data-toggle="modal" data-target="#modal-default">
                                    <a href="logout.php" class="nav-link">Logout</a>
                                    </button>
                                </li>

                                <?php
                                }
                                ?>

                            </ul>
                        </div>
                    </nav>
                    <!-- /.navbar -->
                    <div class="container-fluid mt-5 pt-5">
                        <h2 class="text-center display-4 text-white mt-5">What are you looking for</h2>
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form action="search_results.php">
                                    <div class="input-group">
                                        <input type="search" class="form-control form-control-lg" name="searchText" placeholder="What">|
                                        <input type="search" class="form-control form-control-lg" name="searchText" placeholder="Where">|
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-lg btn-default base1">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>


            </div>


        
            <div class="business-categories mt-4 pb-4 px-5" style="background: inherit;">

                <section class="content mx-5 px-5">
                    <div class="card-header border-0 pb-0 mt-5">
                        <h3 class="text-center">Business Categories</h3>
                    </div>
    
    
    
                    <div class="card card-solid">
                        <div class="card-body pb-0">
                          <div class="row d-flex align-items-stretch justify-content-center">
                            <?php
                            while($row = mysqli_fetch_assoc($categories) ){
                                
                                ?>
                                
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch justify-content-center">
                                <a href="category.php?category_id=<?php echo $row['id'] ?>&category_name=<?php echo $row['category_name'] ?>">
                                    <div class="card">
                                        <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 text-center"><?php
                                                if($row['id'] <= 6){?>
                                                <img src="images/icons/<?php echo $icons[$row['id']] ?>" alt="user-avatar" class="img-fluid">
                                            
                                                
                                                <?php
                                                }
                                                else{?>
                                                <img src="images/icons/default.png" alt="user-avatar" class="img-fluid">
                                               
                                                <?php
                                                }
                                                ?>

                                            </div>

                                            <div class="col-12 text-center">
                                            <h2 class="lead pt-3"><b><?php echo $row['category_name'] ?></b></h2>

                                            </div>

                                        </div>
                                        </div>

                                    </div>
                                </a>
                            </div>                          

                            <?php
                            }
                            ?>


                          </div>
                        </div>
                        <!-- /.card-body -->

                    </div>
    
    
    
    
                </section>
    

            </div>
        
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper px-5 pb-5" style="min-height: 387px;">

                <section class="content mx-5 px-5">
                    <div class="card-header text-white border-0 pb-0 mt-5">
                        <h3 class="text-center">Top Rated Businesses</h3>
                    </div>
                    <!-- Default box -->
                    <div id="carouselExampleControls" class="carousel slide container-fluid mt-4" data-ride="carousel">


                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>

                        <div class="card-body pb-0 carousel-inner">

                            <!-- put 3 -->
                            

                            <div class="carousel-item active">
                                <div class="row d-flex align-items-stretch justify-content-center">

                                <?php
                                $j = 0;
                                for($i=0; $i < 3; $i++){
                                    $row = $top_rated_ids[$j];
                                    $business = new Business($conn, $row); 
                                    $reviewsCount = count($business->getReviews());  

                                    $j++;
                                ?>

                                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                                        <div class="card border">
                                        <div class="card-header  border-bottom-0">
                                            <span class="" style="font-size: 20px;"><?php echo $business->getBusinessName(); ?></span>
                                            
                                        
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <img src="images/businesses/<?php echo $business->getPicture(); ?>" alt="user-avatar" class="img-square img-fluid">
                                                    </div>
                                                <div class="col-12 pt-4">
                                                        <?php

                                                        
                                                            $starPercent = $business->calculateRating();
                                                        
                                                        ?>
                                                    
                                                    <div class="star-ratings-sprite float-left"><span style="width:<?php echo $starPercent; ?>%;" class="star-ratings-sprite-rating"></span></div>     
                                                    <span class='ml-2'><?php echo $reviewsCount; ?> reviews</span> 
                                                    <p class="text-muted text-sm"><b>Category: </b> <?php echo $business->getBusinessCategory(); ?> </p>
                                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address:  <?php echo $business->getLocation(); ?></li>
                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #:  <?php echo $business->getContact(); ?></li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                            <a href="business.php?business_id=<?php echo $row ?>" class="btn btn-sm">
                                                See more
                                            </a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>
                                </div>
                            </div>

                            <!-- put 3 -->
                            
                            <div class="carousel-item">
                                <div class="row d-flex align-items-stretch justify-content-center">

                                <?php

                                for($i=0; $i < 3; $i++){
                                    $row = $top_rated_ids[$j];
                                    $business = new Business($conn, $row); 
                                    $reviewsCount = count($business->getReviews());  

                                    $j++;
                                ?>

                                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                                        <div class="card border">
                                        <div class="card-header  border-bottom-0">
                                            <span class="" style="font-size: 20px;"><?php echo $business->getBusinessName(); ?></span>
                                            
                                        
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <img src="images/businesses/<?php echo $business->getPicture(); ?>" alt="user-avatar" class="img-square img-fluid">
                                                    </div>
                                                <div class="col-12 pt-4">
                                                        <?php

                                                        
                                                            $starPercent = $business->calculateRating();
                                                        
                                                        ?>
                                                    
                                                    <div class="star-ratings-sprite float-left"><span style="width:<?php echo $starPercent; ?>%;" class="star-ratings-sprite-rating"></span></div>     
                                                    <span class='ml-2'><?php echo $reviewsCount; ?> reviews</span> 
                                                    <p class="text-muted text-sm"><b>Category: </b> <?php echo $business->getBusinessCategory(); ?> </p>
                                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address:  <?php echo $business->getLocation(); ?></li>
                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #:  <?php echo $business->getContact(); ?></li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                            <a href="business.php?business_id=<?php echo $row?>" class="btn btn-sm">
                                                See more
                                            </a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>
                                </div>
                            </div>

                            <!-- put 3 -->
                            
                            
                            <div class="carousel-item">
                                <div class="row d-flex align-items-stretch justify-content-center">

                                <?php

                                for($i=0; $i < 3; $i++){
                                    $row = $top_rated_ids[$j];
                                    $business = new Business($conn, $row); 
                                    $reviewsCount = count($business->getReviews());  

                                    $j++;
                                ?>

                                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                                        <div class="card border">
                                        <div class="card-header  border-bottom-0">
                                            <span class="" style="font-size: 20px;"><?php echo $business->getBusinessName(); ?></span>
                                            
                                        
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <img src="images/businesses/<?php echo $business->getPicture(); ?>" alt="user-avatar" class="img-square img-fluid">
                                                    </div>
                                                <div class="col-12 pt-4">
                                                        <?php

                                                        
                                                            $starPercent = $business->calculateRating();
                                                        
                                                        ?>
                                                    
                                                    <div class="star-ratings-sprite float-left"><span style="width:<?php echo $starPercent; ?>%;" class="star-ratings-sprite-rating"></span></div>     
                                                    <span class='ml-2'><?php echo $reviewsCount; ?> reviews</span> 
                                                    <p class="text-muted text-sm"><b>Category: </b> <?php echo $business->getBusinessCategory(); ?> </p>
                                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address:  <?php echo $business->getLocation(); ?></li>
                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #:  <?php echo $business->getContact(); ?></li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                            <a href="business.php?business_id=<?php echo $row ?>" class="btn btn-sm">
                                                See more
                                            </a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>
                                </div>
                            </div>

                        </div>


                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <!-- /.card -->
                
                </section>







            </div>

<!-- 
            <div class="content-wrapper" style='background:white;'>

            about us
            </div> -->

    <!-- Footer -->
    <?php require_once "includes/footer.php" ?>   
</div>


<!--                        MODALS                                       -->



<!-- Scripts -->
<?php require_once "includes/footer_scripts.php" ?>


<!-- password verfication with javascript check later -->
</body>
</html>

