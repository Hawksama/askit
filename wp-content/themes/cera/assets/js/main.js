'use strict';

/**
 * File main.js
 *
 * Theme enhancements for a better user experience.
 */

jQuery( function( $ ) {

    /**
     * Remove brackets form WC attributes & categories lists
     */

    $( '.widget_layered_nav span.count, .widget_product_categories span.count, .grimlock-woocommerce-products-categories--layout_grid li.product.product-category .count' ).each( function() {
        var count = $( this ).html();
        count = count.substring( 1, count.length - 1 );
        $( this ).html( count );
    } );

    /**
     * Scroll to href anchor
     */

    var $navbar = $( '#navigation' );
    var $wpadminbar = $( '#wpadminbar' );
    var $body = $( 'body' );
    var additionalOffset = 20;

    if ( $navbar.length && ( $body.hasClass( 'grimlock--navigation-stick-to-top' ) || $body.hasClass( 'grimlock--navigation-unstick-to-top' ) ) ) {
        additionalOffset += $navbar.outerHeight();
    }

    if ( $wpadminbar.length ) {
        additionalOffset += $wpadminbar.outerHeight();
    }

    $( 'a[href*="#"]' ).not( '[href="#"]' ).not( '[href="#0"]' ).not( '[href*="#tab-"]' ).not( '[href*="tab"]' ).not( '[href*="link"]' ).not( '[role="tab"]' ).not( '#cancel-comment-reply-link' ).not( '[href*="#articleTOC"]' ).on( 'click', function( event ) {
        if ( location.pathname.replace( /^\//, '' ) === this.pathname.replace( /^\//, '' ) && location.hostname === this.hostname && location.search === this.search ) {
            var target = $( this.hash );
            target = target.length ? target : $( '[name=' + this.hash.slice( 1 ) + ']' );
            if ( target.length ) {
                event.preventDefault();
                $( 'html, body' ).animate( {
                    scrollTop: target.offset().top - additionalOffset
                }, 800 );
            }
        }
    } );


    /**
     * Prevent Bootstrap dropdown form closing on click
     */

    $( '.dropdown-wc-filters .dropdown-menu' ).on( 'click', function( event ) {
        event.stopPropagation();
    } );


    /**
     * Add/Remove class when WC Dropdown filter are shown/hidden
     */

    $( '#dropdown-wc-filters' ).on( 'show.bs.dropdown', function() {
        $( 'body' ).addClass( 'dropdown-wc-filters-open' );
    } );

    $( '#dropdown-wc-filters' ).on( 'hidden.bs.dropdown', function() {
        $( 'body' ).removeClass( 'dropdown-wc-filters-open' );
    } );


    /**
     * Bootstrap tooltip init
     */

    $( function() {
        $( '[data-toggle="tooltip"]' ).tooltip({
            trigger: 'hover',
            delay: { "show": 0, "hide": 0 },
        });
    } );


    /**
     * Prevent body to scroll when hamburger navigation is open
     */

    $( '#navigation-collapse' ).on( 'show.bs.collapse', function() {
        $( 'body' ).addClass( 'ov-h navbar-collapse-show' ).removeClass( 'navbar-collapse-hide' );
    } );

    $( '#navigation-collapse' ).on( 'hide.bs.collapse', function() {
        $( 'body' ).removeClass( 'ov-h navbar-collapse-show' ).addClass( 'navbar-collapse-hide' );
    } );


    /**
     * Opacity scroll effect for parallax hero background
     */

    var $itemHeader = $( '#hero' );
    var $coverImage = $( '.parallax-mirror img' );

    if ( $itemHeader.length && $coverImage.length ) {

        // Increase this value to decrease the effect and vice versa
        var headerOffsetBottom = $itemHeader.offset().top + $itemHeader.height();

        var scrollTop = $( window ).scrollTop();
        var opacity = scrollTop < headerOffsetBottom ? 1 - ( scrollTop / headerOffsetBottom * 2 ) : 0;

        $coverImage.css( 'opacity', opacity );

        $( window ).on( 'scroll', function() {
            scrollTop = $( window ).scrollTop();
            opacity = scrollTop < headerOffsetBottom ? 1 - ( scrollTop / headerOffsetBottom * 2 ) : 0;

            $coverImage.css( 'opacity', opacity );
        } );
    }

    var $slideOutWrapper = $( '.slideout-wrapper' );
    var $navBarToggler = $( '#navbar-toggler-mini' );

    if ( $slideOutWrapper.length && $navBarToggler.length ) {

        var openVerticalNav = function() {
            $body.removeClass( 'slideout-mini-hover' );
            $body.removeClass( 'slideout-mini' );
            $slideOutWrapper.removeClass( 'mini' );
            $navBarToggler.removeClass( 'collapsed' );
        };

        var closeVerticalNav = function() {
            $body.addClass( 'slideout-mini' );
            $slideOutWrapper.addClass( 'mini' );
            $navBarToggler.addClass( 'collapsed' );
            $( '.slideout-wrapper.mini .menu-item .sub-menu' ).removeClass('is-open');
        };

        var windowWidth = $( window ).width();
        var breakPointWidth = 1400;

        if ( windowWidth <= breakPointWidth ) {
            closeVerticalNav();
        }

        $( window ).on( 'resize', function() {
            var previousWindowWidth = windowWidth;
            windowWidth = $( window ).width();

            if ( previousWindowWidth > breakPointWidth && windowWidth <= breakPointWidth ) {
                closeVerticalNav();
            }
            else if ( previousWindowWidth <= breakPointWidth && windowWidth > breakPointWidth ) {
                openVerticalNav();
            }
        } );

        // Open / Close vertical navigation
        $navBarToggler.on( 'click', function() {
            if ( $body.hasClass( 'slideout-mini-hover' ) || $body.hasClass( 'slideout-mini' ) ) {
                openVerticalNav();
            }
            else if ( ! $slideOutWrapper.hasClass( 'mini' ) ) {
                closeVerticalNav();
            }

            // Reload masonry
            $( '.masonry' ).masonry('reloadItems').masonry('layout');
        } );

        // Open vertical navigation on mouse enter
        $body.on( 'mouseenter', '.slideout-wrapper.mini', function() {
            $body.addClass( 'slideout-mini-hover' ).removeClass( 'slideout-mini' );
        } );

        // Close vertical navigation when mouse leaves
        $body.on( 'mouseleave', '.slideout-wrapper.mini', function() {
            $body.removeClass( 'slideout-mini-hover' ).addClass( 'slideout-mini' );
            $( '.slideout-wrapper.mini .menu-item' ).removeClass('is-toggled');
            $( '.slideout-wrapper.mini .menu-item .sub-menu' ).removeClass('is-open');
        } );
    }

    /**
     * Recalculate masonry when dashboard content changes
     */

    // Select the node that will be observed for mutations
    var $dashboardWidgetsContainer = $( '.page-template-template-dashboard #main .widget-area' );

    if ( $dashboardWidgetsContainer.length ) {

        // Callback function to execute when mutations are observed
        var recalculateDashboardMasonry = function() {
            $( '.masonry' ).masonry('reloadItems').masonry('layout');
        };

        // Options for the observer (which mutations to observe)
        var config = {
            childList: true,
            subtree: true
        };

        // Create an observer instance linked to the callback function
        var observer = new MutationObserver( recalculateDashboardMasonry );

        // Start observing the target node for configured mutations
        observer.observe( $dashboardWidgetsContainer.get( 0 ), config );
    }

} );
