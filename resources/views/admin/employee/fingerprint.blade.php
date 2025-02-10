@extends('layouts.admin')

@section('title', __('messages.fingerprint'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('messages.fingerprint') }}</h3>
    </div>
    <div class="card-body">

        <button class="button btn btn-success" id="getLocation">{{__('messages.fingerprint')}}</button>
        <p id="locationInfo"></p>
        <div id="map" style="height: 300px;"></div>

        <div id="message" class="mt-3"></div>

    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASHbeWWuIpbm0KXycXP8-pRJdBvvYK_Rs&callback=initMap" async defer></script>

<script>
    var map, marker;

    function initMap() {
        var defaultLocation = { lat: 25.276987, lng: 55.296249 };
        map = new google.maps.Map(document.getElementById('map'), {
            center: defaultLocation,
            zoom: 15
        });
        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map
        });
    }

    $(document).ready(function () {
        $("#getLocation").click(function () {
            /*if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) { // Success callback
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;

                        $("#locationInfo").html(`Latitude: ${lat}, Longitude: ${lng}`);
                        updateMap(lat, lng);
                        sendLocationToServer(lat, lng);
                    },
                    function (error) { // Error callback
                        console.error("Error getting location: ", error);
                        showMessage("Error getting location. Ensure location services are enabled.", "danger");
                    }
                );
            } else {
                showMessage("Geolocation is not supported by this browser.", "danger");
            }*/
            if (true) {

                        var lat=25.2769870;
                        var lng=55.2962490;

                        $("#locationInfo").html(`Latitude: ${lat}, Longitude: ${lng}`);
                        updateMap(lat, lng);
                        sendLocationToServer(lat, lng);
                    
                
            } else {
                showMessage("Geolocation is not supported by this browser.", "danger");
            }            
        });
    });

    function updateMap(lat, lng) {
        var newLocation = { lat: lat, lng: lng };
        map.setCenter(newLocation);
        marker.setPosition(newLocation);
    }

    function sendLocationToServer(lat, lng) {
        $.ajax({
            url: "getMyLocationToFingerPrint",
            type: "POST",
            data: {
                lat: lat,
                lng: lng,
                _token: $('meta[name="csrf-token"]').attr("content"), // CSRF Token
            },
            success: function(response) {
                console.log(response);
                if (response.status === "success") {
                    showMessage(response.message, "success");
                } else if (response.status === "error" && response.errors) {
                    // Loop through validation errors and display them
                    var errorMessages = '';
                    $.each(response.errors, function(key, value) {
                        errorMessages += '<p>' + value + '</p>';
                    });
                    showMessage(errorMessages, "danger");
                } else {
                    showMessage(response.message, "danger");
                }
            },
            error: function(xhr) {
                showMessage("Something went wrong. Try again.", "danger");
            }
        });
    }

    function showMessage(message, type) {
        $("#message").html(`<div class="alert alert-${type}">${message}</div>`);
    }


</script>
@endsection
