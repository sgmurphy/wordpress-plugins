jQuery(function ($) {
	var limit = $("#image-sizes_regenerate-thumbs-limit").val();

	$("#image-sizes_regenerate-thumbs-limit").bind("keyup mouseup", function () {
		limit = $(this).val();
	});

	var offset = 0;
	var thumbs_deleted = 0;
	var thumbs_created = 0;

	function regenerate( limit, offset, thumbs_deleted, thumbs_created ) {
		$.ajax({
			url: THUMBPRESS.ajaxurl,
			type: "POST",
			data: {
				action: "image_sizes-regen-thumbs",
				offset: offset,
				limit: limit,
				thumbs_deleteds: thumbs_deleted,
				thumbs_createds: thumbs_created,
				_nonce: THUMBPRESS.nonce,
			},
			success: function (res) {
                if( res.status == 1 ) {
                    if (res.progress != 100) {
                        regenerate(limit, res.offset, res.thumbs_deleted, res.thumbs_created);
                    }else{
                        $("#image_sizes-regen-thumbs").text(THUMBPRESS.regen).attr("disabled", false);
                        $(".thumbpress-progress-panel .thumbpress-progress-content").addClass("progress-full");  
                    }
                    if( res.progress ) {
                        var progress = res.progress;
                        $(".thumbpress-progress-content").text(Math.ceil(progress) + "%").css({ width: progress + "%" });
                    }
                    $("#processed-count").html(res.offset);
					$("#removed-count").html(res.thumbs_deleted);
					$("#regenerated-count").html(res.thumbs_created);
                }
                if( res.status == 2 ) {
					$("#thumbpress-action-now-result").hide();
					$('#thumbpress-action-no-result').show();
					$("#image_sizes-regen-thumbs").text(THUMBPRESS.regen).attr("disabled", false);
				}
			},
			error: function (err) {
				$("#image_sizes-regen-thumbs").text(THUMBPRESS.regen).attr("disabled", false);
			},
		});
	}

	// cx-regen-thumbs
	$("#image_sizes-regen-thumbs").click(function (e) {
		$("#image_sizes-regen-thumbs").text(THUMBPRESS.regening).attr("disabled", true);
		$("#thumbress-action-background-result, #thumbpress-action-no-result, #thumbpress-pro-view").hide();
		regenerate(limit, offset, thumbs_deleted, thumbs_created);
		$("#thumbpress-action-now-result").show();
	});

	// Schedule regen thumbnail
	$(document).on("click", "#image_sizes-schedule-regen-thumbs", function(e) {
		thumbpress_modal(true);

		var limit = $('#image-sizes_regenerate-thumbs-limit').val();
		$.ajax({
			url: THUMBPRESS.ajaxurl,
			data: {
				'action' 	: 'thumbpress_schedule_regenerate-thumbs',
				'_wpnonce'	: THUMBPRESS.nonce,
				'limit'		: limit,
			},
			type: 'POST',
			dataType: 'json',
			success: function(resp) {
				thumbpress_modal(false);
				$('#cx-message-optimize-images p').text(resp.message);
				$('#cx-message-optimize-images').show().fadeOut(3000);
				location.reload();
			},
			error: function (err) {
				thumbpress_modal(false);
				console.log(err);
			},
		});
	});
});
  