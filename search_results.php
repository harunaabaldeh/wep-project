<?php
session_start();
include('includes/config.php');

include("includes/classes/Review.php");
include("includes/classes/Account.php");
include("includes/classes/Constants.php");
include("includes/classes/Validation.php");
include("includes/classes/SystemError.php");

include("includes/handlers/sanitize.php");

include("includes/classes/Business.php");
include("includes/classes/User.php");

if(isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1){
	header("Location: admin/dashboard.php");
}
if(isset($_SESSION['id'])){
	$user = new User($conn, $_SESSION['id']);
    
}


if(isset($_GET['searchText'])){

	$searchText = $_GET['searchText'];
    $query = "SELECT * FROM businesses WHERE business_name LIKE '%$searchText%' AND is_verified = 1 AND is_blocked = 0";
	
    $businesses = mysqli_query($conn, $query);
    
	// var_dump($businesses);

    $page_title = "Search Results for " . $searchText;
   

	$businessesCount = mysqli_num_rows($businesses);
	// echo count($businessesCount);
   

?>

<?php require_once "includes/head.php" ?>
<!-- css files unique to this page -->
<link rel="stylesheet" href="assets/css/index.css">

</head>


<body class="layout-top-nav" style="height: auto;">



<div class="wrapper ">

<?php require_once "includes/navbar.php" ?>

<section class="content pb-5 px-5 ">

<!-- Default box -->
<div class="card mx-5 pb-5 " style='box-shadow: none;'>
	<div class="card-body pb-0">
		


		<div class="row mx-5">
			<div class="col-12 mx-5 pb-2 ">
				<div class="ml-0 pl-0 mt-2"><h3>Showing search results for '<i><?php echo  $_GET['searchText']; ?></i>'</h3></div>
			</div>
		

		</div>
			<!-- show results -->
		<div class="row mx-5 d-flex align-items-stretch">

		<?php
			while($row = mysqli_fetch_assoc($businesses)){
				$business = new Business($conn, $row['id']); 
				
				$reviewsCount = count($business->getReviews());  
				?>

			<div class="col-12 d-flex align-items-stretch">
				<div class="card w-100 mx-5 px-5 mt-4 "  style='box-shadow: rgba(6, 24, 44, 0.4) 0px 0px 0px 2px, rgba(6, 24, 44, 0.65) 0px 4px 6px -1px, rgba(255, 255, 255, 0.08) 0px 1px 0px inset;'>
					<div>
						<div class='float-left'>
						<h3 class='pt-2'>
						<?php echo $business->getBusinessName(); ?>
						</h3>
						</div>
						<div class='float-right'>
                            <h3>


                                <?php
                                    if(isset($_SESSION['id']) && !isset($_SESSION['business_name'])){
                                        $user = new User($conn, $_SESSION['id']);?>
                                    <form method="post" id="bookmarkForm" action="includes/handlers/bookmark.php">
                                        <input type="hidden" value="" id="status" name="status">
                                        <input type="hidden" name='business_id' value='<?php echo $row['id']; ?>'>
                                        <input type="hidden" name='page' value='category'>
										<input type="hidden" name='category_id' value='<?php echo $category_id; ?>'>
										<input type="hidden" name='category_name' value='<?php echo  $_GET['category_name'];; ?>'>
                                        <?php
                                        if($user->isBookmark($row['id'])){?>
                                            <i onclick='submitBookmark(0)' class="fas fa-bookmark" style='color:blue;'></i>
                                        <?php
                                        }
                                        else{?>
                                            <i onclick='submitBookmark(1)' class="far fa-bookmark"></i>
                                        <?php
                                        }
                                    ?>

                                        
                                
                                    </form>
                                <?php
                                    }
                                ?>


                            </h3>
						</div>
					</div>
					<div class="card-body pt-4">
					<div class="row">
						<div class="col-7 text-center">
							<img src="images/businesses/<?php echo $business->getPicture(); ?>" alt="user-avatar" class="img-square img-fluid">
						</div>
						<div class="col-5">
                        <div class=" pt-4 pb-2">
                                <?php

                                   
                                    $starPercent = $business->calculateRating();
                                   
                                ?>
                            
                            <div class="star-ratings-sprite float-left"><span style="width:<?php echo $starPercent; ?>%;" class="star-ratings-sprite-rating"></span></div>     
                            <span class='ml-2'><?php echo $reviewsCount; ?> reviews</span>                                          
                        </div>
						<p class="text-muted"><b>Category: </b><?php echo $business->getBusinessCategory(); ?> </p>
						<ul class="ml-4 mb-0 fa-ul text-muted">
							<li class=""><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address:  <?php echo $business->getLocation(); ?></li>
							<li class=""><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #:  <?php echo $business->getContact(); ?></li>
						</ul>
						</div>

					</div>
					</div>
					<div class="card-footer">
						<div class="text-right">
						<a href="business.php?business_id=<?php echo $row['id'] ?>" class="btn btn-sm">
							See more
						</a>
						</div>
					</div>
				</div>
			</div>

		<?php
			}

			if($businessesCount == 0)
			{
			?>

				<div class="col-12 p-5 text-center m-4 border-top" style='height:50vh;' >
					
					<i>Sorry.. We have no registered business by that name</i>

				</div>
			<?php
			}

		?>
		</div>



	</div>
<!-- /.card-body -->

</div>
<!-- /.card -->

</section>










<!-- Footer -->
<?php require_once "includes/footer.php" ?>   

</div>



<?php require_once "includes/footer_scripts.php" ?>


<!-- password verfication with javascript check later -->
</body>
</html>


<?php
}

else{
    header("Location: index.php");
}
?>
