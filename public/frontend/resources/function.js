(function($) {
	"use strict";
	var HT = {}; // Khai báo là 1 đối tượng
	var timer;
	var $carousel = $(".owl-slide");
	var _token = $('meta[name="csrf-token"]').attr('content');

	HT.swiperOption = (setting) => {
		let option = {}
		if(setting.animation.length){
			option.effect = setting.animation;
		}	
		if(setting.arrow === 'accept'){
			option.navigation = {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			}
		}
		if(setting.autoplay === 'accept'){
			option.autoplay = {
			    delay: 50000,
			    disableOnInteraction: false,
			}
		}
		if(setting.navigate === 'dots'){
			option.pagination = {
				el: '.swiper-pagination',
			}
		}
		return option
	}
	
	/* MAIN VARIABLE */
	HT.swiper = () => {
		if($('.panel-slide').length){
			let setting = JSON.parse($('.panel-slide').attr('data-setting'))
			let option = HT.swiperOption(setting)
			var swiper = new Swiper(".panel-slide .swiper-container", option);
		}
		
	}

	HT.carousel = () => {
		$carousel.each(function(){
			let _this = $(this);
			let option = _this.find('.owl-carousel').attr('data-owl');
			let owlInit = atob(option);
			owlInit = JSON.parse(owlInit);
			_this.find('.owl-carousel').owlCarousel(owlInit);
		});
		
	} 

	HT.swiperNews = () => {
		var swiper = new Swiper(".panel-news .swiper-container", {
			loop: false,
			pagination: {
				el: '.swiper-pagination',
			},
			spaceBetween: 20,
			slidesPerView: 2,
			breakpoints: {
				300: {
					slidesPerView: 2,
				},
				500: {
				  slidesPerView: 2,
				},
				768: {
				  slidesPerView: 2,
				},
				1280: {
					slidesPerView: 4,
				}
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			
		});
	}

	HT.wow = () => {
		var wow = new WOW(
			{
			  boxClass:     'wow',      // animated element css class (default is wow)
			  animateClass: 'animated', // animation css class (default is animated)
			  offset:       0,          // distance to the element when triggering the animation (default is 0)
			  mobile:       true,       // trigger animations on mobile devices (default is true)
			  live:         true,       // act on asynchronously loaded content (default is true)
			  callback:     function(box) {
				// the callback is fired every time an animation is started
				// the argument that is passed in is the DOM node being animated
			  },
			  scrollContainer: null,    // optional scroll container selector, otherwise use window,
			  resetAnimation: true,     // reset animation on end (default is true)
			}
		  );
		  wow.init();


	}// arrow function

	HT.niceSelect = () => {
		if($('.nice-select').length){
			$('.nice-select').niceSelect();
		}
		
	}

	HT.select2 = () => {
		if($('.setupSelect2').length){
			$('.setupSelect2').select2();
		}
		
	}

	HT.openPreviewVideo = () => {
		$('.choose-video').on('click', function(e){
			e.preventDefault()
			let _this = $(this)
			let option = {
				id: _this.attr('data-id')
			}
			$.ajax({
				url: 'ajax/post/video', 
				type: 'GET', 
				data: option, 
				dataType: 'json', 
				beforeSend: function() {
					
				},
				success: function(res) {
					$('.video-preview .video-play').html(res.html)
					$('.video-preview video').attr('autoplay', 'autoplay');
					$('.video-preview iframe').attr('src', function (i, val) {
						return val + (val.indexOf('?') !== -1 ? '&' : '?') + 'autoplay=1';
					});
				},
			});

		})
	}

	HT.showContact = () => {
		let isShown = false;
	
		$(document).on('click', '.bottom-support-online', function(){
			if (isShown) {
				$(this).removeClass('show');
				isShown = false;
			} else {
				$(this).addClass('show');
				isShown = true;
			}
		});
	};

	HT.removePagination = () => {
		$('.filter-content').on('slide', function() {
			$('.uk-flex .pagination').hide();
		});
	};


	HT.wrapTable = () => {
		var width = $(window).width()
		if(width < 600){
			$('table').wrap('<div class="uk-overflow-container"></div>')
		}
	}
    
	HT.btnSendCode = () => {
       $(document).on('click', '.btn-send', function(e){
			e.preventDefault()
			let email = $('.register-form input[name="email"]').val()
			if(!email) {
				alert('Vui lòng nhập Email');
				return;
			}
			let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			if (!emailRegex.test(email)) {
				alert('Email không đúng định dạng');
				return;
			}
			$.ajax({
				url: 'ajax/send/code', 
				type: 'POST', 
				data: {
				   email : email,
				   _token: _token
				}, 
				dataType: 'json', 
				beforeSend: function(res) {
					
				},
				success: function(res) {
					toastr.success(res.messages, 'Thông báo từ hệ thống !')
				},
			});
	   })
	}

	HT.activeNotification = () => {

        $(document).on('click', '.header-upper .notification', function(e){

			e.preventDefault()

			let _this = $(this)

			_this.toggleClass('active')

			$('.notification-list').toggleClass('active');

			let countNotificationNew = $('.notification .count').data('count')

			let customer_id = $('.notification').data('customer')

			if(countNotificationNew !== 0){
                
                $.ajax({

					url: 'ajax/change/totalNotificationNew', 

					type: 'GET', 

					data: {
					   total_notification_new : countNotificationNew,
					   customer_id : customer_id
					}, 

					dataType: 'json', 

					beforeSend: function(res) {
						
					},
					success: function(res) {
						if(res.status == 200){
							$('.header-upper .count').hide()
						}
					},

				});
				
			}


		})
		
	}

	function convertToDatabaseFormat(isoDateString) {

		const date = new Date(isoDateString);

		date.setHours(date.getHours() + 7); 

		const year = date.getUTCFullYear();

		const month = String(date.getUTCMonth() + 1).padStart(2, '0');

		const day = String(date.getUTCDate()).padStart(2, '0');

		const hours = String(date.getUTCHours()).padStart(2, '0');

		const minutes = String(date.getUTCMinutes()).padStart(2, '0');

		const seconds = String(date.getUTCSeconds()).padStart(2, '0');

		return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

	}

	HT.checkNotification = () => {

		$(document).ready(function() {

			let lastCheckTime = convertToDatabaseFormat(new Date().toISOString());

			if($('.header-upper .notification').data('alert') == 1){

				let customer_id = $('.header-upper .notification').data('customer')

				function fetchNotifications() {

					$.ajax({

						url: '/ajax/notification/check',

						method: 'GET',

						data: { last_check_time: lastCheckTime , customer_id : customer_id },

						success: function(data) {
							if (data.notifications.length > 0) {

								lastCheckTime = convertToDatabaseFormat(new Date().toISOString());

								$('.notification .count').attr('data-count', data.total).text(data.total);
								
								HT.updateNotifications(data.notifications);
							}
						},
						error: function(jqXHR, textStatus, errorThrown) {
							console.error('Error fetching notifications:', textStatus, errorThrown);
						}
					});
				}
		    
				setInterval(fetchNotifications,10000);
			}
			
		});
		
		
		
	}
    

	HT.updateNotifications = function(data, callback){

		const $notificationList = $('.notification-list'); 

		const $popup = $('.notification-popup');

		let newNotificationsHtml = '';

		let newPopupHtml = '';

		data.forEach(notification => {
			newPopupHtml += `
				<li>
					<a href="http://127.0.0.1:8000/${notification.canonical}.html" class="l1">
						<div class="thumb image img-cover">
							<img src="${notification.image}" alt="">
						</div>
						<div class="title">
							<p class="name">${notification.name}</p>
							<p class="time">Vài giây trước</p>
						</div>
					</a>
				</li>
			`;
		});

		data.forEach(notification => {
			newNotificationsHtml += `
				<li>
					<a href="http://127.0.0.1:8000/${notification.canonical}.html" class="l1">
						<div class="thumb image img-cover">
							<img src="${notification.image}" alt="">
						</div>
						<div class="title">
							<p class="name">${notification.name}</p>
							<p class="time">${notification.created_at}</p>
						</div>
					</a>
				</li>
			`;
		});

		$popup.append(newPopupHtml);

		$notificationList.append(newNotificationsHtml);

		setTimeout(() => {
			$popup.html('');  
			if (typeof callback === 'function') {
				callback();
			}
		}, 8000);
	
	}

	HT.changeAlert = () => {

		$(document).on('click','.panel-profile .notification', function(e){

			e.preventDefault(); 

			let _this = $(this)

			let alert = _this.attr('data-alert');

			let customer_id = $('.customerId').data('id')

			$.ajax({
				url: 'ajax/change/alert', 
				type: 'GET', 
				data: {
				   alert : alert,
				   customer_id : customer_id
				}, 
				dataType: 'json', 
				beforeSend: function(res) {
					
				},
				success: function(res) {
					_this.attr('data-alert', res.alert);
					if(res.alert == 1){
						_this.addClass('active')
					}else{
						_this.removeClass('active');
					}
				},
			});
			
		});
	}

	
	HT.registerEvent = () => {
		$(document).on('click','.register-event', function(e){

            e.preventDefault()

			let _this = $(this)

			let customer_id = $('.table .customer_id').val()

			let event_id = _this.data('event')

			let status = _this.data('status')

			// let startDate = new Date($('.startDate').data('start').replace(' ', 'T'))

			// let endDate = new Date($('.endDate').data('end').replace(' ', 'T'))

			// let currentTime = new Date()

			// if(startDate <= currentTime){
			// 	alert('Sự kiện đang diễn ra ! Vui lòng chờ các sự kiện khác ')
			// 	return;
			// }

			if(customer_id == 0){

				window.location.href = 'customer/login.html'

				toastr.error('Bạn phải đăng nhập để thực hiện chức năng này !');

			}

			$.ajax({
				url: 'ajax/customer/registerEvent', 
				type: 'GET', 
				data: {
				  	customer_id : customer_id,
					event_id : event_id,
					status :  status
				}, 
				dataType: 'json', 
				beforeSend: function(res) {
					
				},
				success: function(res) {
					if(res.status == 1){
						_this.attr('data-status', res.status).text('Đã đăng ký')
					}else{
						_this.attr('data-status', res.status).text('Đăng ký sự kiện')
					}
					
				},
			});


			

		})
	}

	HT.registerNotification = () => {
		$(document).on('click', '.nt-home', function(e){
			e.preventDefault()
			let _this = $(this)
			let post_catalogue_id = _this.data('post-catalogue')
			let customer_id = $('.customer_id').val()

			if(customer_id == 0){

				window.location.href = 'customer/login.html'

				toastr.error('Bạn phải đăng nhập để thực hiện chức năng này !');

			}

			$.ajax({
				url: 'ajax/customer/registerNotification', 
				type: 'GET', 
				data: {
				  	customer_id : customer_id,
					post_catalogue_id : post_catalogue_id,
				}, 
				dataType: 'json', 
				beforeSend: function(res) {
					
				},
				success: function(res) {
					if(res.alert == 1){
						_this.addClass('active')
					}else{
						_this.removeClass('active')
					}
				},
			});
		})
	}


	$(document).ready(function(){

		HT.registerNotification()

		HT.registerEvent()

		HT.changeAlert()

		HT.checkNotification()

		HT.activeNotification()

		HT.btnSendCode()

		HT.swiperNews()

		HT.removePagination()

		HT.showContact()

		HT.wow()
		
		/* CORE JS */
		HT.swiper()

		HT.niceSelect()		

		HT.carousel()

		HT.select2()

		HT.openPreviewVideo()

		HT.wrapTable()
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