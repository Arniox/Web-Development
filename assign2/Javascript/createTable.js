//File - createTable
//Functions:
// - generateTableOutput(xmlTextIn) - Takes in an xml object and prints it out to the admin.html page in html format in a table. A new row for each item found in the xml object

function generateTableOutput(xmlTextIn){
   document.getElementById('adminOutPut').innerHTML = "test and see";
   var outPut = '<table class="table"><thead class="thead-light"><tr>';
   outPut += '<th scope="col">#</th>';
   outPut += '<th scope="col">Booking ID</th>';
   outPut += '<th scope="col">Customer Name</th>';
   outPut += '<th scope="col">Customer Number</th>';
   outPut += '<th scope="col">Pickup Address</th>';
   outPut += '<th scope="col">Destination Address</th>';
   outPut += '<th scope="col">Pickup Date/Time</th>';
   outPut += '<th scope="col">Registration Date</th>';
   outPut += '<th scope="col">Status</th>';
   outPut += '</tr></thead><tbody>';

   //For loop for each item in the xmlTextIn
   for(var i=0; i<xmlTextIn.length; i++){
      console.log(xmlTextIn[i]);

      //Get the text for each element from the xmlTextIn depending on the browswer type
      var bookingID = "";
      var customerName = "";
      var customerNumber = "";
      var pickUpAdd = "";
      var destinationAdd = "";
      var dateTime = "";
      var registrationTime = "";
      var status = "";
      if(window.ActiveXObject){
         bookingID = xmlTextIn[i].children[0].text;
         customerName = xmlTextIn[i].children[1].text;
         customerNumber = xmlTextIn[i].children[2].text;
         pickUpAdd = xmlTextIn[i].children[3].text;
         destinationAdd = xmlTextIn[i].children[4].text;
         dateTime = xmlTextIn[i].children[5].text;
         registrationTime = xmlTextIn[i].children[6].text;
         status = xmlTextIn[i].children[7].text;
      }else{
         bookingID = xmlTextIn[i].children[0].textContent;
         customerName = xmlTextIn[i].children[1].textContent;
         customerNumber = xmlTextIn[i].children[2].textContent;
         pickUpAdd = xmlTextIn[i].children[3].textContent;
         destinationAdd = xmlTextIn[i].children[4].textContent;
         dateTime = xmlTextIn[i].children[5].textContent;
         registrationTime = xmlTextIn[i].children[6].textContent;
         status = xmlTextIn[i].children[7].textContent;
      }
      //Concatinate the text to the table with a new row
      outPut += '<tr>';
      outPut += '<th scope="row">'+(i+1)+'</th>';
      outPut += '<td>'+bookingID+'</td>';
      outPut += '<td>'+customerName+'</td>';
      outPut += '<td>'+customerNumber+'</td>';
      outPut += '<td>'+pickUpAdd+'</td>';
      outPut += '<td>'+destinationAdd+'</td>';
      outPut += '<td>'+dateTime+'</td>';
      outPut += '<td>'+registrationTime+'</td>';
      outPut += '<td>'+status+'</td>';
      outPut += '</tr>';
   }

   //End of for loop, now end the table text;
   outPut += '</tbody></table>';
   document.getElementById('adminOutPut').innerHTML = outPut;
}
