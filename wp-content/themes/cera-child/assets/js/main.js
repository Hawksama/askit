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
    }));
}(jQuery);
//# sourceMappingURL=main.js.map