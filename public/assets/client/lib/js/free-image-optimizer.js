jQuery(document).ready(function ($) {
    var rt_precision = 0; function imeTestPath() { $("#cli_path_progress").show(); jQuery.get(ajaxurl, { action: "ime_test_im_path", ime_nonce: $("#ime_nonce").val(), cli_path: $("#cli_path").val(), }, function (data) { $("#cli_path_progress").hide(); r = parseInt(data); if (r > 0) { alert("ThÃ nh cÃ´ng") } else { alert("Tháº¥t báº¡i") } }) }
    function imeRegenImages(id, rt_images, rt_sizes, rt_force) {
        $.post(ajaxurl, { action: "ime_process_image", ime_nonce: $("#ime_nonce").val(), id: id, sizes: rt_sizes, force: rt_force, }, function (data) {
            var n = parseInt(data, 10); if (isNaN(n)) { alert(data) }
            if (rt_images.length <= 0) { $("#cli_path_progress").text("HoÃ n thÃ nh"); $("#cli_path_progress").hide(); alert("HoÃ n thanh"); return }
            var next_id = rt_images.shift(); var rt_percent = (rt_count / rt_total) * 100; $("#cli_path_progress").text("Äang cháº¡y " + rt_percent.toFixed(rt_precision) + " %"); rt_count = rt_count + 1; imeRegenImages(next_id, rt_images, rt_sizes, rt_force)
        })
    }
    function imeRegenImagesOrigin(id, rt_images, rt_force) {
        $.post(ajaxurl, { action: "ime_process_image_origin", ime_nonce: $("#ime_nonce").val(), id: id, force: rt_force, }, function (data) {
            var n = parseInt(data, 10); if (isNaN(n)) { alert(data) }
            if (rt_images.length <= 0) { $("#cli_path_progress").text("HoÃ n thÃ nh"); $("#cli_path_progress").hide(); alert("HoÃ n thanh"); return }
            var next_id = rt_images.shift(); var rt_percent = (rt_count / rt_total) * 100; $("#cli_path_progress").text("Äang cháº¡y " + rt_percent.toFixed(rt_precision) + " %"); rt_count = rt_count + 1; imeRegenImagesOrigin(next_id, rt_images, rt_force)
        })
    }
    function imeStartResize(rt_images, rt_total) {
        rt_sizes = ""; rt_force = 0; $("#regenerate-images-metabox input").each(function () { var i = $(this); var name = i.attr("name"); if (i.is(":checked") && name && "regen-size-" == name.substring(0, 11)) { rt_sizes = rt_sizes + name.substring(11) + "|" } }); if ($("#force").is(":checked")) { rt_force = 1 }
        if (rt_total > 20000) { rt_precision = 3 } else if (rt_total > 2000) { rt_precision = 2 } else if (rt_total > 200) { rt_precision = 1 } else { rt_precision = 0 }
        rt_count = 1; $("#cli_path_progress").show(); $("#cli_path_progress").text("Äang cháº¡y 0 %"); imeRegenImages(rt_images.shift(), rt_images, rt_sizes, rt_force)
    }
    function imeStartResizeOrigin(rt_images, rt_total) {
        rt_force = 0; if ($("#force").is(":checked")) { rt_force = 1 }
        if (rt_total > 20000) { rt_precision = 3 } else if (rt_total > 2000) { rt_precision = 2 } else if (rt_total > 200) { rt_precision = 1 } else { rt_precision = 0 }
        rt_count = 1; $("#cli_path_progress").show(); $("#cli_path_progress").text("Äang cháº¡y 0 %"); imeRegenImagesOrigin(rt_images.shift(), rt_images, rt_force)
    }
    $("#ime_cli_path_test").click(imeTestPath); $("#regenerate-images").click(function () { $("#cli_path_progress").show(); $("#cli_path_progress").text("Báº¯t Ä‘áº§u cháº¡y"); $.post(ajaxurl, { action: "ime_regeneration_get_images", ime_nonce: $("#ime_nonce").val(), }, function (data) { $("#cli_path_progress").hide(); $("#cli_path_progress").text("Äang cháº¡y"); rt_images = data.split(","); rt_total = rt_images.length; if (rt_total > 0) { imeStartResize(rt_images, rt_total) } else { alert("KhÃ´ng tÃ¬m tháº¥y danh sÃ¡ch hÃ¬nh áº£nh") } }) }); $("#regenerate-origin-images").click(function () { $("#cli_path_progress").show(); $("#cli_path_progress").text("Báº¯t Ä‘áº§u cháº¡y"); $.post(ajaxurl, { action: "ime_regeneration_get_images", ime_nonce: $("#ime_nonce").val(), }, function (data) { $("#cli_path_progress").hide(); $("#cli_path_progress").text("Äang cháº¡y"); rt_images = data.split(","); rt_total = rt_images.length; if (rt_total > 0) { imeStartResizeOrigin(rt_images, rt_total) } else { alert("KhÃ´ng tÃ¬m tháº¥y danh sÃ¡ch hÃ¬nh áº£nh") } }) })
})
1