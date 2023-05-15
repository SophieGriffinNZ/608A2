<!DOCTYPE HTML>
<html><head><title>Current Bookings</title> </head>
 <body>

<?php
include "config.php"; //load in any variables
$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

//insert DB code from here onwards
//check if the connection was good
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; //stop processing the page further
}

//prepare a query and send it to the server
$query =    'SELECT bookings.bookingID,bookings.checkIN,bookings.checkOUT,customer.firstName,customer.lastName,room.roomname
            FROM bookings
            JOIN customer ON bookings.customerID=customer.customerID
            JOIN room ON bookings.roomID=room.roomID
            ORDER BY lastName';

$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result); 
?>
<h1>Current Bookings</h1>
<h2><a href='index.php'>[Make a booking]</a><a href="index.php">[Return to main page]</a></h2>
<table border="1">
<thead><tr><th>BookingID</th><th>Room Name</th><th>Check In Date</th><th>Check Out Date</th><th>Customer Name</th><th>Action</th></tr></thead>
<?php

//makes sure we have bookings
if ($rowcount > 0) {  
    while ($row = mysqli_fetch_assoc($result)) {
	  $id = $row['bookingID'];	
      echo '<tr><td>'.$row['bookingID'].'</td><td>'.$row['roomname'].'</td><td>'.$row['checkIN'].'</td><td>'.$row['checkOUT'].'</td><td>'.$row['firstName'].' '.$row['lastName'].'</td>';
	  echo '<td><a href="viewbooking.php?id='.$id.'">[View]</a>';
	  echo '<a href="editbooking.php?id='.$id.'">[Edit]</a>';
      echo '<a href="editroom.php?id='.$id.'">[Manage Reviews]</a>';
	  echo '<a href="deletebooking.php?id='.$id.'">[Delete]</a></td>';
      echo '</tr>';
   }
} else echo "<h2>No bookings found!</h2>"; //suitable feedback

mysqli_free_result($result); //free any memory used by the query
mysqli_close($db_connection); //close the connection once done
?>
</table>
</body>
</html>
  