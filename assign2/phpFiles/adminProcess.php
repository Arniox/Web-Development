<?php
   // File: actionView
   // Functions: checkTable() - Checks if the table exists. If it doesn't then create it
   // Classes: BookingObject - A booking object containing a bookingID, customerName, customerNumber, pickUpAddress, destinationAddress, dateTime, registrationTime, and status

   //Get the config file for logging into the sql mysqlnd_ms_dump_server
   require_once('../Config/database_config_inc.php');
   require_once('toXml.php');
   require_once('actionView.php');
   require_once('actionAssign.php');

   //Booking object
   class BookingObject{
      public $bookingID;
      public $customerName;
      public $customerNumber;
      public $pickUpAddress;
      public $destinationAddress;
      public $dateTime;
      public $registrationTime;
      public $status;
      function __construct($IDin, $nameIn, $numIn, $pickIn, $destIn, $dateIn, $regiIn, $statusIn){
         $this->bookingID = $IDin;
         $this->customerName = $nameIn;
         $this->customerNumber = $numIn;
         $this->pickUpAddress = $pickIn;
         $this->destinationAddress = $destIn;
         $this->dateTime = $dateIn;
         $this->registrationTime = $regiIn;
         $this->status = $statusIn;
      }
   }

   //create connection
   $conn = @mysqli_connect(
      $sql_host,
      $sql_user,
      $sql_pass,
      $sql_db
   );

   //If connection is all good then continue
   if(!$conn){
      echo "Fatal Error - Database connection could not be established...";
   }else{
      //set the current time in use to NZ for time checking
      date_default_timezone_set('Pacific/Auckland');
      $dateToCheckAgainst = date('Y-m-d H:i:sa');

      //Check if the table exists first
      checkTable($conn, $sql_tble);
      //if the action being passed from js is view then get all table
      $action = $_GET['action'];
      if($action=="view"){
         actionView($conn, $sql_tble, $dateToCheckAgainst);
      }else if($action=="assign"){
         $assignmentValue = $_GET['assignNum'];
         actionAssign($conn, $sql_tble, $assignmentValue);
      }
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
