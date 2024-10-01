(function($) {
    "use strict";
    var HT = {}; 

    function createSlug(name) {
        const specialChars = {
            'á': 'a', 'à': 'a', 'ả': 'a', 'ã': 'a', 'ạ': 'a',
            'ắ': 'a', 'ằ': 'a', 'ẳ': 'a', 'ẵ': 'a', 'ặ': 'a',
            'â': 'a', 'ê': 'e', 'ế': 'e', 'ề': 'e', 'ể': 'e', 'ễ': 'e', 'ệ': 'e',
            'í': 'i', 'ì': 'i', 'ỉ': 'i', 'ĩ': 'i', 'ị': 'i',
            'ó': 'o', 'ò': 'o', 'ỏ': 'o', 'õ': 'o', 'ọ': 'o',
            'ố': 'o', 'ồ': 'o', 'ổ': 'o', 'ỗ': 'o', 'ộ': 'o',
            'ú': 'u', 'ù': 'u', 'ủ': 'u', 'ũ': 'u', 'ụ': 'u',
            'ý': 'y', 'ỳ': 'y', 'ỷ': 'y', 'ỹ': 'y', 'ỵ': 'y',
            'đ': 'd'
        };
    
        name = name.split('').map(char => specialChars[char] || char).join('');
    
        return name
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/--+/g, '-') 
            .replace(/^-+|-+$/g, ''); 
    }
    

    HT.loadMap = () => {
        
        var platform = new H.service.Platform({
            'apikey': 'HwI3lnNYwzirBSKkXL-dtfkv5hQMKc_gRxoh1El2k78'
        });

        var defaultLayers = platform.createDefaultLayers();

        var mapCenterLat = $('#mapContainer').data('lat'); 

        var mapCenterLong = $('#mapContainer').data('long'); 

        var zoom = $('#mapContainer').data('zoom');

        var map = new H.Map(document.getElementById('mapContainer'),
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

                    var curentUrl = window.location.href;

                    var name = createSlug(city.name);

                    var newUrl = curentUrl + 'location/' + name + '/' + city.id + '.html'  ;

                    window.location.href = newUrl

                });

                map.addObject(domMarker);

                var nameDiv = document.createElement('div');

                nameDiv.innerHTML = city.name;

                Object.assign(nameDiv.style, {
                    position: 'absolute', transform: 'translate(-50%, -10px)', color: 'black',
                    fontWeight: 'bold',fontSize: '13px',cursor: 'pointer', 
                });

                map.getElement().appendChild(nameDiv);

                map.addEventListener('mapviewchange', function() {

                    var coords = map.geoToScreen(LocatioOfMaker);

                    nameDiv.style.left = `${coords.x}px`;

                    nameDiv.style.top = `${coords.y + 10}px`;

                });

            });

        }
    
    };


    HT.loadLocation = () => {

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

                var domIcon = HT.createCircularDomIconWithLabel(item.image, item.name, 48, item.code);

                var domMarker = HT.createDomMarkerWithOffset(LocatioOfMaker, domIcon);

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

                domMarker.addEventListener('tap', function(evt) {

                    var bubble = new H.ui.InfoBubble(LocatioOfMaker, {

                        content: HT.loadPopUp(item) 

                    });

                    ui.addBubble(bubble);

                    HT.swiperPopup(); 
                    
                });
            });

        }
            
    }

    HT.swiperPopup = () => {
		var swiper = new Swiper(".panel-album .swiper-container", {
			loop: false,
			pagination: {
				el: '.swiper-pagination',
			},
			spaceBetween: 20,
			slidesPerView: 2,
			breakpoints: {
				300: {
					slidesPerView: 1,
				},
				500: {
				  slidesPerView: 1,
				},
				768: {
				  slidesPerView: 1,
				},
				1280: {
					slidesPerView: 1,
				}
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			
		});
	}


    HT.loadPopUp = (item) => {


        let album = JSON.parse(item.album)

        let slides = '';

        album.forEach(image => {
            slides += `<div class="swiper-slide">
                    <div class="slide-item">
                        <span class="image img-cover"><img src="${image}" alt=""></span>
                    </div>
                </div>`;
        });

        let html = `<div class="popup">
                        <div class="panel-album">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    ${slides}
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                        <strong>${item.name}</strong>
                        <div class="info">
                            <div class="uk-grid uk-grid-medium">
                                <div class="uk-width-medium-1-2">
                                    <a href="" class="map">
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.37464 13.0262C8.64995 11.921 11.5941 9.0207 11.5941 5.79704C11.5941 3.14771 9.44636 1 6.79704 1C4.14771 1 2 3.14771 2 5.79704C2 9.0207 4.94412 11.921 6.21943 13.0262C6.55458 13.3166 7.03949 13.3166 7.37464 13.0262Z" fill="#D7E0FF" stroke="#A6A6A6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M6.79705 7.48014C7.88217 7.48014 8.76183 6.60048 8.76183 5.51536C8.76183 4.43024 7.88217 3.55058 6.79705 3.55058C5.71194 3.55058 4.83228 4.43024 4.83228 5.51536C4.83228 6.60048 5.71194 7.48014 6.79705 7.48014Z" fill="white" stroke="#A6A6A6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Xem bản đồ
                                    </a>
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <p class="price">
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.93323 1.1397L2.79016 4.244L10.8577 4.95292L9.31607 1.56777C9.07585 1.04029 8.42944 0.840196 7.93323 1.1397Z" fill="white"/>
                                            <path d="M1.5456 10.9204C1.70795 11.8424 2.44527 12.5832 3.37082 12.7236C4.28984 12.8631 5.11971 13 6.39428 13C7.66884 13 8.49871 12.8631 9.41773 12.7236C10.3433 12.5832 11.0806 11.8424 11.2429 10.9204C11.3682 10.2091 11.4825 9.59134 11.4825 8.39637C11.4825 7.2014 11.3682 6.58368 11.2429 5.87234C11.0806 4.95039 10.3433 4.20954 9.41773 4.06912C8.49871 3.92969 7.66884 3.79278 6.39428 3.79278C5.11971 3.79278 4.28984 3.92969 3.37082 4.06912C2.44527 4.20954 1.70795 4.95039 1.5456 5.87234C1.42034 6.58368 1.30609 7.2014 1.30609 8.39637C1.30609 9.59134 1.42034 10.2091 1.5456 10.9204Z" fill="#D7E0FF" stroke="#A6A6A6" stroke-width="1.5"/>
                                            <path d="M11.6939 9.80163H8.81723C8.01434 9.80163 7.36346 9.15076 7.36346 8.34786C7.36346 7.54497 8.01434 6.8941 8.81723 6.8941H11.6939C12.2462 6.8941 12.6939 7.34181 12.6939 7.8941V8.80163C12.6939 9.35391 12.2462 9.80163 11.6939 9.80163Z" fill="white" stroke="#A6A6A6" stroke-width="1.5" stroke-linecap="round"/>
                                            <path d="M2.79016 4.244L7.93323 1.1397C8.42944 0.840196 9.07585 1.04029 9.31607 1.56777L10.8577 4.95292" stroke="#A6A6A6" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                        ${addCommas(item.price)}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="status">
                            <p class="hour">
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="10.5" cy="10.5" r="9.5" fill="#D7E0FF" stroke="#A6A6A6" stroke-width="1.5"/>
                                    <path d="M10 7V10.75L13 13" stroke="#A6A6A6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>${open_hours[item.open_hours]}</span>
                            </p>
                            <p class="room">
                                <svg width="22" height="25" viewBox="0 0 22 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.83496 5.52686C0.913258 7.73847 0.921047 13.8531 1.08358 16.8479C1.1192 17.5043 1.68999 18 2.37476 18H10.6252C11.31 18 11.8808 17.5043 11.9164 16.8479C12.079 13.8531 12.0867 7.73847 11.165 5.52686C10.6216 4.83135 9.28033 3.39849 7.64731 2.33839C6.95229 1.8872 6.04771 1.8872 5.35269 2.33839C3.71967 3.39849 2.37843 4.83135 1.83496 5.52686Z" fill="white" stroke="#A6A6A6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M11.2547 9H14.3899C15.4944 9 16.4447 9.49907 16.6498 10.5043C16.9645 12.0464 17.1694 14.6621 16.809 18H10C10.7132 18 11.3076 17.5018 11.3447 16.8422C11.4539 14.9011 11.496 11.6561 11.2547 9Z" fill="#D7E0FF" stroke="#A6A6A6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6 11H7" stroke="#A6A6A6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6 18V15" stroke="#A6A6A6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6 7H7" stroke="#A6A6A6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>${total_rooms[item.total_rooms]} Phòng</span>
                            </p>
                            <p class="color">
                                <span style="border:1px solid ${item.code}; color: ${item.code};">${item.description}</span>
                            </p>
                        </div>
                    </div>`
        return html;
    }

    HT.createCircularDomIconWithLabel = (imageUrl, label, size = 64, background) => {

        const container = document.createElement('div');

        container.style.position = 'relative';
    
        const img = document.createElement('div');

        img.className = 'circular-marker';

        img.style.backgroundImage = `url(${imageUrl})`;
        
        img.style.width = `${size}px`;

        img.style.height = `${size}px`;

        Object.assign(img.style, {
            backgroundSize: 'cover',  
            borderRadius: '50%',      
            border: `3px solid ${background}`, 
            boxShadow: '0 0 5px rgba(0, 0, 0, 0.3)' 
        });

        const labelDiv = document.createElement('div');

        labelDiv.className = 'marker-label';

        labelDiv.textContent = label;

        Object.assign(labelDiv.style, {
            background: background || 'rgba(0, 0, 0, 0.5)',
            padding: '3px 10px',
            fontWeight:'normal',
            color:'#fff',
            textAlign:'center',
            textShadow:'none',
        });
    
        container.appendChild(img);

        container.appendChild(labelDiv);
        
        return new H.map.DomIcon(container);
    }
    
    HT.createDomMarkerWithOffset = (location, icon, offsetY = -24) => {
        return new H.map.DomMarker(location, {
            icon: icon,
            anchor: { x: 24, y: 48 + Math.abs(offsetY) }
        });
    }

    HT.changeQuantity = () => {

		$(document).on('click','.quantity-button', function(){

			let _this = $(this)

            let quantityInput = _this.closest('.quantitybox').find('.quantity-text');

            let quantity = _this.closest('.quantitybox').find('.quantity-text').val();

			let newQuantity = 0

			if(_this.hasClass('minus')){
                newQuantity =  quantity - 1
			}else{
                newQuantity = parseInt(quantity) + 1
			}
			if(newQuantity < 1){
				newQuantity = 1
			}
			quantityInput.val(newQuantity)
		})

	}

    HT.open = () => {
        $(document).on('click','.btn-per', function(){
            $('.popup-content').addClass('active'),
            $('.button-premission').removeClass('active')
        });
    }

    HT.close = () => {
		$('.filter-close').on('click', function(){
			$('.popup-content').removeClass('active'),
            $('.button-premission').addClass('active')
		})
	}

    HT.addActive = () => {

        $(document).ready(function() {

            var currentUrl = window.location.href;

            $('.location-item').each(function() {

                var linkUrl = $(this).attr('href');

                if (linkUrl === currentUrl) {

                    $(this).addClass('active');

                }
            });
        });

    }


    $(document).ready(function(){

        HT.addActive()

        HT.open()

        HT.close()

        HT.changeQuantity()

        if($('#mapContainer').length > 0) {
            HT.loadMap()
        }
    
        if($('#mapLocation').length > 0) {
            HT.loadLocation();
        }
    });

})(jQuery);
addCommas = (nStr) => { 
    nStr = String(nStr);
    nStr = nStr.replace(/\./gi, "");
    let str ='';
    for (let i = nStr.length; i > 0; i -= 3){
        let a = ( (i-3) < 0 ) ? 0 : (i-3);
        str= nStr.slice(a,i) + '.' + str;
    }
    str= str.slice(0,str.length-1);
    return str;
}
