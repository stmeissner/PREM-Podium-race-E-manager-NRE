<?
require_once("session_start.php");
if(!isset($login)) error("You do not have administrator rights\n");

require_once("functions.php"); // import mysql function
$link = mysqlconnect(); // call mysql function to get the link to the database

var_dump($_POST['sim']);
$sim = htmlspecialchars($_POST['sim']);
$brand = htmlspecialchars($_POST['brand']);
$name = htmlspecialchars($_POST['name']);
$code = htmlspecialchars($_POST['code']);
$badge = htmlspecialchars($_POST['badge']);
$horsepower = htmlspecialchars($_POST['horsepower']);
$torque = htmlspecialchars($_POST['torque']);
$weight = htmlspecialchars($_POST['weight']);
$description = htmlspecialchars($_POST['description']);
$error = "";

if(empty($sim)) $error .= "You must fill in the used sim\n";
if(empty($brand)) $error .= "You must fill in the car-brand\n";
if(empty($name)) $error .= "You must fill in the car-model\n";
if(empty($code)) $error .= "You must fill in the simcode of the car-model\n";
if(empty($badge)) $error .= "You must fill in the name of the badge\n";
if(empty($horsepower)) $error .= "You must fill in the BHP of the car\n";
if(empty($torque)) $error .= "You must fill in the torque of the car\n";
if(empty($weight)) $error .= "You must fill in the weight of the car\n";
if(empty($description)) $error .= "You must fill in a description of the car\n";
if(!empty($error)) error($error);

$msg = "";

$query = "SELECT * FROM cars WHERE code = '$code'";
$result = mysqli_query($link,$query);
if(!$result) error("MySQL Error: " . mysqli_error($link) . "\n");
if(mysqli_num_rows($result) > 0) error("Car is already in Database\n");

$query = "INSERT INTO cars (sim, brand, name, code, badge, horsepower, torque, weight, description)
          VALUES ('$sim', '$brand', '$name','$code','$badge','$horsepower','$torque','$weight','$description')";
$result = mysqli_query($link,$query);
if(!$result) error("MySQL Error: " . mysqli_error($link) . "\n");

return_do(".?page=cars", "Car succesfully added\n$msg");
?>