jQuery(function ($) {
    function convert( limit, offset ) {
		$.ajax({
			url: THUMBPRESS.ajaxurl,
			type: "POST",
			data: {
				action: "thumbpress_convert_images",
				offset: offset,
				limit: limit,
				_wpnonce: THUMBPRESS.nonce,
			},
			success: function (res) {
                if( res.status == 1 ) {
                    if (res.progress != 100) {
                        convert(limit, res.offset);
                    }else{
                        $("#thumbpress-convert-now").text(THUMBPRESS.convertNow).attr("disabled", false);
                        $(".thumbpress-progress-panel .thumbpress-progress-content").addClass("progress-full");  
                    }
                    if( res.progress ) {
                        var progress = res.progress;
                        $(".thumbpress-progress-content").text(Math.ceil(progress) + "%").css({ width: progress + "%" });
                    }
                    $("#processed-count").html(res.offset);
                }
                if( res.status == 2 ) {
                    $("#thumbpress-action-now-result").hide();
					$('#thumbpress-action-no-result').show();
					$("#thumbpress-convert-now").text(THUMBPRESS.convertNow).attr("disabled", false);
				}
			},
			error: function (err) {
				$("#thumbpress-convert-now").text(THUMBPRESS.converting).attr("disabled", false);
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

            var limit = $('#thumbpress-convert-limit').val();
            var offset = 0;
            $("#thumbress-action-background-result, #thumbpress-action-no-result, #thumbpress-pro-view").hide();
            convert(limit, offset);
            $("#thumbpress-action-now-result").show();
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
