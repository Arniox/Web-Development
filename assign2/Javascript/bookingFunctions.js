//File - bookingFunctions
//Functions:
// - postData(destinationFile, customerName, customerNumber, pickUpAdd, destinationAdd, dateTime) - Takes all user input and using an XHR object, sends it to the server for saving

//using POST method
var xhr = createRequest();
function postData(destinationFile, customerName, customerNumber, pickUpAdd, destinationAdd, dateTime){
   //if an xhr object exists
   if(xhr){
      //Clean up all the inputs and remove random white space
      customerName = customerName.trim();
      customerNumber = customerNumber.trim();
      pickUpAdd = pickUpAdd.trim();
      destinationAdd = destinationAdd.trim();
      dateTime = dateTime.trim();

      //Set up xhr requestbody
      var requestBody = "customerName="+encodeURIComponent(customerName)+
      "&customerNumber="+encodeURIComponent(customerNumber)+
      "&pickUpAddress="+encodeURIComponent(pickUpAdd)+
      "&destinationAddress="+encodeURIComponent(destinationAdd)+
      "&dateTime="+encodeURIComponent(dateTime);

      console.log("requestBody = "+requestBody);
      //Open xhr object for POST method
      xhr.open("POST", destinationFile, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      //Set function for response
      xhr.onreadystatechange = function(){
         if(xhr.readyState == 4 && xhr.status == 200){
            var responseFromServer = xhr.responseText;
            console.log("server response: "+responseFromServer);
            //If the request throws an error anywhere. Alert the user
            if(responseFromServer.includes("Error")){
               document.getElementById('outPutString').style.color = "#FF0000";
               document.getElementById('outPutString').innerHTML = responseFromServer;
            }
            //If the request is otherwise all good, then set the out put div to the response
            else{
               document.getElementById('outPutString').style.color = "#000000";
               document.getElementById('outPutString').innerHTML = responseFromServer;
            }
         }
      } //End response function
      xhr.send(requestBody);
   }
}
