<?php

// dashboard data
$query = "SELECT * FROM categories";
$categories= mysqli_query($conn, $query);
$categoriesCount = mysqli_num_rows($categories);



?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
      
      <span class="brand-text font-weight-bold">Vision Business Directory</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../images/<?php echo $admin->getPicture(); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $admin->getUsername(); ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="dashboard.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                
              </p>
            </a>
          </li>
          <li class="nav-item menu-is-opening menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-list-alt "></i>
              <p>
                Categories
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: block;">
              <?php
                while($row = mysqli_fetch_assoc($categories) ){?>

              <li class="nav-item">
                <a href="categories.php?category_id=<?php echo $row['id'] ?>&category_name=<?php echo $row['category_name'] ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p><?php echo $row['category_name'] ?></p>
                </a>
              </li>

              <?php
                }

              ?>

            </ul>
          </li>
          <li class="nav-item menu-is-opening menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Businesses
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: block;">
              <li class="nav-item">
                <a href="businesses.php?status=Pending" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pending</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="businesses.php?status=Approved" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Approved</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="businesses.php?status=Blocked" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Blocked</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item menu-is-opening menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: block;">
              <li class="nav-item">
                <a href="users.php?status=Active" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="users.php?status=Blocked" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Blocked</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
