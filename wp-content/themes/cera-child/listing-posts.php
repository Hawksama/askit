<?php
/*
Template Name:Homepage Template: Posts
*/

get_header();?>

	<div id="primary" class="content-area region__col region__col--2">
		<main id="main" class="site-main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="grimlock--page-header entry-header clearfix">
					<?php do_action( 'cera_breadcrumb' ); ?>
					<h1 clasrs="page-title entry-title">
						<?php single_post_title(); ?>
					</h1>
				</header>

				<div id="bbpress-forums">
					<?php bbp_breadcrumb(); ?>
					
					<?php bbp_get_template_part( 'ht-knowledge', 'search' ); ?>

					<ul class="bbp-forums b ht-posts-list">
						<?php if(function_exists('ht_kb_display_archive')): ?>
							<?php ht_kb_display_archive(); ?>
						<?php endif; ?>

						<?php if(function_exists('ht_kb_display_uncategorized_articles')): ?>
							<?php ht_kb_display_uncategorized_articles(); ?>
						<?php endif; ?>
					</ul>
				</div>
			</article>

			<?php dynamic_sidebar( 'homepage-1' ); ?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar( 'right' ); ?>

<?php
get_footer();