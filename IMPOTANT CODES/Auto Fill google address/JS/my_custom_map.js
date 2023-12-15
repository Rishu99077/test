var source, destination;
var directionsDisplay;
var map;
google.maps.event.addDomListener(window, 'load', function () {
    /*var places1 = new google.maps.places.SearchBox(document.getElementById('txtSource'));
    var places2 = new google.maps.places.SearchBox(document.getElementById('txtDestination'));*/
    var places1 = new google.maps.places.Autocomplete(document.getElementById('txtSource'));
    var places2 = new google.maps.places.Autocomplete(document.getElementById('txtDestination'));
    directionsDisplay = new google.maps.DirectionsRenderer({ 'draggable': true });
    google.maps.event.addListener(places1, 'place_changed', function () {
        GetRoutelocation();
    });
    google.maps.event.addListener(places2, 'place_changed', function () {
        GetRoutelocation();
    });
});
function initMap() {

}
function GetRoutelocation(){
   source = document.getElementById("txtSource").value;
   destination = document.getElementById("txtDestination").value;     
   if(source!='' && destination!=''){
        document.getElementById("txtSourcep").innerHTML= source;
        document.getElementById("txtDestinationp").innerHTML= destination;
        GetRoute();
   }
}
function GetRoute() {
  var directionsService = new google.maps.DirectionsService();
    var center = new google.maps.LatLng(18.9750, 72.8258);
    var mapOptions = {
        zoom: 7,
        center: center
    };
    map = new google.maps.Map(document.getElementById('dvMap'), mapOptions);
    directionsDisplay.setMap(map);

    //*********DIRECTIONS AND ROUTE**********************//
    source = document.getElementById("txtSource").value;
    destination = document.getElementById("txtDestination").value;

    var request = {
        origin: source,
        destination: destination,
        travelMode: google.maps.TravelMode.DRIVING
    };
    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });

    //*********DISTANCE AND DURATION**********************//
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix({
        origins: [source],
        destinations: [destination],
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC,
        avoidHighways: false,
        avoidTolls: false
    }, function (response, status) {
        if (status == google.maps.DistanceMatrixStatus.OK && response.rows[0].elements[0].status != "ZERO_RESULTS") {
            var distancevalue = response.rows[0].elements[0].distance.value;
            var distance = response.rows[0].elements[0].distance.text;
            var duration = response.rows[0].elements[0].duration.text;
            var dvDistance = document.getElementById("dvDistance");
            dvDistance.innerHTML = "";
            dvDistance.innerHTML += "Distance: " + distance + "<br />";
            dvDistance.innerHTML += "Duration:" + duration;
            var price1 = distancevalue/1000;
            var price2 = price1*3.5;
            var price = price2+6;
            document.getElementById("price").value = price;
        } else {
            alert("Unable to find the distance via road.");
        }
    });
}

jQuery('#txtTime').on('change', function () {
    txtTime = $( "#txtTime option:selected" ).val();
    jQuery('#txtTimep').html(txtTime);
});

$('#txtDdate').change(function() {
    var date = $(this).val();
    jQuery('#txtDdatep').html(date);
});

$(document).ready(function(){  
  $("#btnnext").click(function(){
    $('.err').html('');
    var txtSource = $('#txtSource').val();
    var txtDestination = $('#txtDestination').val();
    var optionSelected = $( "#txtTime option:selected" ).val();
    var date = $('#txtDdatep').html();
    var passengers = $('#txtpassengers').val();
    
    if(txtSource==''){
        $('#err_txtSource').html('Please Select START');
        return false;
    }
    if(txtDestination==''){
        $('#err_txtDestination').html('Please Select ZIEL');
        return false;
    }

    if(date==''){
        $('#err_date').html('Please Select date');
        return false;
    }
    if(optionSelected==''){
        $('#err_optionSelected').html('Please Select time');
        return false;
    }
    if(passengers==''){
        $('#err_passengers').val('Please Select FAHRGÄSTE');
        return false;
    }

    
    $('#txtTimep').html(optionSelected);
    jQuery('#txtDdatep').html(date);
    var price = parseFloat(jQuery('#price').val());
    price1 = price.toFixed(2);
    htmlpassengers = passengers+'<span style="float: right;">CHF '+price1+'</span>';
    jQuery('#txtpassengersp').html(htmlpassengers);

    htmlpassengers1 = 'Total inkl. Mwst <span style="float: right;">CHF '+price1+'</span>';
    jQuery('#txtpassengersp1').html(htmlpassengers1);

    $('.step1').hide();
    $('.step2').show();
  });  


  $("#btnprev").click(function(){
    $('.step2').hide();
    $('.step1').show();
  });  

});