<?php
   // File: actionView
   // Functions: actionView() - Runs the sql functions and inputs/outputs for viewing all the unassigned bookings within 2 hours

   require_once('adminProcess.php');

   //Function for when the admin action is view
   function actionView($conn, $sql_tble, $dateToCheckAgainst){
      //Create a new query. Select all from table where status is unassigned
      //And the DateTimeOfRide is less or equal to 2 hours from the current time
      $queryToRun = "SELECT * FROM $sql_tble"
                  . " WHERE Status = 'unassigned'"
                  . " AND DateTimeOfRide > TIMESTAMP('$dateToCheckAgainst')"
                  . " AND DateTimeOfRide < DATE_ADD(TIMESTAMP('$dateToCheckAgainst'), INTERVAL 2 HOUR)";
      //execute
      $result = mysqli_query($conn, $queryToRun);
      //If result is empty, then errors
      if(!$result){
         echo "Fatal Error - For some reason the following query failed:<br> $queryToRun";
      }else{
         //Create an array ready for the xml data
         $bookingListOut = array();
         while($row = mysqli_fetch_assoc($result)){
            $IDin = $row["BookingID"];
            $nameIn = $row["CustomerName"];
            $numIn = $row["CustomerNumber"];
            $pickIn = $row["PickupAddress"];
            $destIn = $row["DestinationAddress"];
            $dateIn = $row["DateTimeOfRide"];
            $regiIn = $row["RegistrationTime"];
            $statusIn = $row["Status"];

            //Create a new booking object and add it to the booking arrayList with array_push
            $singularBooking = new BookingObject($IDin, $nameIn, $numIn, $pickIn, $destIn, $dateIn, $regiIn, $statusIn);
            array_push($bookingListOut, $singularBooking);
         }

         // //Once array finishes, convert the array to an xml object if full
         // //If it's empty then there is no bookings within 2 hours that are unassigned
         if(sizeOf($bookingListOut)==0){
            echo "There are no more unassigned taxi bookings within 2 hours of $dateToCheckAgainst. Please check back later for more work...";
         }else{
            echo toXmlFunction($bookingListOut);
         }
      }
   }

?>
