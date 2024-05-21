let thumbpress_modal = ( show = true ) => {
	if(show) {
		jQuery('#image-sizes-modal').show();
	}
	else {
		jQuery('#image-sizes-modal').hide();
	}
}

	jQuery(function ($) {	

	$('.image-sizes-notice').on('click', function(e){
		e.preventDefault();
			$('#image-sizes-hide-banner').hide();

		$.ajax({
			url: THUMBPRESS.ajaxurl,
			data: {
				action: "image_sizes-notice-dismiss",
				_wpnonce: THUMBPRESS.nonce,
			},
			type: "POST"			
		});
	});
	

	$('.thumbpress-delete').click(function(e){
		if(!confirm(THUMBPRESS.confirm)) {
			e.preventDefault();
		}
	});

	$('#image-sizes_report-copy').click(function(e) {
		e.preventDefault();
		$('#image-sizes_tools-report').select();

		try {
			var successful = document.execCommand('copy');
			if( successful ){
				$(this).html('<span class="dashicons dashicons-saved"></span>');
			}
		} catch (err) {
			console.log('Oops, unable to copy!');
		}
	});

	$(".image-sizes-help-heading").click(function (e) {
		var $this = $(this);
		var target = $this.data("target");
		$(".image-sizes-help-text:not(" + target + ")").slideUp();
		if ($(target).is(":hidden")) {
			$(target).slideDown();
		} else {
			$(target).slideUp();
		}
	});

	// enable/disable
	var chk_all = $(".check-all");
	var chk_def = $(".check-all-default");
	var chk_cst = $(".check-all-custom");

	chk_all.change(function () {
		$(".check-all-default,.check-all-custom").prop("checked", this.checked).change();
	});

	chk_def.change(function () {
		$(".check-default").prop("checked", this.checked);
		$(".check-this").change();
	});

	chk_cst.change(function () {
		$(".check-custom").prop("checked", this.checked);
		$(".check-this").change();
	});

	$(".check-this").change(function (e) {
		var total = $(".check-this").length;
		var enabled = $(".check-this:not(:checked)").length;
		var disabled = $(".check-this:checked").length;

		$("#disabled-counter .counter").text(disabled);
		$("#enabled-counter .counter").text(enabled);
	}).change();

	// dismiss
	$(".image_sizes-dismiss").click(function (e) {
		var $this = $(this);

		$.ajax({
			url: THUMBPRESS.ajaxurl,
			data: {
				action: "image_sizes-dismiss",
				meta_key: $this.data("meta_key"),
			},
			type: "POST",			
		});
	});

	$("#image_sizes-regen-wrap span").click(function (e) {
		alert($(this).attr("title"));
	});

	$(document).on("click", "#cx-optimized", function (e) {
		$("#cx-nav-label-image-sizes_optimize").trigger("click");
	});

	// filter widgets - pro or free
	$('.thumb-filter').click(function(e) {
		var filter = $(this).data('filter');
		$('.thumb-filter').removeClass('active');
		$(this).addClass('active');
		$('.thumb-widget').hide();
		$(filter).show();
	});

	    // activate or deactivate all modules
    $(".thumb-module-all-active").click(function (e) {
        if (!$(".thumb-toggle-all-wrap input").is(":checked")) {
            $('.thumb-settings-modules-container input[type="checkbox"]').each(
                function () {
                    if (!$(this).prop("disabled")) {
                        $(this).prop("checked", true);
                    }
                }
            );
        } else {
            $('.thumb-settings-modules-container input[type="checkbox"]').each(
                function () {
                    if (!$(this).prop("disabled")) {
                        $(this).prop("checked", false);
                    }
                }
            );
        }
    });

    $.each(THUMBPRESS, function(index, pointer) {

    	if ( index != 'is_welcome' ) return;  

		if(pointer?.target) {
			$(pointer.target).pointer({
				content: pointer.content ,
				pointerWidth: 380,
				position: {
					edge: pointer.edge,
					align: pointer.align
				},
				close: function() {
					$.post(ajaxurl, {
						notice_name: index,
						_wpnonce: THUMBPRESS.nonce,
						action: pointer.action, 
					});
				}
			}).pointer('open');
		}
	});
	// addClass with pointer
	// parent = $('.image_sizes-para').parent();
	// parent.addClass( 'image-sizes-pointer' ) ;

	$('.image_sizes-para').parent().addClass('image-sizes-pointer');

	 


	/**
	 * Upgrade to pro slider section
	 */
	// $('.tp-user-review-wrap').slick({
	// 	infinite: true,
	// 	slidesToShow: 3,
	// 	slidesToScroll: 2,
	// 	// dots: false,
	// 	autoplay: true,
	// 	autoplaySpeed: 3000,
	// 	arrows: true,
	// 	responsive: [
	// 		{
	// 		  breakpoint: 1400,
	// 		  settings: {
	// 			slidesToShow: 3,
	// 			slidesToScroll: 2,
	// 			infinite: true,
	// 			dots: true
	// 		  }
	// 		},
	// 		{
	// 		  breakpoint: 1080,
	// 		  settings: {
	// 			slidesToShow: 2,
	// 			slidesToScroll: 2
	// 		  }
	// 		},
	// 		{
	// 		  breakpoint: 780,
	// 		  settings: {
	// 			slidesToShow: 1,
	// 			slidesToScroll: 1
	// 		  }
	// 		}
	// 	  ]
	// });

	THUMBPRESS.live_chat && THUMBPRESS.tp_page && window.addEventListener('load', function() {
		window.intercomSettings = {
			api_base: "https://api-iam.intercom.io",
			app_id: "x7h9c6di",
			name: THUMBPRESS.name,
			email: THUMBPRESS.email
		};

		// We pre-filled your app ID in the widget URL: 'https://widget.intercom.io/widget/x7h9c6di'
		(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/x7h9c6di';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(document.readyState==='complete'){l();}else if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();

		// Add click event listener to each element
		document.querySelectorAll('.tp-live-chat').forEach(function(element) {
		    element.addEventListener('click', function(e) {
		    	e.preventDefault();
		        Intercom('show');
		    });
		});
	});

	$(document).on('click', '.image_sizes-notice_ahref', function (e) {
	    e.preventDefault();
	    var redirecturl = $('a[class=image_sizes-notice_ahref]').attr('href');

	    $.ajax({
	        url: THUMBPRESS.ajaxurl,
	        type: "POST",
	        data: {
	            action: "image_sizes-pointer-dismiss",
	            _wpnonce: THUMBPRESS.nonce,
	        },
	        success: function (res) {
	            $('.image-sizes-pointer').hide();
	            console.log(res);
	            window.location.href = redirecturl;
	        },
	        error: function (err) {
	            console.log(err);
	        },
	    });
	});

});

