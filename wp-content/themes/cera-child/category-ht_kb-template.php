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
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div id="bbpress-forums">
								<?php bbp_breadcrumb(); ?>
								
								<?php bbp_get_template_part( 'ht-knowledge', 'search' ); ?>

								<ul class="bbp-forums b ht-posts-list">
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
                            
                                    foreach ($sub_categories as $sub_category) { ?>
                                        
                                        <h2 class="ht-kb-sub-cat-title">
                                            <a href="<?php echo esc_attr(get_term_link($sub_category, 'ht_kb_category')); ?>" title="<?php printf( __( 'View all posts in %s', 'ht-knowledge-base' ), $sub_category->name ); ?>"><?php echo $sub_category->name; ?></a>
                                            <span class="ht-kb-category-count"><?php echo $sub_category->count . _x(' Articles', 'ht-knowledge-base'); ?></span>
                                        </h2>
                            
                                    <?php } ?>

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


<?php
get_footer();