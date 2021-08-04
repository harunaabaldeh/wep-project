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
	
$page_title = "Dashboard";
$admin = new Admin($conn, $_SESSION['id']);



// dashboard data

$allBusinesses = Business::getAllBusinesses($conn);
$pendingApprovals = Business::getPendingApprovals($conn);
$approvedBusinesses = Business::getApprovedBusinesses($conn);
$blockedBusinesses = Business::getBlockedBusinesses($conn);

$allUsers = User::getAllUsers($conn);

// Get categories


$query = "SELECT * FROM categories";
$categories= mysqli_query($conn, $query);


$ratings_category_data = array();

while($row = mysqli_fetch_assoc($categories) ){
$category_id = $row['id'];
$query = "SELECT category_name, businesses.id AS business_id FROM categories INNER JOIN businesses ON businesses.business_category = categories.id
WHERE categories.id = '$category_id'";

$result = mysqli_query($conn, $query);
// var_dump($result);

$result_count = mysqli_num_rows($result);
$sum = 0;

  while($row2 = mysqli_fetch_assoc($result)){
    $business = new Business($conn, $row2['business_id']);


    
    $sum += $business->calculateRating();

  }

if($result_count != 0){
  $average = $sum / ($result_count );
}
 
else{
  $average = 0;
}


$ratings_category_data[$row['category_name']] = number_format($average, 2);

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
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo mysqli_num_rows($pendingApprovals); ?></h3>

                <p>Pending Approvals</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="businesses.php?status=Pending" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>
                <?php 
                echo mysqli_num_rows($approvedBusinesses);
                ?>
                </h3>

                <p>Approved Businesses</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="businesses.php?status=Approved" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo mysqli_num_rows($allUsers); ?></h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="users.php?status=Active" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo mysqli_num_rows($blockedBusinesses); ?></h3>

                <p>Blocked Businesses</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="businesses.php?status=Blocked" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">


          <div class="col-lg-6">
              <div class="card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Categories</h3>
                    
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-lg">
                    <?php 
                    echo (mysqli_num_rows($approvedBusinesses) + mysqli_num_rows($pendingApprovals) + mysqli_num_rows($blockedBusinesses));
                    ?>
                      </span>
                      <span>Total Businesses</span>
                    </p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <canvas id="categories-chart" height="200" style="display: block; width: 569px; height: 200px;" width="569" class="chartjs-render-monitor"></canvas>
                  </div>


                </div>
              </div>
              <!-- /.card -->
              
          </div>

          <div class="col-lg-6">
          
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Users Chart
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <div class="chart" id="sales-chart" style="position: relative; height: 300px;">
                    <canvas id="users-chart" height="300" style="height: 300px;"></canvas>                         
                  </div>  
                </div>
              </div><!-- /.card-body -->
            </div>

          </div>

          <div class="col-lg-12">
                      <!-- solid sales graph -->
                      <div class="card" style='background: rgb(76,73,93); color:white;'>
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-th mr-1"></i>
                  Ratings Graph
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn bg-default btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn bg-default btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
              <div class="card-footer bg-transparent">
                <div class="row">
                <?php
                  foreach($ratings_category_data as $category_name => $data){?>
                  
                 
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="<?php echo $data; ?>" data-width="60" data-height="60"
                           data-fgColor="rgb(231,113,34)">

                    <div class="text-white"><?php echo $category_name ?></div>
                  </div>
                  <?php
                  }
                  ?>


                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->

          
          </div>
       





        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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







<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>

<script src="../assets/js/dashboard.js"></script>







</body>
</html>




<?php

}
else{
  header("Location: ../index.php");
}
?>