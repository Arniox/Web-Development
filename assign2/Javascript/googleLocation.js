//File - googleLocation
//Functions:
// - initialize() initializes the auto complete inputs in the booking.html page

function initialize() {
  var input = document.getElementById('searchTextField');
  var input2 = document.getElementById('searchTextField2');
  new google.maps.places.Autocomplete(input);
  new google.maps.places.Autocomplete(input2);
}

google.maps.event.addDomListener(window, 'load', initialize);
