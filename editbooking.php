<!DOCTYPE HTML>
<html><head><title>Edit a booking</title>
		<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>  
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	  
	        <!-- Javascript -->  
      <script>  
         $(function() {  
            $( "#checkIN" ).datepicker();
			$( "#checkOUT" ).datepicker();
         });  
      </script> 
	</head>
 <body>

 <?php
include "config.php"; //load in any variables
include "cleaninput.php";

$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
$error=0;
if (mysqli_connect_errno()) {
  echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
  exit; //stop processing the page further
};

//retrieve the bookingID from the URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid booking ID</h2>"; //simple error feedback
        exit;
    } 
}
//the data was sent using a formtherefore we use the $_POST instead of $_GET
//check if we are saving data first by checking if the submit button exists in the array
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Update')) {     
//validate incoming data - only the first field is done for you in this example - rest is up to you do
    
//bookingID (sent via a form ti is a string not a number so we try a type conversion!)    
    if (isset($_POST['id']) and !empty($_POST['id']) and is_integer(intval($_POST['id']))) {
       $id = cleanInput($_POST['id']); 
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid booking ID '; //append error message
       $id = 0;  
    }   
//roomname
       $roomname = cleanInput($_POST['roomname']);
//check in date
       $checkIN = cleanInput($_POST['checkIN']); 
//check out date
       $checkOUT = cleanInput($_POST['checkOUT']); 
//contact number
       $contactNumber = cleanInput($_POST['contactNumber']);        
//booking extras
       $extras = cleanInput($_POST['extras']);   
//room review
       $roomReview = cleanInput($_POST['roomReview']);         
    
//save the booking data if the error flag is still clear and booking id is > 0
    if ($error == 0 and $id > 0)
	  {
        $query = "UPDATE bookings SET roomID=?,checkIN=?,checkOUT=?,contactNumber=?,extras=?,roomReview=? WHERE bookingID=?";
        $stmt = mysqli_prepare($db_connection, $query); //prepare the query
        mysqli_stmt_bind_param($stmt,'ssssi', $roomID, $checkIN, $checkOUT, $contactNumber, $extras, $roomReview, $id); 
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);    
        echo "<h2>Booking details updated.</h2>";  
    } 
	  else
	  { 
      echo "<h2>$msg</h2>";
    }      
}
//locate the booking to edit by using the bookingID
//we also include the booking ID in our form for sending it back for saving the data
$query = 'SELECT bookingID,roomID,checkIN,checkOUT,contactNumber,extras,roomReview FROM bookings WHERE bookingid='.$id;
$result = mysqli_query($db_connection,$query);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {
  $row = mysqli_fetch_assoc($result);

?>
<h1>Booking Details Update</h1>
<h2><a href='listbookings.php'>[Return to the booking listings]</a><a href='index.php'>[Return to the main page]</a></h2>

<form method="POST" action="editbooking.php">
  <input type="hidden" name="id" value="<?php echo $id;?>">
   <p>
    <label for="roomID">Room (name, type, beds): </label>
    <input type="text" id="roomID" name="roomID" minlength="5" maxlength="50" value="<?php echo $row['roomID']; ?>" required> 
  </p>
	<p> 
    <label for="checkIN">Check In Date: </label> 
	<input type="text" id="checkIN" name="checkIN" value="<?php echo $row['checkIN']; ?>" required>
    </p>
	<p> 
    <label for="checkOUT">Check Out Date: </label> 
	<input type="text" id="checkOUT" name="checkOUT" value="<?php echo $row['checkOUT']; ?>" required>
    </p>
  <p>
    <label for="contactNumber">Contact Number: </label>
    <input type="text" id="contactNumber" name="contactNumber" minlength="7" maxlength="15" value="<?php echo $row['contactNumber']; ?>" required> 
  </p> 
   <p>
    <label for="extras">Booking Extras: </label>
    <input type="text" id="extras" name="extras" size="100" minlength="5" maxlength="200" value="<?php echo $row['extras']; ?>" > 
  </p> 
  <p>
    <label for="roomReview">Room Review: </label>
    <input type="text" id="roomReview" name="roomReview" size="100" minlength="5" maxlength="200" value="<?php echo $row['roomReview']; ?>" > 
  </p> 
   <input type="submit" name="submit" value="Update">
 </form>
<?php 
} 
else
{ 
  echo "<h2>Booking not found with that ID</h2>"; //simple error feedback
}
mysqli_close($db_connection); //close the connection once done
?>
</body>
</html>
  