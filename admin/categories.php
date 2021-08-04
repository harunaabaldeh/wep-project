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
    

  $admin = new Admin($conn, $_SESSION['id']);

  if(isset($_POST['editCategory'])){

    $category_id = $_POST['category_id'];
    $new_name = $_POST['editCategory'];

    $admin->editCategory($category_id, $new_name);

    header("Location: categories.php?category_id=$category_id&category_name=$new_name");
  }

  if(isset($_POST['newCategory'])){

  
    $new_name = $_POST['newCategory'];

  
    $admin->addCategory($new_name);
    $query = "SELECT id FROM categories where category_name = '$new_name'";
    $result = mysqli_query($conn, $query) ;
    while($row = mysqli_fetch_assoc($result)){
      $category_id = $row['id'];
    }

    header("Location: categories.php?category_id=$category_id&category_name=$new_name");
  }
  

$uncheck = 'fas fa-times text-danger nav-icon';

$category_id = $_GET['category_id'];
$category_name = $_GET['category_name'];
$page_title =  $_GET['category_name'] . ' Category';



// dashboard data
$businesses = Business::getAllUnderCategory($conn, $category_id);
$businessesCount = mysqli_num_rows($businesses);


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
                <h1><?php echo $category_name ?>
                  <span class="btn btn-default base2" data-toggle="modal" data-target="#editModal" ><i class="fas fa-edit"></i></span>
                </h1>
                
            </div>
            <div class="col-sm-6">
                <ol class="float-sm-right">
                
                <button data-toggle="modal" data-target="#newModal" type="button" class="btn btn-block btn-outline-secondary base1 btn-flat">Add New Category</button>
                </ol>
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
                        <div class="col-sm-12"><table id="dataTable" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
                        <thead>
                        <tr role="row">
                            
                            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">Id</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Business Name</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Email</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Contact</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Rating</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Verified</th>
                        </tr>
                        </thead>
                  <tbody>
                  
                <?php
			              while($row = mysqli_fetch_assoc($businesses)){
                    $business = new Business($conn, $row['id']); 
                    
                    $reviewsCount = count($business->getReviews());  
                    if($business->getIsVerified() == 1){
                        $check = 'fa fa-check text-success nav-icon';
                    }
                    else{
                        $check = $uncheck;
                    }
                    
				        ?>                 
                  
                  
                  
                  <tr role="row">
                   
                    <td class="dtr-control sorting_1" tabindex="0"><?php echo $row['id']; ?></td>
                    <td><a class='btn bnt-default' href="business.php?business_id=<?php echo $row['id']; ?>">
                        <?php echo $business->getBusinessName(); ?>
                      </a>
                    </td>
                    <td><?php echo $business->getEmail(); ?></td>
                    <td><?php echo $business->getContact(); ?></td>
                    <td> 
                    
                    <?php

                                   
                      $starPercent = $business->calculateRating();

                    ?>

                    <div class="star-ratings-sprite float-left">
                    <span style="width:<?php echo $starPercent; ?>%;" class="star-ratings-sprite-rating"></span>
                    </div>     
                    </td>
                    <td> <span  class='<?php echo $check; ?>' ></span></td>
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










      <div class="modal fade show" id="editModal" style=" padding-right: 15px;" aria-modal="true" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="text-muted">Edit category name</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form id='editForm' class='form' action="categories.php" method='post'>
                
                <input type="hidden" name="category_id" value='<?php echo $category_id ?>'>
               
                <input class='form-control' id='editCategory' type="text" name='editCategory' value='<?php echo $category_name ?>'>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" onclick='document.getElementById("editForm").submit()' class="btn btn-default base1">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>





      <div class="modal fade show" id="newModal" style="padding-right: 15px;" aria-modal="true" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="text-muted">Add New Category</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form id='newForm' class='form' action="categories.php" method='post'>
                <input type="hidden" name="category_id" value='<?php echo $category_id ?>'>
                <input class='form-control' type="text" name='newCategory'>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" onclick='document.getElementById("newForm").submit()' class="btn btn-default base1">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

        

  </div>
  <!-- /.content-wrapper -->


  <!-- Main Footer -->


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


<script>
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
?>