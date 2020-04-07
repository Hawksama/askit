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
			<?php do_action( 'cera_footer' ); ?>
			<!-- </div> -->
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

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-55371530-1"></script>
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function(event) { 
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-55371530-1');
	});
</script>

</body>
</html>
