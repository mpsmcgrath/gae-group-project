<?php
session_start();
include_once("config.php");
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: login.php");
  exit;
 }
 // select loggedin users detail
 $res=mysqli_query($mysqli,"SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow=mysqli_fetch_array($res);
?>
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    
    <link rel="icon" type="image/png" href="image/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>GAE Group Project</title>

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
<body><!-- start of navbar -->
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



<div class="vspacer50"></div>
<h1 align="center">View Cart</h1>
<div class="cart-view-table-back">
<form method="post" action="cart_update.php">
<table width="100%"  cellpadding="6" cellspacing="0"><thead><tr><th>Quantity</th><th>Name</th><th>Price</th><th>Total</th><th>Remove</th></tr></thead>
  <tbody>
 	<?php
	if(isset($_SESSION["cart_products"])) //check session var
    {
		$total = 0; //set initial total value
		$b = 0; //var for zebra stripe table 
		foreach ($_SESSION["cart_products"] as $cart_itm)
        {
			//set variables to use in content below
			$product_name = $cart_itm["product_name"];
			$product_qty = $cart_itm["product_qty"];
			$product_price = $cart_itm["product_price"];
			$product_code = $cart_itm["product_code"];
			$product_color = $cart_itm["product_color"];
			$subtotal = ($product_price * $product_qty); //calculate Price x Qty
			
		   	$bg_color = ($b++%2==1) ? 'odd' : 'even'; //class for zebra stripe 
		    echo '<tr class="'.$bg_color.'">';
			echo '<td><input type="text" size="2" maxlength="2" name="product_qty['.$product_code.']" value="'.$product_qty.'" /></td>';
			echo '<td>'.$product_name.'</td>';
			echo '<td>'.$currency.$product_price.'</td>';
			echo '<td>'.$currency.$subtotal.'</td>';
			echo '<td><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /></td>';
            echo '</tr>';
			$total = ($total + $subtotal); //add subtotal to total var
        }
		
		$grand_total = $total + $shipping_cost; //grand total including shipping cost
		foreach($taxes as $key => $value){ //list and calculate all taxes in array
				$tax_amount     = round($total * ($value / 100));
				$tax_item[$key] = $tax_amount;
				$grand_total    = $grand_total + $tax_amount;  //add tax val to grand total
		}
		
		$list_tax       = '';
		foreach($tax_item as $key => $value){ //List all taxes
			$list_tax .= $key. ' : '. $currency. sprintf("%01.2f", $value).'<br />';
		}
		$shipping_cost = ($shipping_cost)?'Shipping Cost : '.$currency. sprintf("%01.2f", $shipping_cost).'<br />':'';
	}
    ?>
    <tr><td colspan="5"><span style="float:right;text-align: right;"><?php echo $shipping_cost. $list_tax; ?>Amount Payable : <?php echo sprintf("%01.2f", $grand_total);?></span></td></tr>
    <tr><td colspan="5"><a href="index.php" class="button">Add More Items</a><button type="submit">Update</button></td></tr>
  </tbody>
</table>
<input type="hidden" name="return_url" value="<?php 
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
echo $current_url; ?>" />
</form>
</div>
    <div class="vspacer50"></div>
        <div class="vspacer50"></div>
            <div class="vspacer50"></div>
                <div class="vspacer50"></div>        
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


    <!--	Plugin for Select Form control, full documentation here: //github.com/FezVrasta/dropdown.js -->
    <script src="js/jquery.dropdown.js" type="text/javascript"></script>

    <!--	Plugin for Fileupload, full documentation here: //www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="js/jasny-bootstrap.min.js"></script>

    <!-- Plugin For Google Maps -->
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyCq8YBaRCrl0Le47Pxd_x8PuyLSIFUtj10"></script>

    <script src="js/typeahead.js" type="text/javascript"></script>
</body>
</html>
