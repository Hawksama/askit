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

    if($('#post-maker-container').length > 0) {
        $("#draft_btn").detach().appendTo('.acf-form-submit').on('click', function () {
            $('#frontendPostStatus').val('2');
        });

        $('input[type=submit]').on('click', function() {
            $(".acf-spinner").before(this);
        });
    }

    $(document).ready(function(){
        $('.latest-news').slick({
            infinite: true,
            slidesToShow: 6,
            slidesToScroll: 6,
            dots: true,
            responsive: [{
                breakpoint: 1800,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 5,
                        infinite: true,
                        dots: true
                    }
                },{
                breakpoint: 1300,
                    settings: { 
                        slidesToShow: 4,
                        slidesToScroll: 4
                    }
                },{
                breakpoint: 480,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },{
                breakpoint: 380,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                }
            }] 
        });

        $('html').css('display','block');
    });

})(jQuery);
