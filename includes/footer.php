<footer class=" border-0 bg-dark text-white">
<?php
$query = "SELECT * FROM categories";
$categories= mysqli_query($conn, $query);
?>
<div class="main-footer border-0 pt-5 widgets-dark typo-light">
    <div class="container">
    <div class="row pt-4" style='border-top: 1px solid #564f6f;'>
      
    <div class="col-xs-12 col-sm-6 col-md-3">
    <div class="widget subscribe no-box" >
    <h5 class="widget-title" >VISION BUSINESS DIRECTORY<span></span></h5>
    <p>About the company, it's our Web programming 2 project. </p>
    </div>
    </div>
    
    <div class="col-xs-12 col-sm-6 col-md-3">
    <div class="widget no-box">
    <h5 class="widget-title">Quick Links<span></span></h5>
    <ul class="thumbnail-widget">

    <?php
    while($row = mysqli_fetch_assoc($categories)){?>
    <li>
    
    <div class="thumb-content"> <a href="category.php?category_id=<?php echo $row['id'] ?>&category_name=<?php echo $row['category_name'] ?>">
    <?php echo $row['category_name'] ?> </a></div>	
    
    </li>
    <?php
    }
    ?>

    <li>
    <div class="thumb-content"><a href="#.">About</a></div>	
    </li>
    </ul>
    </div>
    </div>
    
    <div class="col-xs-12 col-sm-6 col-md-3">
    <div class="widget no-box">
    <h5 class="widget-title">Get Started<span></span></h5>
    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsa accusamus distinctio labore a. Explicabo molestias ducimu</p>
    
    <?php
        if(!isset($_SESSION['id'])){?>
         <a class="btn" href="signup.php">Register Now</a>
        <?php
        }
        else{?>
            <a class="btn" href="logout.php">Logout</a>
        <?php
        }
    ?>
   
    </div>
    </div>
    
    <div class="col-xs-12 col-sm-6 col-md-3">
    
    <div class="widget no-box">
    <h5 class="widget-title">Contact Us<span></span></h5>
    
    <p><a href="mailto:info@domain.com" title="glorythemes">info@domain.com</a></p>

    </div>
    </div>
    
    </div>
    </div>
    </div>
      
    <div class="footer-copyright">
    <div class="container">
    <div class="row">
    <div class="col-md-12 text-center">
    <p>Copyright VISION BUSINESS DIRECTORY © 2021 | All rights reserved.</p>
    </div>
    </div>
    </div>
    </div>


</footer>