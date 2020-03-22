"use strict";

/*global
    jQuery
 */
/*eslint
    yoda: [2, "always"]
 */
/**
 * main.js
 *
 * Theme enhancements for a better user experience.
 */
!function($) {
    $(function() {
        /**
         * Initiate Masonry grid for posts.
         */
        var $grid = $(".bp-card-list--category bp-card-list__item");
        $grid.on("layoutComplete", function() {
            setTimeout(function() {
                $grid.addClass("masonry--loaded");
            }, 1500);
        }), $grid.masonry({
            itemSelector: ".widget",
            percentPosition: !0,
            columnWidth: ".grid-sizer",
            gutter: 20,
            stagger: 30,
            transitionDuration: ".4s"
        }), $grid.masonry("reloadItems").masonry("layout");
    }), 0 < $("#post-maker-container").length && ($("#draft_btn").detach().appendTo(".acf-form-submit").on("click", function() {
        $("#frontendPostStatus").val("2");
    }), $("input[type=submit]").on("click", function() {
        $(".acf-spinner").before(this);
    })), $(".acf-form-submit button").on("click", function(e) {
        var refactored = !1, blockPost = !1;
        return $(".acf-field-wysiwyg").each(function() {
            acfTxtArea = $(this).find(".acf-input").find("textarea");
            var textarea = acfTxtArea.val();
            if (0 < textarea.length) {
                var scriptExistIndex = textarea.indexOf("<script"), preTagExist = 0 <= textarea.indexOf("<pre");
                externalLink = textarea.indexOf("<link"), 0 <= scriptExistIndex && (preTagExist && !externalLink ? textarea.indexOf("<pre") < scriptExistIndex && textarea.indexOf("</pre") > scriptExistIndex && (textarea = (textarea = (textarea = textarea.replace("<script", "&lt;script")).replace("</script>", "&lt;/script&gt;")).replace("<link", "&lt;script"), 
                acfTxtArea.val(textarea), refactored = !0) : blockPost = !0);
            }
        }), refactored ? (alert("I found that you are trying to display js scripts on frontend. I've refactored your code, check it out."), 
        !1) : blockPost ? (alert("You cannot include external scripts or modify the page behaviour."), 
        !1) : void 0;
    });
}(jQuery);
//# sourceMappingURL=main.js.map