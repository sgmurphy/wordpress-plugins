jQuery(function($) {
	let headerHight = 100;
	if(rtocScrollAnimation){
		if ( rtocScrollAnimation.rtocScrollAnimation == 'on' ){
			$('#rtoc-mokuji-wrapper a[href^="#"]').click(function(){
				let speed = 480;
				let href= $(this).attr("href");
				let target = $(href == "#" || href == "" ? 'html' : href);
				let position = target.offset().top;
				$("html, body").animate({scrollTop:position - headerHight}, speed, "swing");
				return false;
			});
		}
	}
});
