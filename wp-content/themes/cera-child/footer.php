<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package cera
 */

?>
			</div>
		</div><!-- #site -->
		
	</div><!-- #site-wrapper -->

	<?php
	/**
	 * Functions hooked into cera_footer action
	 *
	 * @hooked cera_footer                 - 10
	 * @hooked cera_grimlock_after_content - 10
	 * @hooked cera_grimlock_footer        - 20
	 */
	do_action( 'cera_footer' );
	?>
	<!-- <div id="cera_footer_function"></div> -->
		
	<!-- <div id="cera_after_site_function"></div> -->
	<?php do_action( 'cera_after_site' ); ?>

<?php wp_footer(); ?>

<div class="call-us-button-wrapper">
	<a class="call-us-button" href="tel:+4<?= get_option('phone_number'); ?>">
		<div class="call-us-button-label"><?= get_option('phone_number_label'); ?></div><i class="fa fa-phone"></i>
	</a>
</div>

<script>
	$(window).load(function(){
		// $.get(ajaxurl,{'action': 'cera_footer'}, 
		// 	function (data) { 
		// 		$('#cera_footer_function').after(data);
		// 		$('#cera_footer_function').remove();
		// 	}
		// );

		// $.get(ajaxurl,{'action': 'cera_after_site'}, 
		// 	function (data) { 
		// 		$('#cera_after_site_function').after(data);
		// 		$('#cera_after_site_function').remove();
		// 	}
		// );

		// $.get(ajaxurl,{'action': 'cera_header'}, 
		// 	function (data) { 
		// 		$('#cera_header_function').after(data);
		// 		$('#cera_header_function').remove();
		// 	}
		// );
	});
</script>

</body>
</html>
