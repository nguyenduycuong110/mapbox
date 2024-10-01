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

            var zoom = $mapContainer.data('zoom');

            var map = new H.Map(
                $mapContainer[0],  
                defaultLayers.vector.normal.map,
                {
                    zoom: zoom,  
                    center: { 
                        lat: mapCenterLat, 
                        lng: mapCenterLong 
                    },
                    pixelRatio: window.devicePixelRatio || 1
                }
            );

            window.addEventListener('resize', () => map.getViewPort().resize());

            var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

            var ui = H.ui.UI.createDefault(map, defaultLayers.vector.normal.map);
 
            var svgIcon = new H.map.Icon("/userfiles/image/location-2955.svg", { size: { w: 48, h: 48 }});

            if(cities){
                cities.forEach(function(city) {

                    var LocatioOfMaker = { 
                        lat: parseFloat(city.lat), 
                        lng: parseFloat(city.long) 
                    }
                    
                    var domMarker = new H.map.Marker(LocatioOfMaker, { icon:svgIcon } );

                    domMarker.addEventListener('pointerdown', function() {
                        map.setCenter(LocatioOfMaker);

                        map.setZoom(8);

                    });

                    map.addObject(domMarker);
    
                    var nameDiv = document.createElement('div');

                    nameDiv.innerHTML = city.name;

                    Object.assign(nameDiv.style, {
                        position: 'absolute', transform: 'translate(-50%, -10px)', color: 'black',
                        fontWeight: 'bold',fontSize: '14px',cursor: 'pointer', 
                    });

                    map.getElement().appendChild(nameDiv);
    
                    map.addEventListener('mapviewchange', function() {
    
                        var coords = map.geoToScreen(LocatioOfMaker);
    
                        nameDiv.style.left = `${coords.x}px`;
    
                        nameDiv.style.top = `${coords.y + 10}px`;
    
                    });
    
                });
    
            }
            
        });
    };

    HT.loadLocation = () => {
        $(document).ready(function() {

            var platform = new H.service.Platform({
                'apikey': 'HwI3lnNYwzirBSKkXL-dtfkv5hQMKc_gRxoh1El2k78'
            });

            var defaultLayers = platform.createDefaultLayers();

            var latLocation = $('#mapLocation').data('lat');

            var longLocation = $('#mapLocation').data('long');

            var map = new H.Map(document.getElementById('mapLocation'),

                defaultLayers.vector.normal.map, {

                center: {
                    lat: latLocation, 
                    lng: longLocation,
                },

                zoom: 13,

                pixelRatio: window.devicePixelRatio || 13

            });

            window.addEventListener('resize', () => map.getViewPort().resize());

            var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

            var ui = H.ui.UI.createDefault(map, defaultLayers.vector.normal.map);
         

            if(homeStay){
                homeStay.forEach(function(item) {

                    var LocatioOfMaker = { 

                        lat: parseFloat(item.lat), 

                        lng: parseFloat(item.long) 

                    }
                
                    var svgIcon = new H.map.Icon(item.image , { size: { w: 48, h: 48 }});
                    
                    var domMarker = new H.map.Marker(LocatioOfMaker, { icon:svgIcon } );

                    map.addObject(domMarker);
    
                    var nameDiv = document.createElement('div');

                    nameDiv.innerHTML = item.name;

                    nameDiv.className = 'homestay';

                    Object.assign(nameDiv.style, {
                        background : item.code, 
                    });

                    map.getElement().appendChild(nameDiv);
    
                    map.addEventListener('mapviewchange', function() {
    
                        var coords = map.geoToScreen(LocatioOfMaker);
    
                        nameDiv.style.left = `${coords.x}px`;
    
                        nameDiv.style.top = `${coords.y + 10}px`;
    
                    });
    
                });
    
            }
            
        });
            
    }

    
    $(document).ready(function(){

        if($('#mapContainer').length) {
            HT.loadMap();
        }

        if($('#mapLocation').length) {
            HT.loadLocation();
        }
    });

})(jQuery);
