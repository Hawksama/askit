<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package cera
 */

get_header();?>

	<div id="primary" class="region__col region__col--2 content-area">
		<main id="main" class="site-main">

			<?php
 			global $wp_query;
            /* Start the Loop */

			$args = array(
				'p' => $wp_query->queried_object_id,
				'post_type' => 'ht_kb'
			);
			$posts = new WP_Query( $args );
			if ($posts->have_posts()):
				foreach ($posts->posts as $key => $item): ?>
					<?php
					$GLOBALS['post'] = $item;
					ht_kb_set_post_views($item->ID);
					
					get_template_part( 'template-parts/content', 'single-ht_kb' );

					do_action( 'cera_the_post_navigation' );
					
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				endforeach; // End of the loop.
			endif;
			wp_reset_postdata(); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar( 'right' );
get_footer();
