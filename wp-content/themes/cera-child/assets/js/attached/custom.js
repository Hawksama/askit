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

    $( '.acf-form-submit button' ).on('click', function( e ) {
        var refactored = false,
            blockPost = false;
        $('.acf-field-wysiwyg').each(function () {
            acfTxtArea = $(this).find('.acf-input').find('textarea');
            var textarea = acfTxtArea.val();

            if (textarea.length > 0) {
                var scriptExistIndex = textarea.indexOf('<script'),
                    preTagExist = textarea.indexOf('<pre') >= 0
                    externalLink = textarea.indexOf('<link');
                
                if(scriptExistIndex >= 0) {
                    if(preTagExist && !externalLink) {
                        if(textarea.indexOf('<pre') < scriptExistIndex && textarea.indexOf('</pre') > scriptExistIndex) {
                            textarea = textarea.replace('<script', '&lt;script');
                            textarea = textarea.replace('</script>', '&lt;/script&gt;');
                            textarea = textarea.replace('<link', '&lt;script');
                            acfTxtArea.val(textarea);
                            refactored = true;
                        }
                    } else {
                        blockPost = true;
                    }
                }
            }
        });

        if(refactored) {
            alert('I found that you are trying to display js scripts on frontend. I\'ve refactored your code, check it out.' );
            return false;

        } else if(blockPost) {
            alert( 'You cannot include external scripts or modify the page behaviour.' );
            return false;

        }
        
    } );

})(jQuery);
