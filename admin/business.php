<?php
session_start();
include('../includes/config.php');

include("../includes/classes/Review.php");
include("../includes/classes/Account.php");
include("../includes/classes/Constants.php");
include("../includes/classes/Validation.php");
include("../includes/classes/SystemError.php");

include("../includes/handlers/sanitize.php");

include("../includes/classes/Business.php");
include("../includes/classes/User.php");
include("../includes/classes/Admin.php");



// if(isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1){


if(isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1){
    



$uncheck = 'fas fa-times text-danger nav-icon';
$check = '';
$admin = new Admin($conn, $_SESSION['id']);


$business = new Business($conn, $_GET['business_id']);
$page_title = $business->getBusinessName();
$title =  $page_title;
$reviews = $business->getReviews();
$reviewsCount = count($reviews);

if($business->getIsVerified() == 1){
  $check = 'fa fa-check text-success nav-icon';
}
else{
  $check = $uncheck;
}
// dashboard data


?>


<?php require_once "../includes/admin_head.php" ?>


<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php require_once "../includes/admin_navbar.php" ?>


  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php require_once "../includes/admin_aside.php" ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <section class="content pb-5 px-5">

      <!-- Default box -->
      <div class="card mx-5" style='box-shadow: none;'>
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
                       <span  class='<?php echo $check; ?>' ></span>
                      </h3>
                      </div>
                  </div>
                  <div class="col-6">
                          <img src="../images/businesses/<?php echo $business->getPicture(); ?>" alt="user-avatar" class="img-square img-fluid">

                  </div>

                  <div class="col-6">
                      <div class="card" style='box-shadow: none;'>

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
                      
                      $limit = $reviewsCount;
                      for($i = 0; $i < $reviewsCount; $i++){

                          if($i <= $limit)
                          {
                          $review = new Review($conn, $reviews[$i]);
                        
                          ?>
                              <div class='card border-bottom  p-2' style='box-shadow: rgba(6, 24, 44, 0.4) 0px 0px 0px 2px, rgba(6, 24, 44, 0.65) 0px 4px 6px -1px, rgba(255, 255, 255, 0.08) 0px 1px 0px inset;'>
                                  <!-- A for loop to show just 4 reviews... a see more modal will be implement -->


                                  <div class="card-comments ">
                                      <div class="card-comment">
                                          <!-- User image -->
                                          <img class="img-circle img-sm" src="../images/profile-none.png" alt="User Image">

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

                                          <div class="card-footer  mt-0 pt-0" style='background: none !important;'>
                                              <span class='float-right text-muted'> <?php echo $review->getReviewDate(); ?></span>
                                          </div>

                                          <?php
                                          if(isset($_SESSION['business_name']) && $_GET['business_id'] == $_SESSION['id']
                                          && $review->getBusinessReply() == ''){?>

                                          <div class="card-footer  mt-0 pt-0">
                                            <div class="card">
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
                                                    
                                                      <button type="submit" class="btn btn-default base3">Send message</button>
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
                                                      <span class="username ">
                                                      <?php echo $business->getBusinessName(); ?>                                             
                                                      </span><!-- /.username -->
                                                      
                                                      <?php echo $review->getBusinessReply(); ?>                                               
                                                  </div>
                                              <div class="card-footer  mt-0 pt-0">
                                                  <span class='float-right text-dark'> <?php echo $review->getReplyDate(); ?></span>
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


                  </div>

                  
              </div>
          </div>
      <!-- /.card-body -->

      </div>
      <!-- /.card -->

    </section>














        

  </div>
  <!-- /.content-wrapper -->


  <?php require_once "../includes/admin_footer.php" ?>


</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>


</body>
</html>




<?php

}
else{
    header("Location: ../index.php");
}
?>