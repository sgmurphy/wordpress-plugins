jQuery(function ($) {
    function convert( limit, offset ) {
		$.ajax({
			url: THUMBPRESS.ajaxurl,
			type: "POST",
			data: {
				action: "thumbpress_convert_images",
				offset: offset,
				limit: limit,
				_nonce: THUMBPRESS.nonce,
			},
			success: function (res) {
				if (res.has_image) {
					var progress = res.progress;
					$(".thumbpress-progress-content").text(Math.ceil(progress) + "%").css({ width: progress + "%" });

					convert(limit, res.offset);
				} else {
                    $(".thumbpress-progress-content").text("100%").css({ width: "100%" });
					$("#image_sizes-regen-thumbs").text(THUMBPRESS.converting).attr("disabled", false);
					$(".thumbpress-progress-panel .thumbpress-progress-content").addClass("progress-full");
				}
			},
			error: function (err) {
				$("#image_sizes-regen-thumbs").text(THUMBPRESS.converting).attr("disabled", false);
			},
		});
	}

    $(document).ready(function () {
        $(document).on("click", "#thumbpress-convert-image", function () {
            thumbpress_modal(true);

            $.ajax({
                url: THUMBPRESS.ajaxurl,
                type: "POST",
                data: {
                    action: "thumbpress_convert_single_image",
                    _wpnonce: THUMBPRESS.nonce,
                    image_id: $(this).data("image_id"),
                },
                success: function (resp) {
                    thumbpress_modal(false);
                    // console.log(resp);
                    window.location = window.location.pathname;
                },
                error: function (err) {
                    thumbpress_modal(false);
                    console.log(err);
                },
            });
        });

        $(document).on("click", "#thumbpress-convert-now", function () {
            $("#thumbpress-convert-now").text(THUMBPRESS.converting).attr("disabled", true);
            $("#thumbpress-message").html("").show();
            $(".thumbpress-progress-panel").hide();
            $("#processing-convert").hide();

            var limit = $('#thumbpress-convert-limit').val();
            var offset = 0;
            convert(limit, offset);
            $("#thumbpress-message").before('<div class="thumbpress-progress-panel"><div class="thumbpress-progress-content" style="width:0%"><span>0%</span></div></div></div>');
            $(".thumbpress-progress-content").text("0%").css({ width: "0%" });
            $(".thumbpress-actions-right .thumbpress-progress-panel-wrapper").show();
        });

        $(document).on("click", "#thumbpress-convert-background", function () {
            thumbpress_modal(true);
            var convert_val = $('#thumbpress-convert-limit').val();

            $.ajax({
                url: THUMBPRESS.ajaxurl,
                type: "POST",
                data: {
                    action: "thumbpress_schedule_image_conversion",
                    _wpnonce: THUMBPRESS.nonce,
                    'convert_val': convert_val,
                },
                success: function (resp) {
                    thumbpress_modal(false);
                    $("#cx-message-convert-images p").text(resp.message);
                    $("#cx-message-convert-images").show().fadeOut(3000);
                    location.reload();

                    // console.log(resp);
                },
                error: function (err) {
                    thumbpress_modal(false);
                    console.log(err);
                },
            });
        });
    });
});
