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


$business = new Business($conn, $_SESSION['id']);
$reviews = $business->getReviews();
$reviewsCount = count($reviews);

if(isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1){
	header("Location: admin/dashboard.php");
}

$page_title = "Edit Profile";
$business_id = $_SESSION['id'];

if(isset($_POST['submit'])){
    $business_name = sanitizeFormName($_POST["business_name"]);

    $email = sanitizeFormOther($_POST['email']);

    
    $business_category = $_POST['business_category'];
    $opening_hours = strip_tags($_POST['opening_hours']);
    $contact = strip_tags($_POST['contact']);
    $location = strip_tags($_POST['location']);
    $about = strip_tags($_POST['about']);
   
    $picture = $_FILES['picture'];

    $success = $business->editProfile($business_name, $email, $opening_hours,
    $business_category, $contact, $location, $about, $picture);

    if($success == true){
        header("Location: business.php?business_id=$business_id");
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
                    
    

                    <div class="row card mx-5 bg-white-2">
                        <div class="col-12 base3 px-0">
                            <div class="ml-0 base3 pl-0 pt-4 mb-4"><h3> 
                                Edit Information
                            </h3>
                            
                            </div>
                            
                        </div>

                        <!-- <div class="col-6">
                                <img  alt="user-avatar" class="img-square img-fluid">

                        </div> -->

                        <div class="col-12 mt-5">

                        
                            <div class="input-group mb-3">
                                  

                                  <div class="image-container mx-auto">
                                      <div class="image-wrapper">
                                          <div id='image' class="image">
                                              <img  src="images/businesses/<?php echo $business->getPicture(); ?>" alt="">
                                          </div>

                                          <div id="cancel-btn"><i class="fas fa-times"></i></div>
                                          <div class="file-name" >File name here</div>
                                      </div>

                                  </div>



                              </div>

                              <div class="text-center">
                                  <label for="file" class='btn btn-default base2'> Choose an image</label>

                              </div>
                        </div>


                        <div class="col-12">
                            <div class="ml-0 pl-0 mt-4 mb-4 text-dark text-center">
                            <h3> 
                                Business Information
                            </h3>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                <form class="form-horizontal" method='post' enctype="multipart/form-data"  action='edit_profile.php'>
                                    <input id="file" name='picture' type="file" onchange='showSelected()' hidden>
                             
                                    <div class="form-group row">
                                        <label for="businessName" class="col-sm-2 col-form-label">Business Name</label>
                                        <div class="col-sm-10">
                                        <input type="text" class="form-control" id="businessName" name='business_name' 
                                        value='<?php echo $business->getBusinessName(); ?>'>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" name='email'
                                        value='<?php echo $business->getEmail(); ?>'
                                        >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName2" class="col-sm-2 col-form-label">Category</label>
                                        <div class="col-sm-10">
                                        <select class="form-control" name='business_category' placeholder="Category" required>
                                        <option value="">Select Category</option> 
                                        <?php
                                        // Queries
                                        $query = "SELECT * FROM categories ORDER BY category_name";
                                        $categories= mysqli_query($conn, $query);

                                        while($row = mysqli_fetch_assoc($categories)){?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['category_name'] ?></option>
                                        <?php
                                        }  
                                        ?>

                                        
                                    </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="location" class="col-sm-2 col-form-label">Location</label>
                                        <div class="col-sm-10">
                                        <input type="text" class="form-control"  id="location" name='location' 
                                        value='<?php echo $business->getLocation(); ?>'>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="contact" class="col-sm-2 col-form-label">Contact</label>
                                        <div class="col-sm-10">
                                        <input type="text" class="form-control"  id="contact"  name='contact'
                                        value='<?php echo $business->getContact(); ?>'>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="openingHours" class="col-sm-2 col-form-label">Opening Hours</label>
                                        <div class="col-sm-10">
                                        <textarea style=' height: 100px;' class="form-control" id="openingHours"  name='opening_hours'><?php echo htmlspecialchars($business->getOpeningHours()); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="about" class="col-sm-2 col-form-label">About the business</label>
                                        <div class="col-sm-10">
                                        <textarea style=' height: 105px;' class="form-control" id="about"  name='about' ><?php echo htmlspecialchars($business->getAbout()); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                            <div class="float-left mt-3">
                                                <a href="business.php?business_id=<?php echo $_SESSION["id"] ?>" class="btn btn-secondary">Cancel</a>
                                            </div>
                                            <div class="float-right mt-3">
                                                <button type="submit" name="submit" class="btn btn-default base1">Submit</button>
                                            </div>
                                        
                                    </div>
                                </form>

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




<!-- Scripts -->
<?php require_once "includes/footer_scripts.php" ?>


<script>
     var upload_div = document.getElementById('image');


    showSelected = function() {
        var input = document.getElementById('file');
       

        console.log(URL.createObjectURL(input.files[0]));
        upload_div.innerHTML = '<img class="px-2" src=' + URL.createObjectURL(input.files[0]) + ' alt=' + input.files.item(0).name  +' >';
       
    }
</script>

</body>
</html>

