//File - xhr
//Functions:
// - createRequest() Creats an XHR request

//Create a request
function createRequest() {
   var xhr = false;
   if (window.XMLHttpRequest) {
      xhr = new XMLHttpRequest();
   }else if (window.ActiveXObject) {
      xhr = new ActiveXObject("Microsoft.XMLHTTP");
   }
   return xhr;
}
