//File - scaling
//Funtions:
// - scaler() gets the current window width and scales some stuff in the admin.html page for better mobile and computer output
// - window.onload = function(){} onloading of the windows, runs scaler()

function scaler(){
   var windowWidth = window.outerWidth;
   console.log("Window Width is "+windowWidth);

   //If window width is bellow a certain value assume that it's on mobile
   if(windowWidth < 900){
      document.getElementById('adminOutPut').className = "fluid-col col-md-12";
   }else{
      document.getElementById('adminOutPut').className = "fluid-col col-md-8";
   }
}

window.onload = function() {
   scaler();
};
