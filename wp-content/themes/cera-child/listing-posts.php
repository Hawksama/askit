<?php
/*
Template Name:Homepage Template: Posts
*/

get_header();?>

	<div id="primary" class="content-area region__col region__col--2">
		
		<div id="custom_header"
			class="grimlock-custom_header region grimlock-region grimlock-region--pt-4 grimlock-region--pb-4 region--6-6-cols-left-reverse region--container-fluid grimlock-section section "
			style="background-image:url(<?= wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>);background-repeat:no-repeat;background-position:center;background-size:cover;-webkit-background-size:cover;background-attachment:scroll;border-top-color:#eceeef;border-top-style:solid;border-top-width:0;border-bottom-color:#eceeef;border-bottom-style:solid;border-bottom-width:0;">
			<div class="region__inner"
				style="padding-top:4%;padding-bottom:4%;background-color:rgba(37,37,56,0.75);">
				<div class="region__container">
					<div class="region__row">
						<div class="region__col region__col--1">
							<div class="grimlock-reveal-element grimlock-reveal-element--thumbnail">
							</div>
						</div><!-- .region__col -->
						<div class="region__col region__col--2">
							<div class="grimlock-reveal-element grimlock-reveal-element--content">
								<div class="section__header">
									<?php the_content(); ?>
									<?php do_action( 'cera_breadcrumb' ); ?>
								</div><!-- .section__header -->
							</div>
						</div><!-- .region__col -->
					</div><!-- .region__row -->
				</div><!-- .region__container -->
			</div><!-- .region__inner -->
		</div><!-- .grimlock-section -->

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
					</main><!-- #main -->
					
					<div id="secondary-right" class="widget-area sidebar region__col region__col--3 aside-fake">
						<div class="aside--fake__item widget buddypress widget">
							<h2 class="widget-title title-fake">
								<span>placeholder</span>
							</h2>

							<ul class="contents-fake">
								<li></li>
							</ul>
						</div>

						<div class="aside--fake__item widget buddypress widget">
							<h2 class="widget-title title-fake">
								<span>placeholder</span>
							</h2>

							<ul class="contents-fake">
								<li></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>

						
						<div class="aside--fake__item widget buddypress widget">
							<h2 class="widget-title title-fake">
								<span>placeholder</span>
							</h2>

							<ul class="contents-fake">
								<li></li>
								<li></li>
							</ul>
						</div>
					</div>
				</div>
				
				<div id="homepage_1"></div>
				<?php //dynamic_sidebar( 'homepage-1' ); ?>
			</div>
		</div>
		
	</div><!-- #primary -->

	<script>
	$(window).load(function(){
		if(true){
			$.get(ajaxurl,{'action': 'archive_category'}, 
				function (data) { 
					$('.bbp-forums.ht-posts-list').prepend(data).addClass('ajax--loaded');
				}
			);

			$.get(ajaxurl,{'action': 'sidebar_right'}, 
				function (data) { 
					$('#secondary-right').remove();
					$('.site-main').after(data);
				}
			);

			$.get(ajaxurl,{'action': 'homepage_1'}, 
				function (data) { 
					$('#homepage_1').after(data);
					$('#homepage_1').remove();
				}
			);
		}
	});
	</script>


<?php
get_footer();