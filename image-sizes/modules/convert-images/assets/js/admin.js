jQuery(function ($) {
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

        $(document).on("click", "#thumbpress-convert-all", function () {
            thumbpress_modal(true);

            $.ajax({
                url: THUMBPRESS.ajaxurl,
                type: "POST",
                data: {
                    action: "thumbpress_schedule_image_conversion",
                    _wpnonce: THUMBPRESS.nonce,
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
