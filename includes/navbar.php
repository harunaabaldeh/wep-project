<?php 
$query = "SELECT * FROM categories";
$categories= mysqli_query($conn, $query);
if($page_title == 'Login' || $page_title == 'Sign up'){
    $navbarColor = 'navbar-dark border-0';
}
else{
    $navbarColor = 'text-white bg-dark-3';
}

?>
    <nav class="main-header navbar navbar-expand-md <?php echo $navbarColor; ?>  ">
        <div class="container">
            <a href="index.php" class="navbar-brand">
            <span class="brand-text font-weight-light">Vision Business Directory</span>
            </a>
    
            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <?php
                if(isset($_SESSION["email"]) && isset($_SESSION['is_admin']))
                {?>
                <li class="nav-item">
                    <a href="bookmarks.php" class="nav-link">Bookmarks</a>
                </li>
                <?php 
                }
                else if(isset($_SESSION["email"]) && isset($_SESSION["business_name"])){
                    ?>
                    <li class="nav-item">
                        <a href="business.php?business_id=<?php echo $_SESSION["id"] ?>" class="nav-link">Profile</a>
                    </li>
                    <?php    
                }  
                ?>
                <li class="nav-item dropdown">
                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Categories</a>
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow <?php echo $navbarColor; ?>" style="left: 0px; right: inherit;">
                    <?php
                    while($row = mysqli_fetch_assoc($categories)){?>
                    <li><a href="category.php?category_id=<?php echo $row['id'] ?>&category_name=<?php echo $row['category_name'] ?>" class="dropdown-item text-white">
                    <?php echo $row['category_name'] ?> </a></li>
                    <?php
                    }
                    ?>
                    
                </ul>
                </li>
            </ul>
    
            <!-- SEARCH FORM -->
            <form action="search_results.php" class="form-inline ml-0 ml-md-3">
                <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" name='searchText' type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar text-white" type="submit">
                    <i class="fas fa-search"></i>
                    </button>
                </div>
                </div>
            </form>
            </div>
    
            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

                                <!-- Messages Dropdown Menu -->
                <?php
                if(!isset($_SESSION["email"]) && $page_title != 'Login')
                {?>
                <li class="nav-item">
                    <a href="login.php" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-default" >
                    <a href="signup.php" class="" style='color: rgb(6, 6, 6);'>Sign up</a>
                    </button>
                </li>
                <?php 
                } 
                else if(isset($_SESSION["email"])){
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
