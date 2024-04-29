jQuery(function ($) {
	var limit = $("#image-sizes_regenerate-thumbs-limit").val();

	$("#image-sizes_regenerate-thumbs-limit").bind("keyup mouseup", function () {
		limit = $(this).val();
	});

	var offset = 0;
	var thumbs_deleted = 0;
	var thumbs_created = 0;

	function regenerate(limit, offset, thumbs_deleted, thumbs_created) {
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
				if (res.has_image) {
					var progress = (res.offset / res.total_images_count) * 100;
					$(".image-sizes-progress-content").text(Math.ceil(progress) + "%").css({ width: progress + "%" });

					regenerate(limit, res.offset, res.thumbs_deleted, res.thumbs_created);
				} else {
					$("#image_sizes-regen-thumbs").text(THUMBPRESS.regen).attr("disabled", false);
					$(".image-sizes-progress-panel .image-sizes-progress-content").addClass("progress-full");
				}
				$("#image_sizes-message").html(res.message).show();
			},
			error: function (err) {
				$("#image_sizes-regen-thumbs").text(THUMBPRESS.regen).attr("disabled", false);
			},
		});
	}

	// cx-regen-thumbs
	$("#image_sizes-regen-thumbs").click(function (e) {
		$("#image_sizes-regen-thumbs").text(THUMBPRESS.regening).attr("disabled", true);
		$("#image_sizes-message").html("").hide();
		$(".image-sizes-progress-panel").hide();

		regenerate(limit, offset, thumbs_deleted, thumbs_created);

		$("#image_sizes-message").before('<div class="image-sizes-progress-panel"><div class="image-sizes-progress-content" style="width:0%"><span>0%</span></div></div></div>');
	});
});
  