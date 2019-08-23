//File - validator
//Functions:
// - getter() - gets all the inpputs and runs all the validation. Once validation is correct, then it runs the postData() Function
// - check(justCheck) - Runs the getter if the input running the function is allowed to. For the inputs, at first they are not allowed to check so they don't; onload; look red and have errors
// - changeAllowed(justCheck) - Once the button is clicked it runs check but also allows all the inputs to individually check everything
// - validator() - Runs all the validating functions and returns true only if all of them passed
// - outPutVisualError() - Checks each validation and changes the user error output based on them
// - validateName() - Checks and validates the name
// - validatePhoneNumber() - Checks and validates the phone Number
// - validatePickUpAddress() - Checks and validates the pickup Address
// - validateDestinationAddress() - Checks and validates the destionation Address
// - validateDate() - Checks and validates the date which checks both if the date is correctly formatted as well is if it's correctly timed
// - validateDateIsCorrect() - Checks if the date is infact correctly infront of the current date
// - convertDateObject() - Properly converts the date string input to a working date object

let name, phone, pickUpAddue, destinationAdd, dateTime;
let namePatt, phonePatt, pickUpPatt, destinationPatt, dateTimePatt;

var allowedToCheck = false;

function getter(justCheck){
   console.log('---------------------------------------------------------------------------------------');
   //is-invalid
   //is-valid
   name = document.getElementById('nameValidate').value;
   phone = document.getElementById('phoneValidate').value;
   pickUpAdd = document.getElementById('searchTextField').value;
   destinationAdd = document.getElementById('searchTextField2').value;
   dateTime = document.getElementById('date').value;

   console.log('name: '+name+', phone: '+phone+', pick up address: '+pickUpAdd+', destination address: '+destinationAdd+', dateTime: '+dateTime);

   //Regular expressions
   namePatt = /^([A-Z -\'])+$/i; //Anything from a-z (case insensitive) and spaces and '-'. Only allowed on one line
   phonePatt = /^(0\d{8,12})$/i; //Must start with 0 then 8-12 digits on only one line
   pickUpPatt = /^(.+)$/i //Any character of any kind and only allowed on line
   destinationPatt = /^(.+)$/i //Any character of any kind and only allowed on line
   dateTimePatt = /^(\d{4}-\d{2}-\d{2}T\d{2}:\d{2})$/; //Has to be; in order; 4 digits '-' 2 digits '-' 2 digits 'T' 2 digits ':' 2 digits

   //Validate
   let everythingPassed = validator();
   if(everythingPassed && justCheck){
      //Run xhr command to send object to sql server
      console.log('Running Commands...');
      //Post data using xhr POST format
      postData('phpFiles/bookingProcess.php', name, phone, pickUpAdd, destinationAdd, dateTime);
   }
}

function check(justCheck){
   if(allowedToCheck){
      getter(justCheck);
   }
}

function changeAllowed(justCheck){
   allowedToCheck = justCheck;
   check(justCheck);
}

function validator(){
   var namePassed = validateName(namePatt, name);
   var phonePassed = validatePhoneNumber(phonePatt, phone);
   var pickUpPassed = validatePickUpAddress(pickUpPatt, pickUpAdd);
   var destinationPassed = validateDestinationAddress(destinationPatt, destinationAdd);
   var dateTimePassed = validateDate(dateTimePatt, dateTime);

   outPutVisualError(namePassed, phonePassed, pickUpPassed, destinationPassed, dateTimePassed);

   console.log(
      'name passed: '+namePassed+
      ', phone passed: '+phonePassed+
      ', pick up address passed: '+pickUpPassed+
      ', destination address passed: '+destinationPassed+
      ', date time passed: '+dateTimePassed
   );

   //If everything is correct then go on
   if(namePassed && phonePassed && pickUpPassed && destinationPassed && dateTimePassed){
      console.log('Everything has passed');
      return true;
   }else{
      console.log('Something is wrong');
      return false;
   }
}

//Out put a visial error so the user can see what he did wrong
function outPutVisualError(namePassed, phonePassed, pickUpPassed, destinationPassed, dateTimePassed){
   var outPut = "";
   if(namePassed && phonePassed && pickUpPassed && destinationPassed && dateTimePassed){
      outPut = "";
   }else{
      document.getElementById('outPutString').style.color = "#FF0000";
      outPut = "ERROR(S):<ul>";
      if(!namePassed){ outPut += "<li>The name input is incorrectly formatted. Please only use normal naming conventions</li>"; }
      if(!phonePassed){ outPut += "<li>Your phone number is incorrectly formatted. It must start with a 0 and be from 8-13 digits long</li>"; }
      if(!pickUpPassed){ outPut += "<li>Your pick up address is incorrectly formatted</li>"; }
      if(!destinationPassed){ outPut += "<li>Your destination address is incorrectly formatted</li>"; }
      if(!dateTimePassed){ outPut += "<li>Your pick up date/time is incorrect. It must be at least 1 minute from the current time and must be correctly formatted</li>"; }
      outPut += "</ul>";
   }
   document.getElementById('outPutString').innerHTML = outPut;
}

//Validate the name matches the pattern
function validateName(namePattern, nameIn){
   if(namePattern.test(nameIn)){
      document.getElementById('nameValidate').className = "form-control is-valid";
      return true;
   }else{
      document.getElementById('nameValidate').className = "form-control is-invalid";
      return false;
   }
}

//Validate the phone number matches the pattern
function validatePhoneNumber(phonePattern, phoneIn){
   if(phonePattern.test(phoneIn)){
      document.getElementById('phoneValidate').className = "form-control is-valid";
      return true;
   }else{
      document.getElementById('phoneValidate').className = "form-control is-invalid";
      return false;
   }
}

//Validate the pickupaddress is correct
function validatePickUpAddress(pickUpAddPattern, pickUpIn){
   if(pickUpAddPattern.test(pickUpIn)){
      document.getElementById('searchTextField').className = "form-control is-valid";
      return true;
   }else{
      document.getElementById('searchTextField').className = "form-control is-invalid";
      return false;
   }
}

function validateDestinationAddress(destinationAddPattern, destinationIn){
   if(destinationAddPattern.test(destinationIn)){
      document.getElementById('searchTextField2').className = "form-control is-valid";
      return true;
   }else{
      document.getElementById('searchTextField2').className = "form-control is-invalid";
      return false;
   }
}

//Validate the date pattern
function validateDate(dateTimePattern, dateIn){
   if(dateTimePattern.test(dateIn) && validateDateIsCorrect(convertDateObject(dateIn))){
      document.getElementById('date').className = "form-control is-valid";
      return true;
   }else{
      document.getElementById('date').className = "form-control is-invalid";
      return false;
   }
}

//Validate the date to be correct and not lower than the current date
function validateDateIsCorrect(dateObject){
   let currentDate = new Date();
   if(dateObject<currentDate){
      return false;
   }else { return true; }
}

//Get a date object to pass into the validator
function convertDateObject(date){
   //yyyy-mm-ddTHH:MM:ss
   let year = date.substr(0,4); //0-3 sub strings yyyy
   let month = date.substr(5,2); //5-6 sub strings mm
   let day = date.substr(8,2); //8-9 sub strings dd
   let hour = date.substr(11,2); //11-12 sub strings HH
   let min = date.substr(14,2); //14-15 sub strings MM

   //New date dateObject
   let dateOutput = new Date(year, parseInt(month,10)-1, day, hour, min);
   return dateOutput;
}
