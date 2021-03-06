<?php
session_start();
 if( isset($_SESSION['user'])!="" ){
  header("Location: index.php");
 }
include_once("config.php");


 $error = false;

 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);
  
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  // basic name validation
  if (empty($name)) {
   $error = true;
   $nameError = "Please enter your full name.";
  } else if (strlen($name) < 3) {
   $error = true;
   $nameError = "Name must have atleat 3 characters.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
   $error = true;
   $nameError = "Name must contain alphabets and space.";
  }
  
  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  } else {
   // check email exist or not
   $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
   $result = mysqli_query($mysqli,$query);
   $count = mysqli_num_rows($result);
   if($count!=0){
    $error = true;
    $emailError = "Provided Email is already in use.";
   }
  }
  // password validation
  if (empty($pass)){
   $error = true;
   $passError = "Please enter password.";
  } else if(strlen($pass) < 6) {
   $error = true;
   $passError = "Password must have atleast 6 characters.";
  }
  
  // password encrypt using SHA256();
  $password = hash('sha256', $pass);
  
  // if there's no error, continue to signup
  if( !$error ) {
   
   $query = "INSERT INTO users(userName,userEmail,userPass) VALUES('$name','$email','$password')";
   $res = mysqli_query($mysqli,$query);
    
   if ($res) {
    $errTyp = "success";
    $errMSG = "Successfully registered, you may login now";
    unset($name);
    unset($email);
    unset($pass);
   } else {
    $errTyp = "danger";
    $errMSG = "Something went wrong, try again later..."; 
   } 
    
  }
  
  
 }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />    
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <link href="style/bootstrap.min.css" rel="stylesheet" />
    <link href="style/material-kit.css" rel="stylesheet"/>
    <script src='js/jquery.min.js'></script>
    <script src='js/moment.min.js'></script>
  <link href="style/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- start of navbar -->
<nav class="navbar navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">

<!--low res toggle button --> 
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

<!-- logo -->
        <a href="/" class="pull-left"><img src="images/logo.png"></a>    
    </div>
<!-- navbar links using lists and a dropdown class -->
    <div class="collapse navbar-collapse" id="myNavbar">
         <ul class="nav navbar-nav navbar-right">
            <li><a href="https://www.youtube.com/watch?v=cVugL973Nzg">Deploy Video</a></li>
            <li><a href="https://groups.google.com/a/mail.dcu.ie/forum/#!forum/gae-group-project">Team Blog</a></li>
            <li><a href="/register.php"><span class="glyphicon glyphicon-user"></span> Register</a></li>
            <li><a href="/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
     <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['userEmail']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>



    </div>
  </div>
</nav>
<!-- END OF NAV -->


<div class="container">

 <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
     <div class="col-md-12">
        
         <div class="form-group">
             <h2 class="">Sign Up.</h2>
            </div>
        
         <div class="form-group">
             <hr />
            </div>
            
            <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
             <input type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50" value="<?php echo $name ?>" />
                </div>
                <span class="text-danger"><?php echo $nameError; ?></span>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <a href="login.php">Sign in Here...</a>
               <div class="vspacer50"></div>
            </div>
          <div class="vspacer50"></div>
        </div>
   
    </form>
    </div> 

</div>
   <!-- simple black footer -->
    <footer class="footer footer-black">
                  <div class="container">
                    <a class="footer-brand" href="/">Snap Online Store</a>


                    <ul class="pull-center">
                      <li>
                        <a href="https://www.youtube.com/watch?v=cVugL973Nzg">
                          Deploy Video
                        </a>
                      </li>
                      <li>
                        <a href="https://groups.google.com/a/mail.dcu.ie/forum/#!forum/gae-group-project">
                           Team Blog
                        </a>
                      </li>
                      <li>
                        <a href="/register.php">
                          Register
                        </a>
                      </li>
                      <li>
                        <a href="/login.php">
                           Login
                        </a>
                      </li>
                    </ul>

                    <ul class="social-buttons pull-right">
                      <li>
                        <a href="https://twitter.com/dublincityuni" target="_blank" class="btn btn-just-icon btn-simple">
                          <i class="fa fa-twitter"></i>
                        </a>
                      </li>
                      <li>
                        <a href="https://www.facebook.com/dcu" target="_blank" class="btn btn-just-icon btn-simple">
                          <i class="fa fa-facebook-square"></i>
                        </a>
                      </li>
                      <li>
                        <a href="https://www.instagram.com/dcu" target="_blank" class="btn btn-just-icon btn-simple">
                          <i class="fa fa-instagram"></i>
                        </a>
                      </li>
                    </ul>

                  </div>
                </footer>

                <!--   simple black footer    -->


  <!--   Core JS Files   -->
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="js/material.min.js"></script>

  <!--  Plugin for the Sliders, full documentation here: //refreshless.com/nouislider/ 
  <script src="js/nouislider.min.js" type="text/javascript"></script> -->

  <!--  Plugin for the Datepicker, full documentation here: //www.eyecon.ro/bootstrap-datepicker/ -->
        <script src="js/bootstrap-datepicker.js" type="text/javascript"></script>


  <!-- Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc -->
  <script src="js/material-kit.js" type="text/javascript"></script> 


    <!--  Plugin for Select Form control, full documentation here: //github.com/FezVrasta/dropdown.js -->
    <script src="js/jquery.dropdown.js" type="text/javascript"></script>

    <!--  Plugin for Fileupload, full documentation here: //www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="js/jasny-bootstrap.min.js"></script>

    <!-- Plugin For Google Maps -->
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyCq8YBaRCrl0Le47Pxd_x8PuyLSIFUtj10"></script>

    <script src="js/typeahead.js" type="text/javascript"></script>
</body>
</html>
<?php ob_end_flush(); ?>