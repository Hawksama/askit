<?php
/**
 * The template for displaying the dashboard.
 *
 * Template Name: Dashboard Template
 *
 * @package cera
 */

get_header(); ?>

	<div id="primary">
		<main id="main" class="site-main">

			<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', 'page' );

				endwhile; // End of the loop.
			?>

			<div class="position-relative">

				<?php
				/**
				 * Functions hooked into cera_homepage action
				 *
				 * @hooked cera_grimlock_homepage - 10
				 */
				do_action( 'cera_homepage' ); ?>

				<div class="dashboard--fake">
					<div class="dashboard--fake__item"></div>
					<div class="dashboard--fake__item"></div>
					<div class="dashboard--fake__item"></div>
					<div class="dashboard--fake__item"></div>
					<div class="dashboard--fake__item"></div>
					<div class="dashboard--fake__item"></div>
					<div class="dashboard--fake__item"></div>
					<div class="dashboard--fake__item"></div>
					<div class="dashboard--fake__item"></div>
					<div class="dashboard--fake__item"></div>
					<div class="dashboard--fake__item"></div>
					<div class="dashboard--fake__item"></div>
				</div>

			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
