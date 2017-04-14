<?php
$currency = '&euro; '; //Currency Character or code

$db_username = 'broot';
$db_password = 'broot';
$db_name = 'blog_sample';
$db_port = null;
$db_socket = "/cloudsql/gae-group-project:europe-west1:gae-group-project";
$db_host = 'localhost';

$shipping_cost      = 4.50; //shipping cost
$taxes              = array( //List your Taxes percent here.
                            'VAT' => 12, 
                            'Service Tax' => 5
                            );						
//connect to MySql						
$mysqli = new mysqli($db_host,$db_username,$db_password,$db_name,$db_port,$db_socket);						
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
?>