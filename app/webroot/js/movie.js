$(document).ready(function() {

    var suggesion_box = $("#suggesion_box");
    var movies = [];
    $.ajax({// get the titles from the database
        url: "/findMovieFilmedSF/movies/get_titles",
        success: function(data) {
            var obj = jQuery.parseJSON(data);
            get_movies(obj.movies);
        }
    });
    function get_movies(data) {
        movies = data;//store all titles for future use
    }

/**
 * Reads user input and displays movies that match the input
 */
    $("#movie").keyup(function() {
        var movies_tmp = movies;
        if (!$('#movie').val()) {//if input is empty erase & close the suggestion box
            suggesion_box.slideUp();
            suggesion_box.empty();
        } else {
            $(suggesion_box).empty();//clear the box from previous attempts 
            var movie = $('#movie').val();//get the input
            //capitalize the first letter of the string
            movie = movie.toLowerCase().replace(/\b[a-z]/g, function(movie) {
                return movie.toUpperCase();
            });
            //find if the input matches any movie
            movies_tmp = $.grep(movies_tmp, function(value, i) {
                return (value.indexOf(movie) == 0);
            });
            if (movies_tmp.length) {//if any match found put it in the suggestion box and show it
                for (var i = 0; i < movies_tmp.length; i++) {
                    $(suggesion_box).append("<div class=\"suggestion\">" + movies_tmp[i] + "</div>");
                }
                $(suggesion_box).slideDown();
            } else {
                console.log("no matching movies!");
            }
        }
    });
    //on click put the desired movie into the input box
    $(document).on("click", ".suggestion", function() {
        $("#movie").val($(this).text());
    });
    //if there is a click outside the suggesion box close this box
    $(document).on("click", "body", function(event) {
        if (!suggesion_box.is(event.target)) {
            $(suggesion_box).slideUp(400, function() {
                $(suggesion_box).empty();//empty the box only after it's closed
            });
        }
    });
});

/**
 * 
 * Shows the map using Google Maps JavaScript API v3
 */
function initialize() {
    var centerLatlng = new google.maps.LatLng(37.766813, -122.455998);
    var mapOptions = {
        zoom: 12,
        center: centerLatlng
    }
    var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
}

var markers = [];

/**
 * 
 * Gets locations of a movie and shows it using Google Maps JavaScript API v3
 */
function get_locations() {
    var title = $('#movie').val();
    //get locations from the database
    $.post("/findMovieFilmedSF/movies/get_locations", {title: title})
            .done(function(data) {
                var obj = jQuery.parseJSON(data);
                var centerLatlng = new google.maps.LatLng(37.766813, -122.455998);
                var mapOptions = {
                    zoom: 12,
                    center: centerLatlng
                }
                var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
                //iterate through the data and create a marker for each location
                $.each(obj, function(index, value) {
                    var LatLng;
                    var location;
                    $.each(value, function(index, value) {
                        if (index == "LatLng") {
                            var arr = value.split(',');
                            LatLng = new google.maps.LatLng(arr[0], arr[1]);
                        } else if(index == "location") {
                            location = value;
                        }
                        var marker = new google.maps.Marker({
                            position: LatLng,
                            map: map,
                            title: location
                        });
                        markers.push(marker);//store the marker in array
                    });
                });
            });
            $('#movie').val('');
}
/**
 * 
 * Clears the markers from the map
 */
function deleteMarkers() {
    if(markers){
        for(var i=0;i<markers.length;i++){
            markers[i].setMap(null);
        }
        markers.length=0;
    }
}