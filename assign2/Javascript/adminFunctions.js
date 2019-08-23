//File - Admin Functions
//Functions:
// - runXHRConnection(action, assignNum) - Uses an XHR object to connect to the server and either show or assign bookings
// - validateBookingId() - Validates the booking ID input from the user

var xhr = createRequest();

//Show all booking function
function runXHRConnection(action, assignNum){
   var phpFile = "phpFiles/adminProcess.php";
   var errorOutPut = "Error(s)<ul>";

   //If xhr object exists then run
   if(xhr){
      //Open a new xhr request with GET function
      var url = phpFile + "?action=" + action + "&assignNum=" + assignNum;
      console.log('Request Body: '+url);
      xhr.open("GET", url, true);
      //anonymous function to run
      xhr.onreadystatechange = function() {
         if(xhr.readyState == 4 && xhr.status == 200){
            //Convert the xhr response text to an xml document parsed from string
            var parser = new DOMParser();
            var xmlDocResponse = parser.parseFromString(xhr.responseText, "text/xml");

            //If the response is not null then all good
            if(xmlDocResponse != null){
               //Get an error output length to check if there are any errors
               var errorOut = xmlDocResponse.getElementsByTagName('parsererror').length
               if(errorOut == 0){
                  //No errors
                  var listOfAllUnassigned = xmlDocResponse.getElementsByTagName('booking');
                  generateTableOutput(listOfAllUnassigned);
               }else{
                  var directServerString = xhr.responseText;
                  console.log("Server Response: "+directServerString);
                  if(directServerString.includes("has been assigned to you and updated in the table")){
                     //If the server response contains an assigned message than it's not an error
                     //Clean the errorOutPut text
                     errorOutPut = xhr.responseText;
                     document.getElementById('errorOutPut').style.color = "#000000";
                     document.getElementById('errorOutPut').innerHTML = errorOutPut;
                  }else{
                     //Out put other than an xml object such as no results
                     //Out put is also NOT an assignment output
                     //If the error is simply that there is no unassigned bookings for this time then display as black text
                     if(directServerString.includes("There are no more unassigned taxi bookings")){
                        errorOutPut = xhr.responseText;
                        document.getElementById('errorOutPut').style.color = "#000000";
                        document.getElementById('errorOutPut').innerHTML = errorOutPut;
                        document.getElementById('adminOutPut').innerHTML = "";
                     }
                     //If it's a proper error then show as red in an error list
                     else{
                        errorOutPut += "<li>"+xhr.responseText+"</li></ul>";
                        document.getElementById('bookingIdValidate').className = "form-control is-invalid";
                        document.getElementById('errorOutPut').style.color = "#FF0000";
                        document.getElementById('errorOutPut').innerHTML = errorOutPut;
                     }
                  }
               }
            }else{
               //Fatal error just in case a parsing issue or XML reading issue was caused
               errorOutPut += "<li>Fatal Error - XML document was not able to be read or parsed</li></ul>";
               document.getElementById('errorOutPut').innerHTML = errorOutPut;
            }
         }
      }
      //End anonymouse function
      xhr.send(null);
   }
}

//Validate the booking id input
function validateBookingId(){
   var bookingID = document.getElementById('bookingIdValidate').value;
   let bookingIDPatt = /^(\d+)$/i;
   let errorOutPut = "Error(s)<ul>";

   //Valid
   if(bookingIDPatt.test(bookingID) && parseInt(bookingID)>0){
      console.log(bookingID+' Input is correct');
      errorOutPut = "";
      document.getElementById('bookingIdValidate').className = "form-control is-valid";
      //Input is valid so run the show all function
      runXHRConnection('assign',bookingID);
      //Reload the table after half a second to let server respond
      setTimeout(function(){
         runXHRConnection('view','0');
      }, 5000);

   }else{
      document.getElementById('bookingIdValidate').className = "form-control is-invalid";
      errorOutPut += "<li>BookingID input is incorrect. Please make sure it is an integer and is more than 0</li>";
      errorOutPut += "</ul>";
      document.getElementById('errorOutPut').style.color = "#FF0000";
   }

   document.getElementById('errorOutPut').innerHTML = errorOutPut;
}
