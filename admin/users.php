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
$page_title =   $_GET['status'] . ' Users';
$title =$page_title;
$admin = new Admin($conn, $_SESSION['id']);



// dashboard data
if($_GET['status'] == 'Active'){
    $users = User::getActiveUsers($conn);
   
    $usersCount = mysqli_num_rows($users);
    
}
else if($_GET['status'] == 'Blocked'){
  $users = User::getBlockedUsers($conn);
 
  $usersCount = mysqli_num_rows($users);
  
}



if(isset($_POST['user_id'])){
  $user_id = $_POST['user_id'];

  if($_POST['status'] == 'Active'){

    $admin->blockUser($user_id);
  
    header("Location: users.php?status=Active");
  }
  if($_POST['status'] == 'Blocked'){

    // $query = "UPDATE `users` SET is_blocked = 0  WHERE id = '$user_id'";
    // mysqli_query($conn, $query);

    $admin->unBlockUser($user_id);
    header("Location: users.php?status=Blocked");
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
                        Total <span class="badge badge-light"><?php echo $usersCount?></span>
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
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Username</th>
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" >Email</th>
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" >Review Count</th>
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" >
                            Registered Date
                            </th> 
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" >
                            Action
                            </th>       

                            
                            
                            
                        </tr>
                        </thead>
                  <tbody>
                  
                <?php
                    if($usersCount == 0){?>

                   <tr role="row">
                    <td colspan=6  class='text-center'><span>No Entries</span> </td>
                    
                    </tr>
                    
                <?php
                    }

			              while($row = mysqli_fetch_assoc($users)){
                    $user = new User($conn, $row['id']); 
                    
                    $reviewsCount = $user->getTotalReviewsCount();  

                    
				        ?>                 
                  
                  
                  
                    <tr role="row">
                      <td class="" tabindex="0"><?php echo $row['id']; ?></td>
                      <td>
                        <?php echo $user->getUsername(); ?>
                      </td>
                      <td><?php echo $user->getEmail(); ?></td>
                      <td><?php echo $reviewsCount; ?></td>
                      <td><?php echo $user->getRegisterDate(); ?></td>
                      
                      <td>

                        <form id='blockForm' method='post' action="users.php">
                        
                          <input type="hidden" id='user_id' name="user_id" value=''>
                          
                          <input type="hidden" name='status' value='<?php echo $_GET['status']?>'>
                          <?php
                            if($_GET['status'] == 'Active'){?>
                            <span onclick='submitDecision("<?php echo $user->getId()?>")' class='btn btn-danger'>Block</span>
                         
        
                          <?php

                            }
                            else if($_GET['status'] == 'Blocked'){?>
                            <span onclick='submitDecision("<?php echo $user->getId()?>")' class='btn btn-warning'>Unblock</span>
                         

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

<script>

function submitDecision(id)
{
    document.getElementById("user_id").value = id
    // alert(id)
    document.getElementById("blockForm").submit();
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