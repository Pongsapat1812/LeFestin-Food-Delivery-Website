// Show the user's position on a Google map.
function showMap(lat, lon) {
    // Create a LatLng object with the GPS coordinates.
    var myLatLng = new google.maps.LatLng(lat, lon);
    // Create the Map Options
    var mapOptions = {
        zoom: 15,
        center: myLatLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    // Generate the Map
    var map = new google.maps.Map(document.getElementById('map'),
        mapOptions);
    // Add a Marker to the Map
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: 'Found you!'
    });

    // Send latitude and longitude to a PHP script
    var xhr = new XMLHttpRequest();
    var url = "save_location.php";
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
        }
    };
    var data = JSON.stringify({
        "latitude": lat,
        "longitude": lon
    });
    xhr.send(data);
}

window.onload = function () {
    // Check to see if the browser supports the GeoLocation API.
    if (navigator.geolocation) {
        // Get the location
        navigator.geolocation.getCurrentPosition(function (position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;
            // Show the map
            showMap(lat, lon);
        });
    } else {
        // Print out a message to the user.
        alert('Your browser does not support GeoLocation');
    }
}