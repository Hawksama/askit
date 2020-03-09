<?php
/*
Template Name:Homepage Template: Posts
*/

get_header();?>

	<div id="primary" class="content-area region__col region__col--2">
		
		<header class="grimlock--page-header entry-header clearfix">
			<?php do_action( 'cera_breadcrumb' ); ?>
			<h1 clasrs="page-title entry-title">
				<?php single_post_title(); ?>
			</h1>
		</header>

		<div class="site-content region region--9-3-cols-left region--container-fluid">
			<div class="region__container">
				<div class="region__row">
					<main id="main" class="site-main region__col region__col--2">
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div id="bbpress-forums">
								<?php bbp_breadcrumb(); ?>
								
								<?php bbp_get_template_part( 'ht-knowledge', 'search' ); ?>

								<ul class="bbp-forums ht-posts-list">
									<li class="dashboard--fake">
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
									</li>
								</ul>

							</div>
						</article>

						<?php dynamic_sidebar( 'homepage-1' ); ?>
					</main><!-- #main -->
					
					<?php get_sidebar( 'right' ); ?>
				</div>
			</div>
		</div>
		
	</div><!-- #primary -->

	<script>
		$.get(ajaxurl,{'action': 'archive_category'}, 
			function (data) { 
				$('.bbp-forums.ht-posts-list').prepend(data).addClass('ajax--loaded');
			}
		);
	</script>


<?php
get_footer();