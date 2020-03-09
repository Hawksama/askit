'use strict';

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

(function($){
    $(function() {
        /**
         * Initiate Masonry grid for posts.
         */
        var $grid = $('.bp-card-list--category bp-card-list__item');

        $grid.on( 'layoutComplete', function() {
            setTimeout(function(){
                $grid.addClass('masonry--loaded');
            }, 1500);
        });

        $grid.masonry( {
            itemSelector: '.widget',
            percentPosition: true,
            columnWidth: '.grid-sizer',
            gutter: 20,
            stagger: 30,
            transitionDuration: '.4s'
        } );

        $grid.masonry('reloadItems').masonry('layout');
    });
})(jQuery);
