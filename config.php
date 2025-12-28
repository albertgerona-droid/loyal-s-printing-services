<?php
#error handler

error_reporting(E_ALL);
ini_set('display_errors', 1);


function customErrorHandler($errno, $errstr, $errfile, $errline) {
    $errorMessage = "Error [$errno]: $errstr in $errfile on line $errline";
    

    error_log($errorMessage . "\n", 3, "error_log.txt");


    echo "<div style='color: red; font-weight: bold;'>Something went wrong! Please try again later.</div>";

    return true;
}




#connection sa mysql
session_start();
$conn = mysqli_connect("localhost","root","","printing_shop");
 if(!$conn){
    echo "not connected";
 }


 if(isset($_SESSION['active_login'])){
   $user_idko = $_SESSION['active_login'];


   $get_id = "SELECT * FROM `accounts` WHERE `user_id` = '$user_idko'";
   $result_data = mysqli_query($conn,$get_id);
   if($result_data->num_rows>0){
      while($id_row = mysqli_fetch_assoc($result_data)){
         $branch_nameko = $id_row['branch_name'] ?? '';
         $emailko = $id_row['email'] ?? '';
         $locationko = $id_row['location'] ?? '';
      }
   }
 }


 if(isset($_POST['admin_session'])){
   $user_idko = $_SESSION['admin_session'];


   $get_id = "SELECT * FROM `accounts` WHERE `user_id` = '$user_idko'";
   $result_data = mysqli_query($conn,$get_id);
   if($result_data->num_rows>0){
      while($id_row = mysqli_fetch_assoc($result_data)){
         $branch_nameko = $id_row['branch_name'] ?? '';
         $emailko = $id_row['email'] ?? '';
         $locationko = $id_row['location'] ?? '';
      }
   }
 }

date_default_timezone_set("asia/manila");
 #get date today
 $datetoday = date("Y-m-d");
  #get year today
 $year = date("Y");
  #get time today

 $timetoday = date("h:i:s a");

 #get month
  $month = date("m");
  #get week
  $week = date("W");
?>