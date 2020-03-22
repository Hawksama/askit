<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class Grimlock_Vertical_Navigation_Component
 *
 * @author  themosaurus
 * @since   1.0.0
 * @package grimlock/inc/components
 */
class Grimlock_Vertical_Navigation_Component extends Grimlock_Component {
	/**
	 * Render the current component with props data on page.
	 *
	 * @since 1.0.0
	 */
	public function render() {
		if ( $this->is_displayed() ) {
			if ( isset( $this->props['layout'] ) ) {
				switch ( $this->props['layout'] ) {
					case 'fixed-left' :
					case 'fixed-right' :
					case 'hamburger-right' :
					case 'hamburger-left' : ?>
						<script>
							// $(document).ready(function(){
								if(true){
									$.get(ajaxurl,{
										'action': 'grimlock_vertical_navbar',
										'props': <?= json_encode($this->props) ?>
									}, 
										function (data) { 
											$('#slideout-wrapper').append(data).addClass('menu-ajax-loaded').trigger('classAdded');
										}
									);
								}
							// });
						</script>

						<div id="slideout-backdrop" class="slideout-backdrop slideout-close"></div>

						<div id="slideout-wrapper" class="slideout-wrapper">
						</div><!-- .slideout-wrapper -->
						<?php
						break;
				}
			}
		}
	}
}
