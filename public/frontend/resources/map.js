(function($) {
    "use strict";
    var HT = {}; 

    HT.loadMap = () => {
        $(document).ready(function() {

            var platform = new H.service.Platform({
                'apikey': 'HwI3lnNYwzirBSKkXL-dtfkv5hQMKc_gRxoh1El2k78'
            });

            var defaultLayers = platform.createDefaultLayers();

            var $mapContainer = $('#mapContainer');

            var mapCenterLat = $mapContainer.data('lat'); 

            var mapCenterLong = $mapContainer.data('long'); 

            var map = new H.Map(
                $mapContainer[0],  
                defaultLayers.vector.normal.map,
                {
                    zoom: 5.6,  
                    center: { 
                        lat: mapCenterLat, 
                        lng: mapCenterLong 
                    } 
                }
            );

            var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

            var ui = H.ui.UI.createDefault(map, defaultLayers.vector.normal.map);

            cities.forEach(function(city) {

                var LocatioOfMaker = { lat: city.lat, lng: city.long }
            
                var domMarker = new H.map.DomMarker( LocatioOfMaker );

                map.addObject(domMarker);
                
            });

            
        });
    };

    $(document).ready(function(){
        HT.loadMap();
    });

})(jQuery);
