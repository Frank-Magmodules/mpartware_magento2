setTimeout(function () {
	console.log('Init slider with timeout');
	var headerSwiper = new Swiper ('.swiper-container.swiper-1', {
		loop: true,
		pagination: {
			el: '.swiper-pagination',
			type: 'bullets',
			clickable: true,
		},
		autoplay: {
			delay: 8000,
		},
		speed: 1000,
		preloadImages: true,
		lazy: true,
		fadeEffect: {
			crossFade: true
		},
	});
}, 1000);
