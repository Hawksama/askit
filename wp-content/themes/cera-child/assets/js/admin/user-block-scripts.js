jQuery(document).ready( function($) {
    $( '#publishing-action' ).on('click', function( e ) {
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
});