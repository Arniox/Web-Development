<?php
   // File: toXml
   // Functions: toXmlFunction() - Converts incoming data from the MySQL server into an xml object to output to the JavaScript functionality

   require_once('adminProcess.php');


   function toXmlFunction($bookingListOut){
      //XML document creation
      $doc = new DomDocument('1.0');
      //Create the booking list
      $list = $doc->createElement('bookingList');
      $doc->appendChild($list);

      //For each item in the booking list coming from the sql request, convert it to an xml document
      foreach($bookingListOut as $singularBooking){
         //in the booking list xml object there is multiple booking xml objects
         $booking = $doc->createElement('booking');
         $list->appendChild($booking);

         //Booking id
         $bookingID = $doc->createElement('bookingID');
         $booking->appendChild($bookingID);
         $bookingIDIn = $doc->createTextNode($singularBooking->bookingID);
         $bookingID->appendChild($bookingIDIn);

         //Customer name
         $customerName = $doc->createElement('customerName');
         $booking->appendChild($customerName);
         $customerNameIn = $doc->createTextNode($singularBooking->customerName);
         $customerName->appendChild($customerNameIn);

         //Customer number
         $customerNumber = $doc->createElement('customerNumber');
         $booking->appendChild($customerNumber);
         $customerNumberIn = $doc->createTextNode($singularBooking->customerNumber);
         $customerNumber->appendChild($customerNumberIn);

         //Pick up address
         $pickupAddress = $doc->createElement('pickupAddress');
         $booking->appendChild($pickupAddress);
         $pickupAddressIn = $doc->createTextNode($singularBooking->pickUpAddress);
         $pickupAddress->appendChild($pickupAddressIn);

         //Destination address
         $destinationAddress = $doc->createElement('destinationAddress');
         $booking->appendChild($destinationAddress);
         $destinationAddressIn = $doc->createTextNode($singularBooking->destinationAddress);
         $destinationAddress->appendChild($destinationAddressIn);

         //Date time
         $dateTime = $doc->createElement('dateTime');
         $booking->appendChild($dateTime);
         $dateTimeIn = $doc->createTextNode($singularBooking->dateTime);
         $dateTime->appendChild($dateTimeIn);

         //Registration time
         $registrationTime = $doc->createElement('registrationTime');
         $booking->appendChild($registrationTime);
         $registrationTimeIn = $doc->createTextNode($singularBooking->registrationTime);
         $registrationTime->appendChild($registrationTimeIn);

         //Status
         $status = $doc->createElement('status');
         $booking->appendChild($status);
         $statusIn = $doc->createTextNode($singularBooking->status);
         $status->appendChild($statusIn);
      }

      //Save entire object as an xml and return it
      $strXml = $doc->saveXML();
      return $strXml;
   }


?>
