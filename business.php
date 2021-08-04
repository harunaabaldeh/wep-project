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


$business = new Business($conn, $_GET['business_id']);
if(!isset($_SESSION['business_name'])){


    //$user = new User($conn, $_SESSION['id']);
    $id = isset($_GET['id']) ? $_GET['id'] : '';
}
$reviews = $business->getReviews();
$reviewsCount = count($reviews);

if(isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1){
	header("Location: admin/dashboard.php");
}

$page_title = "Business page";

if(isset($_POST['rating']) && isset($_POST['review']) && isset($_SESSION['id'])){
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    
    

    $success = $user->giveReview($_GET['business_id'], $rating, $review);
    
    if($success){
        header("Location: business.php");
    }

}


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
            <div class="card mx-5 " style='box-shadow: none;'>
                <div class="card-body mx-5 pb-0">
                    
    

                    <div class="row mx-5">
                        <div class="col-6">
                            <div class="ml-0 pl-0  mt-4"><h3><?php echo $business->getBusinessName(); ?> 

                            </h3>
                            
                            </div>
                            
                        </div>

                        <div class="col-6">
                            <div class="float-right ml-0 pl-0">
                            <h3>
                            <?php
                            if(isset($_SESSION['business_name']) && $_GET['business_id'] == $_SESSION['id']){?>
                            <a href='edit_profile.php' class="btn btn-default base2">
                                <i class="fas fa-pencil-alt">
                                </i>
                                Edit Profile
                            </a>
                            <?php
                            }
                            ?>

                                <?php
                                    if(isset($_SESSION['id']) && !isset($_SESSION['business_name'])){?>
                                    <form method="post" id="bookmarkForm" action="includes/handlers/bookmark.php">
                                        <input type="hidden" value="" id="status" name="status">
                                        <input type="hidden" id="business_id" name='business_id' value=''>
                                        <input type="hidden" name='page' value='business'>
                                        <?php
                                        if($user->isBookmark($_GET['business_id'])){?>
                                            <i onclick='submitBookmark(0, <?php echo $_GET["business_id"]; ?>)' class="fas fa-bookmark" style='color:blue;'></i>
                                        <?php
                                        }
                                        else{?>
                                            <i onclick='submitBookmark(1, <?php echo $_GET["business_id"]; ?>)' class="far fa-bookmark"></i>
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
                        <div class="col-6">
                                <img src="images/businesses/<?php echo $business->getPicture(); ?>" alt="user-avatar" class="img-square img-fluid">

                        </div>

                        <div class="col-6">
                            <div class="card " style='box-shadow: none;'>

                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-12 ">
                                            <h3 class="lead mb-4"><b>Category: </b> <?php echo $business->getBusinessCategory(); ?> </h3>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <li class="mb-4"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: <?php echo $business->getLocation(); ?></li>
                                            <li class="mb-4"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: <?php echo $business->getContact(); ?></li>
                                            </ul>

                                            <h3 class="lead"><b>Opening hours: </b></h3>
                                            <pre class='text-muted'><?php echo $business->getOpeningHours(); ?></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 pt-4 pb-2">
                                <?php

                                   
                                    $starPercent = $business->calculateRating();
                                   
                                ?>
                            
                            <div class="star-ratings-sprite float-left"><span style="width:<?php echo $starPercent; ?>%;" class="star-ratings-sprite-rating"></span></div>     
                            <span class='ml-2'><?php echo $reviewsCount; ?> reviews</span>                                          
                        </div>

                        <div class="col-12">
                            <h3 class="lead mb-2"><b>Business Overview </b></h3>
                                
                            <div class=' border-bottom pb-4'>

                                <?php echo $business->getAbout(); ?>
                            </div>
                    
                        </div>

                        <div class="col-12">
                            <h3 class="lead my-4 mb-4"><b>Reviews </b></h3>
                                
                            <!-- Later, make sure user is session's comment is first. Give the option of edit and maybe delete later -->

                            <?php
                            
                            $limit = 4;
                            if(isset($_SESSION['business_name']) && $_GET['business_id'] == $_SESSION['id']){
                                $limit = $reviewsCount;
                            }
                            for($i = 0; $i < $reviewsCount; $i++){

                                if($i <= $limit)
                                {
                                $review = new Review($conn, $reviews[$i]);
                               
                                ?>
                                    <div class='card  border-bottom  p-2' style='box-shadow: rgba(6, 24, 44, 0.4) 0px 0px 0px 2px, rgba(6, 24, 44, 0.65) 0px 4px 6px -1px, rgba(255, 255, 255, 0.08) 0px 1px 0px inset;'>
                                        <!-- A for loop to show just 4 reviews... a see more modal will be implement -->


                                        <div class="card-comments  ">
                                            <div class="card-comment">
                                                <!-- User image -->
                                                <img class="img-circle img-sm" src="images/profile-none.png" alt="User Image">

                                                <div class="comment-text">
                                                    <span class="username">
                                                    <?php 

                                                    if($review->getUserId() == $_SESSION['id'] && !isset($_SESSION['business_name'])){
                                                        echo "Me";
                                                    }
                                                    else{
                                                        echo $review->getUsername(); 
                                                    }
                                                    ?>
                                                        <span class="text-muted float-right">
                                                            <?php

                                                                $temp_star = '';
                                                                
                                                                for($j = 0; $j < 5; $j++)
                                                                {
                                                                
                                                                    if($j < $review->getRating()){
                                                                        $temp_star = 'fa fa-lg fa-star checked';
                                                                    }
                                                                    else{
                                                                        $temp_star = 'fa fa-lg fa-star';
                                                                    }
                                                                 
                                                                    echo "<span class=' . $temp_star . '></span>";
                                                                

                                                                }
                                                            ?>
                                                        </span>
                                                    </span><!-- /.username -->
                                                    <?php echo $review->getUserComment(); ?>
                                                </div>

                                                <div class="card-footer  mt-0 pt-0" style="background: none !important;">
                                                    <span class='float-right text-muted'> <?php echo $review->getReviewDate(); ?></span>
                                                </div>

                                                <?php
                                                if(isset($_SESSION['business_name']) && $_GET['business_id'] == $_SESSION['id']
                                                && $review->getBusinessReply() == ''){?>

                                                <div class="card-footer  mt-0 pt-0">
                                                   <div class="card ">
                                                    <div class="card-header mx-3">
                                                        <h3 class="card-title">Write a reply</h3>

                                                        <div class="card-tools">
                                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                                        </button>
                                                        </div>
                                                        <!-- /.card-tools -->
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <div class="card-body" style="display: none;">
                                                        <form method='post' action="includes/handlers/reply.php">

                                                        <div class="form-group">
                                                            <input type="hidden" name='user_id' value='<?php echo $review->getUserId(); ?>'>
                                                            <textarea class="form-control px-4 py-3" name='reply' style=' height: 181px;'></textarea>
                                                        </div>
                                                        <div class="form-group d-flex justify-content-end ">
                                                           
                                                            <button type="submit" class="btn btn-default base2">Send message</button>
                                                        </div>

                                                        </form>
                                                    </div>
                                                    <!-- /.card-body -->
                                                    </div>
                                                </div>

                                                <?php
                                                }
                                                else if($review->getBusinessReply() != ''){?>

                                                    <div class="card-comment bg-secondary-2 mx-4">

                                                        <div class="comment-text">
                                                            <span class="username text-muted">
                                                            <?php echo $business->getBusinessName(); ?>                                             
                                                            </span><!-- /.username -->
                                                            
                                                            <?php echo $review->getBusinessReply(); ?>                                               
                                                        </div>
                                                    <div class="card-footer  mt-0 pt-0">
                                                        <span class='float-right text-muted'> <?php echo $review->getReplyDate(); ?></span>
                                                    </div>                                                     
                                                                                                                    
                                                        
                                                        <!-- /.comment-text -->
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                                
                                                <!-- /.comment-text -->
                                            </div>
                                                <!-- /.card-comment -->
                                        <!-- /.card-comment -->
                                        </div>






                                
                                    </div>

                            
                                <?php
                                }

                            }

                            if($reviewsCount == 0)
                            {
                            ?>

                                <div class="text-center mb-4" >
                                   
                                    <i>There are no reviews for this business</i>

                                </div>
                            <?php
                            }

                            ?>

                            
                            <div>
                                <div class='float-left'>
                                    <?php
                                        if(isset($_SESSION['id']) && !isset($_SESSION['business_name'])){
                                        $temp_text = '';
                                            if(Review::isReviewExist($conn, $_GET['business_id'], $_SESSION['id']))
                                            {
                                                $temp_text = 'Edit Review';
                                                
                                            }
                                            else{
                                                $temp_text = 'Write a Review';
                                            }
                                        ?>
                                    <button class="btn btn-default base1"  data-toggle="modal" data-target="#modal-write-review"><?php echo $temp_text; ?></button>

                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class='float-right'>
                                    <?php
                                    if($reviewsCount > 4 && ($_GET['business_id'] != $_SESSION['id'])){?>

                                    <button class="btn btn-default base2"  data-toggle="modal" data-target="#modal-reviews">Read all Reviews</button>
                                    
                                    <?php
                                    }
                                    ?>
                                    
                                </div>
                            </div>



                        </div>

                        
                    </div>
                </div>
            <!-- /.card-body -->

            </div>
            <!-- /.card -->

        </section>









    <!-- Footer -->
    <?php require_once "includes/footer.php" ?>   

    </div>
<!--                        MODALS                                       -->

<!-- Write a review -->
    <div class="modal fade show" id="modal-write-review" style="padding-right: 15px;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content ">
            <div class="modal-header border-0">
             
              <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <div class="modal-header border-0 px-5 pt-0">
                <h4 class="modal-title"><?php echo $business->getBusinessName(); ?></h4>
            </div>
            <div class="text-center border-0 px-5 pt-0">
                <h4 class="modal-title ">
                <?php
                    if(Review::isReviewExist($conn, $_GET['business_id'], $_SESSION['id'])){
                        echo "Edit your rating";
                    }
                    else{
                        echo "Give a rating";
                    }
                ?>
                </h4>
            </div>
            <div class="modal-body px-5">
                <form action="includes/handlers/rating.php" method="post">
                    
                    <div class='form-group text-center'>
                        <div class="rating-group">
                            <input disabled checked class="rating__input rating__input--none" name="rating" id="rating-none" value="0" type="radio">
                            <label aria-label="1 star" class="rating__label" for="rating-1"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                            <input class="rating__input" name="rating" id="rating-1" value="1" type="radio">
                            <label aria-label="2 stars" class="rating__label" for="rating-2"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                            <input class="rating__input" name="rating" id="rating-2" value="2" type="radio">
                            <label aria-label="3 stars" class="rating__label" for="rating-3"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                            <input class="rating__input" name="rating" id="rating-3" value="3" type="radio">
                            <label aria-label="4 stars" class="rating__label" for="rating-4"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                            <input class="rating__input" name="rating" id="rating-4" value="4" type="radio">
                            <label aria-label="5 stars" class="rating__label" for="rating-5"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                            <input class="rating__input" name="rating" id="rating-5" value="5" type="radio">
                        </div>
                    </div>

                    <div class="form-group">

                    
                    
                        <input type="hidden" name='business_id' value='<?php echo $_GET['business_id']; ?>'>
                        <textarea class="form-control px-4 py-3" name='review' style=' height: 181px;'><?php echo htmlspecialchars(Review::getStaticReview($conn, $_GET['business_id'], $_SESSION['id'])); ?></textarea>
                    </div>
                    <div class="form-group d-flex justify-content-between ">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-default base2">Send review</button>
                    </div>
                </form>
              
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


<!--   See all reviews -->
    <div class="modal fade show" id="modal-reviews" style="padding-right: 15px;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content ">
            <div class="modal-header border-0">
             
              <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <div class="modal-header border-0 px-5 pt-0">
                <h4 class="modal-title"><?php echo $business->getBusinessName(); ?></h4>
                <div>
                    <label for="">Filter</label>
                    <select class="form-control" name="" id="filter">
                    <option value="">All</option>
                    </select>
                </div>
            </div>
            <div class="modal-body modal-scroll px-5">

                                
                            <?php
                            $reviews = $business->getReviews();
                            $reviewsCount = count($reviews);

                            for($i = 0; $i < $reviewsCount; $i++){


                                $review = new Review($conn, $reviews[$i]);
                               
                                ?>
                                    <div class='card  border-bottom  px-2' style='box-shadow: none;'>
                                        <!-- A for loop to show just 4 reviews... a see more modal will be implement -->


                                        <div class="card-comments  ">
                                            <div class="card-comment">
                                                <!-- User image -->
                                                <img class="img-circle img-sm" src="images/profile-none.png" alt="User Image">

                                                <div class="comment-text">
                                                    <span class="username">
                                                    <?php 

                                                    if($review->getUserId() == $_SESSION['id'] && !isset($_SESSION['business_name'])){
                                                        echo "Me";
                                                    }
                                                    else{
                                                        echo $review->getUsername(); 
                                                    }
                                                    ?>
                                                        <span class="text-muted float-right">
                                                            <?php

                                                                $temp_star = '';
                                                                
                                                                for($j = 0; $j < 5; $j++)
                                                                {
                                                                
                                                                    if($j < $review->getRating()){
                                                                        $temp_star = 'fa fa-lg fa-star checked';
                                                                    }
                                                                    else{
                                                                        $temp_star = 'fa fa-lg fa-star';
                                                                    }
                                                                 
                                                                    echo "<span class=' . $temp_star . '></span>";
                                                                

                                                                }
                                                            ?>
                                                        </span>
                                                    </span><!-- /.username -->
                                                    <?php echo $review->getUserComment(); ?>
                                                </div>

                                                <div class="card-footer  mt-0 pt-0" style="background: none !important;">
                                                    <span class='float-right text-muted'><?php echo $review->getReviewDate(); ?></span>
                                                </div>

                                                <?php
                                                if(isset($_SESSION['business_name']) && $_GET['business_id'] == $_SESSION['id']
                                                && $review->getBusinessReply() == ''){?>

                                                <div class="card-footer  mt-0 pt-0">
                                                   <div class="card ">
                                                    <div class="card-header mx-3 bg-dark">
                                                        <h3 class="card-title">Write a reply</h3>

                                                        <div class="card-tools">
                                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                                        </button>
                                                        </div>
                                                        <!-- /.card-tools -->
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <div class="card-body" style="display: none;">
                                                        <form method='post' action="includes/handlers/reply.php">

                                                        <div class="form-group">
                                                            <input type="hidden" name='user_id' value='<?php echo $review->getUserId(); ?>'>
                                                            <textarea class="form-control px-4 py-3" name='reply' style=' height: 181px;'></textarea>
                                                        </div>
                                                        <div class="form-group d-flex justify-content-end ">
                                                           
                                                            <button type="submit" class="btn btn-default base3">Send reply</button>
                                                        </div>

                                                        </form>
                                                    </div>
                                                    <!-- /.card-body -->
                                                    </div>
                                                </div>

                                                <?php
                                                }
                                                else if($review->getBusinessReply() != ''){?>

                                                    <div class="card-comment mb-2 bg-secondary-2 mx-4">

                                                        <div class="comment-text">
                                                            <span class="username text-muted">
                                                            <?php echo $business->getBusinessName(); ?>                                             
                                                            </span><!-- /.username -->
                                                            
                                                            <?php echo $review->getBusinessReply(); ?>                                               
                                                        </div>
                                                        <div class="card-footer  mt-0 pt-0">
                                                            <span class='float-right text-muted'> <?php echo $review->getReplyDate(); ?></span>
                                                        </div>                                                     
                                                                                                                    
                                                        
                                                        <!-- /.comment-text -->
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                            </div>
                                                <!-- /.card-comment -->
                                        <!-- /.card-comment -->
                                        </div>






                                
                                    </div>

                            
                            <?php
                            }
                            ?>


              
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>





<!-- Scripts -->
<?php require_once "includes/footer_scripts.php" ?>




</body>
</html>

