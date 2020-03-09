<?php
/*
Template Name: Category HT KB
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
						<article id="category-listing" <?php post_class(); ?>>
							<ul class="bp-card-list bp-card-list--category loading-list" aria-live="assertive" aria-relevant="all">
								
								<?php 
								$args = array(
									'orderby'       =>  'term_order',
									'depth'         =>  1,
									'child_of'      => 	$term->term_id,
									'hide_empty'    =>  0,
									'pad_counts'   	=>	true
								); 
								$sub_categories = get_terms('ht_kb_category', $args);
								$sub_categories = wp_list_filter($sub_categories,array('parent'=>$term->term_id));
						
								foreach ($sub_categories as $category) { ?>
									<li class="bp-card-list__item has-post-thumbnail element-animated fade-in short element-animated-delay element-animated-both odd is-online">
										<div class="card">
											<div class="ov-h">
												<div class="card-img">
													<a href="<?php echo esc_attr(get_term_link($category, 'ht_kb_category')) ?>" title="<?php echo sprintf( __( 'View all posts in %s', 'ht-knowledge-base' ), $category->name ) ?>"">
														<?php	
														$term_meta = get_option( "taxonomy_$t_id" );
														$default_preview = plugins_url( 'img/no-image.png', dirname(__FILE__) );

														//get the attachment thumb array
														$attachment_thumb = ( isset ( $term_meta['meta_image'] ) ) ? wp_get_attachment_image_src( $term_meta['meta_image'], 'thumbnail' ) : null ;
														
														$thumbnail_url = ( !empty($attachment_thumb) ) ? $attachment_thumb[0] : $default_preview;
														?>
															
														<?php if(!empty($attachment_thumb)) : ?>
															<div class="bg-secondary p-3 rounded-full d-flex justify-content-center align-items-center">
																<img class="img-fluid" src="<?= $thumbnail_url ?>">
															</div>
														<?php else: ?>
															<div class="bg-secondary p-3 rounded-full d-flex justify-content-center align-items-center">
																<i class="cera-icon cera-message-circle fa-2x text-primary"></i>
															</div>
														<?php endif; ?>
													</a>
												</div> <!-- .card-img -->

												<div class="card-body">

													<header class="card-body-header entry-header clearfix">
														<h2 class="entry-title item-title">
															<a class="bbp-forum-title" 
																href="<?php echo esc_attr(get_term_link($category, 'ht_kb_category')) ?>" 
																title="<?php echo sprintf( __( 'View all posts in %s', 'ht-knowledge-base' ), $category->name ) ?>"><?php echo $category->name; ?></a>
														</h2>
													</header>

													<?php
													$ht_kb_tax_desc =  $category->description;
													if( !empty($ht_kb_tax_desc) ): ?>
														<div class="card-body-meta">
															<p class="ht-kb-category-desc"><?php echo $ht_kb_tax_desc ?></p>
														</div> <!-- .card-body-meta -->
													<?php endif; ?>
												</div> <!-- .card-body -->

												<div class="card-footer card-footer--limited">
													<span class="ht-kb-category-count"><?php echo $category->count . _x(' Articles', 'ht-knowledge-base'); ?></span>
												</div> <!-- .card-footer -->
											</div> <!-- .ovh -->
										</div> <!-- .card -->
									</li> <!-- .bp-card-list__item -->
								<?php } ?>

							</ul>
						</article>

						<?php dynamic_sidebar( 'homepage-1' ); ?>
					</main><!-- #main -->
					
					<?php get_sidebar( 'right' ); ?>
				</div>
			</div>
		</div>
		
	</div><!-- #primary -->


<?php
get_footer();