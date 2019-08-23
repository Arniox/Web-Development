//File - dateFunction
//Functions:
// - getData() - Get and sets the current date with the current time zone (pacific/Auckland) into the date input
// - window.onload = function(){} - on loading of the window, runs the getDate() Functions
// - runLoop() - Mostly testing purposes but it's supposed to constantly update the date input in the admin.html page

//Set the date
var updateLoop;

function getDate(){
   let today = new Date();
   let dd = (today.getDate()<10 ? '0'+today.getDate() : today.getDate());
   let month = ((today.getMonth()+1)<10 ? '0'+today.getMonth() : today.getMonth()); //Jan is 0
   let yyyy = today.getFullYear();
   let hh = (today.getHours()<10 ? '0'+today.getHours() : today.getHours());
   let mm = (today.getMinutes()<10 ? '0'+today.getMinutes() : today.getMinutes());

   //Month needs to add 1 since Jan is 0
   let monthAdd = parseInt(month, 10)+1;
   let monthOutput = (monthAdd<10 ? '0'+monthAdd : monthAdd);

   today = yyyy + '-' + monthOutput + '-' + dd + 'T' + hh + ':' + mm;

   document.getElementById("date").value = today;
   document.getElementById("date").min = today;

   console.log('Current date: '+today);
   console.log('Minimum Date: '+document.getElementById("date").min);

}

window.onload = function() {
   getDate();
};

function runLoop(){
   updateLoop = setInterval(getDate, 1000);
}
