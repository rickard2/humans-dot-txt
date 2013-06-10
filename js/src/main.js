/**
 * Function for taking care of suggestions sent back to the author
 */
(function ($) {

    var hs = $("#humans_suggest"),
        hm = $("#humans_modal"),
        hsb = $("#humans_suggestion_button"),
        hsc = $("#humans_suggestion_close"),
        hst = $("#humans_suggestion_text"),
        hsl = $("#humans_suggestion_loading"),
        hsf = $("#humans_suggestion_form"),
        hsd = $("#humans_suggestion_done"),
        hsv = $("#humans_suggestion_version");

    hs.click(function () {
        // show modal window and set the width to centered
        var w = $(window).width();
        hm.css('left', (w / 2) - 250);
        hm.show();
    });
    hsc.click(function () {
        // hide parent, done message and loading image
        // show the form and reset input elements
        hm.hide();
        hsl.hide();
        hsf.show();
        hsd.hide();
        hst.val('');
        hsv.attr('checked', '');
    });

    hsb.click(function () {

        // Show WP loading icon and disable input elements
        hsl.show();
        $("#humans_suggestion_form input, #humans_suggestion_form textarea").attr('disabled', 'disabled');

        // Do ajax request. On success the form is hidden and a nice message is displayed to the user
        // @todo: Proper error handling
        $.ajax({
            url: 'http://wp.0x539.se/humans-dot-txt/suggestion.php',
            type: 'POST',
            data: {
                text: hst.val(),
                version: $("#humans_suggestion_version:checked").val()
            },
            success: function () {
                hsf.hide();
                hsd.show();
            }, error: function () {
                hsf.hide();
                hsd.show();
            }
        });
    });
}(jQuery));


/**
 * Function taking care of displaying and hiding the plugins and authors fieldsets when neccessary
 * Also initiates the autoGrow plugin
 */
(function ($) {
    var ta = $("#humans_template"),
        pl = $("#h_plugins"),
        au = $("#h_authors"),
        pl_hidden = false,
        au_hidden = false;

    // Check if %ACTIVE_PLUGINS% tempalte tag is used and show the sub-template settings
    if (!ta.val().match(/%ACTIVE_PLUGINS%/)) {
        pl.hide();
        pl_hidden = true;
    }

    // Same but for %AUTHORS%
    if (!ta.val().match(/%AUTHORS%/)) {
        au.hide();
        au_hidden = true;
    }

    // Do the same checks when the user types in the textarea field
    ta.keyup(function () {
        if (pl_hidden === false && !ta.val().match(/%ACTIVE_PLUGINS%/)) {
            pl.hide('fast');
            pl_hidden = true;
        } else if (pl_hidden === true && ta.val().match(/%ACTIVE_PLUGINS%/)) {
            pl.show('fast');
            pl_hidden = false;
        }

        if (au_hidden === false && !ta.val().match(/%AUTHORS%/)) {
            au.hide('fast');
            au_hidden = true;
        } else if (au_hidden === true && ta.val().match(/%AUTHORS%/)) {
            au.show('fast');
            au_hidden = false;
        }
    });

    // Allow the textarea to grow when the user types
    ta.autoGrow();
}(jQuery));