<?php
/*
Template Name:Homepage Template: Posts
*/

get_header();
get_sidebar( 'left' ); ?>

	<div id="primary" class="content-area region__col region__col--2">
		<main id="main" class="site-main">
		
		<div id="bbpress-forums">
			<?php bbp_breadcrumb(); ?>

			<?php 
			
			$args = array(
				'post_type' => 'ht_kb',
				'orderby' => 'date',
				'order' => 'DESC',
				'posts_per_page' => 10,
			);
			
			$loop = new WP_Query($args); ?>

			<div class="bbp-search-form d-none">

				<?php bbp_get_template_part( 'form', 'search' ); ?>

			</div>

			<?php
			if ( bbp_is_topic_tag() ) :
				bbp_topic_tag_description();
			endif; ?>

			<?php do_action( 'bbp_template_before_topics_index' ); ?>

			<?php if ( $loop->have_posts() ) : ?>

				<?php bbp_get_template_part( 'loop',       'posts'    ); ?>

				<?php bbp_get_template_part( 'pagination', 'posts'    ); ?>

			<?php else : ?>

				<?php bbp_get_template_part( 'feedback',   'no-topics' ); ?>

			<?php endif; ?>

			<?php do_action( 'bbp_template_after_topics_index' ); ?>

		</div>

			<?php

			/* Start the Loop */
			while ( $loop->have_posts() ) : $loop->the_post();

				do_action( 'bbp_template_before_forums_loop' ); ?>

				<ul id="forums-list-<?php bbp_forum_id(); ?>" class="bbp-forums">
				
					<li class="bbp-body">
				
						<?php while ( bbp_forums() ) : bbp_the_forum(); ?>
				
							<?php bbp_get_template_part( 'loop', 'single-forum' ); ?>
				
						<?php endwhile; ?>
				
					</li><!-- .bbp-body -->
				
					<li class="bbp-footer">
				
						<div class="tr">
							<p class="td colspan4">&nbsp;</p>
						</div><!-- .tr -->
				
					</li><!-- .bbp-footer -->
				
				</ul><!-- .forums-directory -->
				
				<?php do_action( 'bbp_template_after_forums_loop' );

			endwhile; wp_reset_query(); // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar( 'right' );
get_footer();