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

$status = $_GET['status'];
$page_title =   $_GET['status'] . ' Businesses';
$title = $_GET['status'];
$admin = new Admin($conn, $_SESSION['id']);



// dashboard data
if($_GET['status'] == 'Pending'){
    $businesses = Business::getPendingApprovals($conn);
    $title .= ' Approvals';
    $businessesCount = mysqli_num_rows($businesses);
    
}
else if($_GET['status'] == 'Approved'){
  $businesses = Business::getApprovedBusinesses($conn);
  $title = $page_title;
  $businessesCount = mysqli_num_rows($businesses);
  
}
else if($_GET['status'] == 'Blocked'){
  $businesses = Business::getBlockedBusinesses($conn);
  $title = $page_title;
  $businessesCount = mysqli_num_rows($businesses);
  
}



if(isset($_POST['decision']) && isset($_POST['business_id'])){
  $business_id = $_POST['business_id'];
  if($_POST['decision'] == 'approve'){

    // approve
      $admin->approveBusiness($business_id);
  }

  else if($_POST['decision'] == 'block'){
    // disapprove
   
    $admin->blockBusiness($business_id);
  }
  
  if($_POST['status'] == 'Pending'){
    header("Location: businesses.php?status=Pending");
  }
  else if($_POST['status'] == 'Blocked'){
    header("Location: businesses.php?status=Blocked");
  }
  else if($_POST['status'] == 'Approved'){
    header("Location: businesses.php?status=Approved");
  }
}

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
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo $title ?></h1>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>





            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-sm-12 col-md-6">
                    <div>
                        <label>Search:<input id='searchInput' type="search" class="form-control form-control-sm" placeholder="" aria-controls="example1">
                        </label>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class='float-right dt-buttons btn-group flex-wrap'>
                      <button type="button" class="btn btn-dark">
                        Total <span class="badge badge-light"><?php echo $businessesCount?></span>
                      </button>
                    </div>
                  </div>


                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                
                    <div class="row">
                        <div class="col-sm-12">
                        <table id="dataTable" class="table table-bordered table-striped dtr-inline" role="grid" >
                        <thead>
                        <tr role="row">
                            <th rowspan="1" colspan="1">Id</th>
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Business Name</th>
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" >Email</th>
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" >Contact</th>
                            
                            <?php
                            if($_GET['status'] == 'Approved' || $_GET['status'] == 'Blocked'){?>
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" >
                            Rating
                            </th>

                            <?php
                            }
                            ?>

                            <?php
                            if($_GET['status'] == 'Blocked'){
                            ?>
                            
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Verified</th>

                            <?php
                            }
                            ?>                            
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" >
                            Action
                            </th>       

                            
                            
                            
                        </tr>
                        </thead>
                  <tbody>
                  
                <?php
                    if($businessesCount == 0){?>

                   <tr role="row">
                    <td colspan=7  class='text-center'><span>No Entries</span> </td>
                    
                    </tr>
                    
                <?php
                    }

			              while($row = mysqli_fetch_assoc($businesses)){
                    $business = new Business($conn, $row['id']); 
                    
                    $reviewsCount = count($business->getReviews());  

                    
				        ?>                 
                  
                  
                  
                    <tr role="row">
                      <td class="" tabindex="0"><?php echo $row['id']; ?></td>
                      <td><a class='btn bnt-default' href="business.php?business_id=<?php echo $row['id']; ?>">
                        <?php echo $business->getBusinessName(); ?>
                      </a></td>
                      <td><?php echo $business->getEmail(); ?></td>
                      <td><?php echo $business->getContact(); ?></td>
                  
                      <?php

                        if($_GET['status'] == 'Approved' || $_GET['status'] == 'Blocked'){

                          $starPercent = $business->calculateRating();?>
                        <td> 
                      
                        <div class="star-ratings-sprite float-left">
                        <span style="width:<?php echo $starPercent; ?>%;" class="star-ratings-sprite-rating"></span>
                        </div>     
                        </td>

                        <?php
                          
                        }     
                        
                        ?>
                        

                      <?php
                      if($_GET['status'] == 'Blocked'){
                          if($business->getIsVerified() == 1){
                            $check = 'fa fa-check text-success nav-icon';
                          }
                          else{
                            $check = $uncheck;
                          }
                        
                        ?>

                        <td> <span  class='<?php echo $check; ?>' ></span></td>

                      <?php
                      } 
                      ?>
                    
                      <td>
                              <form method='post' id='decisionForm' action="businesses.php">
                              
                                <input type="hidden" id='business_id' name="business_id" value=''>
                                <input type="hidden" id='decision' name="decision" value=''>
                                <input type="hidden" name='status' value='<?php echo $_GET['status']?>'>
                                <?php 
                                if($_GET['status'] == 'Approved'){?>
                                  <span onclick='submitDecision("block", "<?php echo $business->getId()?>")' class='btn btn-danger'>Block</span>
                                <?php
                                }
                                else if($_GET['status'] == 'Blocked'){?>
                                  <span onclick='submitDecision("approve", "<?php echo $business->getId()?>")' class='btn btn-warning'>Unblock</span>
                                <?php
                                }
                                else if($_GET['status'] == 'Pending'){?>
                                <span onclick='submitDecision("approve", "<?php echo $business->getId()?>" )' class='btn btn-success'>Approve</span> /
                                <span onclick='submitDecision("block", "<?php echo $business->getId()?>")' class='btn btn-danger'>Disapprove</span>
                                <?php
                                }

                                ?>
                                
                              </form>
                      </td>


                  


                    </tr>
                
                
                <?php
                  }

               
                ?>
                
                
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  


                </tbody>
                  
                </table></div></div>
                
                </div>
              </div>
              <!-- /.card-body -->
            </div>














        

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

<script src="../includes/admin_footer_scripts.php"></script>
<script>

function submitDecision(status, id)
{
    document.getElementById("decision").value = status
    document.getElementById("business_id").value = id
    // alert(id)
    document.getElementById("decisionForm").submit();
  }
  $(document).ready(function(){
    $("#searchInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#dataTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

</script>
</body>
</html>




<?php

}
else{
  header("Location: ../index.php");
}
?>