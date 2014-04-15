<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php echo $title_for_layout; ?>
        </title>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <?php echo $this->Html->script('movie'); ?>
        <?php echo $this->Html->css('movie'); ?>
        <script type="text/javascript"
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyfdxbRumeCZc5riHY4Pazh7Y3EHmSHws&sensor=false">
        </script>
        <script type="text/javascript">

            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    </head>
    <body>
        <h1>Find What Movies Have Been Filmed in San Francisco</h1>
        <div id="wrapper">
            <input type="text" id="movie" placeholder="Just start typing">
            <input id="search" onclick="get_locations()"  type="image" src="/findMoviesFilmedSF/app/webroot/img/search_out.png" 
                   onMouseOver="this.src = '/findMovieFilmedSF/app/webroot/img/search_in.png'" 
                   onMouseOut="this.src = '/findMovieFilmedSF/app/webroot/img/search_out.png'"alt="Search" >
            <div id="suggesion_box" ></div>
        </div>
        <input onclick="deleteMarkers();" type="image" src="/findMoviesFilmedSF/app/webroot/img/clear_out.png" 
               onMouseOver="this.src = '/findMovieFilmedSF/app/webroot/img/clear_in.png'" 
               onMouseOut="this.src = '/findMovieFilmedSF/app/webroot/img/clear_out.png'"alt="Delete Markers" >
        <div id="map-canvas"/></div>

</body>
</html>