<?php
   //File: bookingProcess
   //Functions: checkTable() - Checks if the table exists. If it doesn't then create it

   //Get the config file for logging into the sql mysqlnd_ms_dump_server
   require_once('../Config/database_config_inc.php');
   //create a connection object and try connect
   $conn = @mysqli_connect(
      $sql_host,
      $sql_user,
      $sql_pass,
      $sql_db
   );

   //Get user inputs
   $customerName = $_POST['customerName'];
   $customerNumber = $_POST['customerNumber'];
   $pickUpAddress = $_POST['pickUpAddress'];
   $destinationAddress = $_POST['destinationAddress'];
   $dateTime = $_POST['dateTime'];

   //Secondary values to remove unescapped characters but reserve user output
   $cName = addslashes($customerName);
   $cNumber = addslashes($customerNumber);
   $cPick = addslashes($pickUpAddress);
   $cDest = addslashes($destinationAddress);
   $cDateTime = addslashes($dateTime);

   //If connection fails then errors
   if(!$conn){
      echo "Fatal Error - Database connection could not be established...";
   }else{
      //Check and see if the table exists at all. If it doesn't then recreate it
      checkTable($conn, $sql_tble);

      //Booking ID is AUTO_INCREMENT so no need to generate a new value
      //name, number, pickup and destination are all given by the user. As well as the pick up time.
      //current time is needed for registration time
      date_default_timezone_set('Pacific/Auckland');
      $registrationTime = date('Y-m-d H:i:sa');
      //query
      $queryToRun = "INSERT INTO $sql_tble"
            . "(CustomerName, CustomerNumber, PickupAddress, DestinationAddress, DateTimeOfRide, RegistrationTime)"
            . "VALUES"
            . "('$cName','$cNumber','$cPick','$cDest','$cDateTime','$registrationTime')";
      //execute
      $result = mysqli_query($conn, $queryToRun);

      //Requery for the booking ID
      $queryToRun2 = "SELECT BookingID FROM $sql_tble"
                   . " WHERE RegistrationTime = (SELECT MAX(RegistrationTime) FROM $sql_tble)";
      //Execute
      $result2 = mysqli_query($conn, $queryToRun2);
      //If no result then there's an error
      if(!$result || !$result2){
         echo "Error - One of the queries has failed to run and did not complete for some reason.<br>Query 1: $queryToRun<br>Query 2: $queryToRun2";
      }else{
         $time = substr($dateTime,11);
         $year = substr($dateTime,0,4);
         $month = substr($dateTime,5,2);
         $day = substr($dateTime,8,2);
         $dateOutput = "$day/$month/$year";

         $row = mysqli_fetch_assoc($result2);
         $bookingID = $row["BookingID"];

         echo "Thank you $customerName for booking with our taxi booking service. Your unique bookingID is $bookingID."
            . " We will text you at $customerNumber when the cab is ready for you."
            . " Your ride should arrive at $time on $dateOutput near $pickUpAddress";
      }
      //Now that query has run. Close connection
      mysqli_close($conn);

   }


   //Check table exists
   function checkTable($connection, $table){
      //Describe
      $queryToRun = "DESCRIBE $table";
      if(mysqli_query($connection, $queryToRun)==false){
         //Create table
         $queryToRun = "CREATE TABLE Taxi_Booking_Service(
                     	BookingID INT PRIMARY KEY AUTO_INCREMENT,
                     	CustomerName VARCHAR(100) NOT NULL,
                     	CustomerNumber INT(13) NOT NULL,
                     	PickupAddress VARCHAR(200) NOT NULL,
                     	DestinationAddress VARCHAR(200) NOT NULL,
                     	DateTimeOfRide TIMESTAMP NOT NULL,
                     	RegistrationTime TIMESTAMP NOT NULL,
                     	Status enum('assigned','unassigned') DEFAULT 'unassigned' NOT NULL
                     )";
         //Execute table creation
         mysqli_query($connection, $queryToRun);

         //Optimise the table
         $queryToRun = "ALTER TABLE `Taxi_Booking_Service` ADD INDEX `taxi_booking_service_idx_status_datetimeofride` (`Status`,`DateTimeOfRide`)";
         mysqli_query($connection, $queryToRun);

         //Set time DateTimeZone
         $queryToRun = "SET time_zone = '+12:00'";
         mysqli_query($connection, $queryToRun);
      }
   }

 ?>
