 <!DOCTYPE HTML>
<html><head><title>Add a new booking</title>
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
include "cleaninput.php";

//the data was sent using a formtherefore we use the $_POST instead of $_GET
//check if we are saving data first by checking if the submit button exists in the array
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Add')) {
//if ($_SERVER["REQUEST_METHOD"] == "POST") { //alternative simpler POST test    
    include "config.php"; //load in any variables
    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
        exit; //stop processing the page further
    };

//validate incoming data - only the first field is done for you in this example - rest is up to you do
//roomname
    $error = 0; //clear our error flag
    $msg = 'Error: ';
    if (isset($_POST['roomname']) and !empty($_POST['roomname']) and is_string($_POST['roomname'])) {
       $fn = cleanInput($_POST['roomname']); 
       $roomname = (strlen($fn)>50)?substr($fn,1,50):$fn; //check length and clip if too big
       //we would also do context checking here for contents, etc       
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid roomname '; //append eror message
       $roomname = '';  
    } 
 
//checkIN
       $description = cleanInput($_POST['description']);        
//check in date
        $checkIN = cleanInput($_POST['checkIN']); 
//check out date
       $checkOUT = cleanInput($_POST['checkOUT']); 
//contact number
       $contactNumber = cleanInput($_POST['contactNumber']);        
//booking extras
       $extras = cleanInput($_POST['extras']);      
       
//save the booking data if the error flag is still clear
    if ($error == 0) {
        $query = "INSERT INTO bookings (roomname,checkIN,checkOUT,contactNumber,Extras) VALUES (?,?,?,?,?)";
        $stmt = mysqli_prepare($db_connection, $query); //prepare the query
        mysqli_stmt_bind_param($stmt,'sssd', $roomname, $checkIN, $checkOUT, $contactNumber, $extras); 
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);    
        echo "<h2>New booking added to the list</h2>";        
    } else { 
      echo "<h2>$msg</h2>".PHP_EOL;
    }      
    mysqli_close($db_connection); //close the connection once done
}
?>
<h1>Add a new booking</h1>
<h2><a href='listbookings.php'>[Return to the booking listings]</a><a href='index.php'>[Return to the main page]</a></h2>

<form method="POST" action="addbooking.php">
  <p>
    <label for="roomname">Room (name, type, beds): </label>
    <input type="text" id="roomname" name="roomname" minlength="5" maxlength="50" required> 
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
  
   <input type="submit" name="submit" value="Add">
 </form>
</body>
</html>
  