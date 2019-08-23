<?php
   //File: actionAssign
   //Functions: actionAssign() - Runs the sql functions and inputs/outputs for assigning a booking

   require_once('adminProcess.php');

   //Function for when the action for admin is assign
   function actionAssign($conn, $sql_tble, $assignmentValue){
      $value = (int)$assignmentValue;

      //Query to check that the value exists
      $queryToRun = "SELECT BookingID FROM $sql_tble"
                  . " WHERE BookingID = $value"
                  . " AND Status = 'unassigned'";
      //Execute
      $result = mysqli_query($conn, $queryToRun);
      //If result is null than the bookingID doesn't exist
      if(!$result){
         echo "Fatal Error - For some reason the follow query failed:<br> $queryToRun";
      }else{
         //If result is empty then it couldn't find a bookingID matching user input
         if($result->num_rows == 0){
            echo "Error - The BookingID $assignmentValue either does not exist or has already been assigned to another driver. Please use <b>Display Bookings</b> to see what rides are available for you...";
         }else{
            //Value exists in the database so now edit it
            $queryToRun = "UPDATE $sql_tble"
                        . " SET Status = 'assigned'"
                        . " WHERE BookingID = $value";
            //execute
            $result = mysqli_query($conn, $queryToRun);
            //Notify user
            echo "Booking $value has been assigned to you and updated in the table. It will no longer show up when you click to show all unassigned bookings. Please have a safe drive!"
               . "<br><br>Reloading table in a moment...";

         }
      }
   }

?>
