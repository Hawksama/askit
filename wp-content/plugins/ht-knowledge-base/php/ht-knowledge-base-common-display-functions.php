<?php



/*

* Pluggable common functions for the ht knowledge base

*/



if(!function_exists('ht_kb_breadcrumb_display')){

	/**

	 * Breadcrumbs display

	 * @pluggable

	 */

	function ht_kb_breadcrumb_display( $sep = '<span class="sep">/</span>' ) {

		//global WordPress variable $post. Needed to display multi-page navigations.

	    global $post, $cat; 



	    $homelink = '<a href="' . home_url() . '" class="ht-breadcrumbs-home">' . __('Home') . '</a> ' . $sep;    



		if (!is_front_page()) {  

			echo '<div class="ht-breadcrumbs ht-kb-breadcrumbs" >';



			$taxonomy = ht_kb_get_taxonomy();

			$term_string = ht_kb_get_term();

			$visited = array();

						

			if (!empty($taxonomy) && !empty($term_string)) {

				//category terms bread crumb

				echo $homelink;



				// echo '<a href="' . get_post_type_archive_link( 'ht_kb' ) . '">' . __('Knowledge Base', 'ht-knowledge-base') . '</a> ' . $sep; 



				$term = get_term_by( 'slug', $term_string, $taxonomy );

				

				if($term==false)

					return;



				if ($term->parent != 0) { 

					$parents =  get_custom_category_parents($term->term_id, 'ht_kb_category', true,'' .$sep . '', false, $visited );

					//remove last separator from parents

					$parents = substr($parents, 0, strlen($parents )- strlen($sep) );



					echo $parents;

				} else {

					echo '<a href="' . esc_attr(get_term_link($term, 'ht_kb_category')) . '" title="' . sprintf( __( "View all posts in %s" ), $term->name ) . '" ' . '>' . $term->name.'</a> ';

					$visited[] = $term->term_id;

				}

				



			} elseif ( !is_single() && 'ht_kb' == get_post_type() ) {

				//Archive		

				$ht_kb_data = get_post_type_object('ht_kb');

				echo $ht_kb_data->labels->name;	 



			} elseif ( is_single() && 'ht_kb' == get_post_type() ) {

				//Single post

				$terms = wp_get_post_terms( $post->ID , 'ht_kb_category');





				if( !empty($terms) ){

					foreach($terms as $term) {

						echo $homelink;



						// echo '<a href="' . get_post_type_archive_link( 'ht_kb' ) . '">' . __('Knowledge Base', 'ht-knowledge-base') . '</a> ' . $sep; 

						

						if ($term->parent != 0) { 

							$parents =  get_custom_category_parents($term->term_id, 'ht_kb_category', true,'' .$sep . '', false, $visited );

							echo $parents;

						} else {

							echo '<a href="' . esc_attr(get_term_link($term, 'ht_kb_category')) . '" title="' . sprintf( __( "View all posts in %s" ), $term->name ) . '" ' . '>' . $term->name.'</a> ';

							echo $sep;

							$visited[] = $term->term_id;

						}

						echo get_the_title();

						echo '<br/>';



					} // End foreach

				} else {

					//uncategorized article

					// echo '<a href="' . get_post_type_archive_link( 'ht_kb' ) . '">' . __('Knowledge Base', 'ht-knowledge-base') . '</a> ' . $sep; 

					echo get_the_title();

					echo '<br/>';

				}		

				

			} else {

					//Display the post title.

					echo get_the_title();

					echo '<br/>';

			}

					

			echo '</div>';	

		} //is_front_page

	} //end function

} //end function exists





if(!function_exists('get_term_parents')){

	/**

	 * Get the term parents

	 * @pluggable

	 */

	function get_term_parents( $id, $taxonomy, $link = false, $separator = '/', $nicename = false, $visited = array() ) {

	  $chain = '';

	  $parent = &get_term( $id, $taxonomy );

	  if ( is_wp_error( $parent ) )

	    return $parent;

	  if ( $nicename )

	    $name = $parent->slug;

	  else

	    $name = $parent->name;

	  if ( $parent->parent && ( $parent->parent != $parent->term_id ) && !in_array( $parent->parent, $visited ) ) {

	    $visited[] = $parent->parent;

	    $chain .= get_term_parents( $parent->parent, $taxonomy, $link, $separator, $nicename, $visited );

	  }

	  if ( $link )

	    $chain .= '<a href="' . esc_url( get_term_link( intval( $parent->term_id ), $taxonomy ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $parent->name ) ) . '">'.$name.'</a>' . $separator;

	  else

	    $chain .= $name.$separator;

	  return $chain;

	}//end function

}//end function_exists





if(!function_exists('get_custom_category_parents')){

	/**

	 * Get the category parents

	 * @pluggable

	 */

	function get_custom_category_parents( $id, $taxonomy = false, $link = false, $separator = '/', $nicename = false, $visited = array() ) {



		if(!($taxonomy && is_taxonomy_hierarchical( $taxonomy )))

			return '';



		$chain = '';

		// $parent = get_category( $id );

		$parent = get_term( $id, $taxonomy);

		if ( is_wp_error( $parent ) )

			return $parent;



		if ( $nicename )

			$name = $parent->slug;

		else

			$name = $parent->name;



		//reset visited if null

		if(empty($visited))

			$visited = array( );



		if ( $parent->parent && 

			( $parent->parent != $parent->term_id ) && 

			(!in_array( $parent->parent, $visited ) ) ) {

			$visited[] = $parent->parent;

			// $chain .= get_category_parents( $parent->parent, $link, $separator, $nicename, $visited );

			$chain .= get_custom_category_parents( $parent->parent, $taxonomy, $link, $separator, $nicename, $visited );

		}



		if ( $link ) {

			// $chain .= '<a href="' . esc_url( get_category_link( $parent->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $parent->name ) ) . '">'.$name.'</a>' . $separator;

			$chain .= '<a href="' . esc_url( get_term_link( (int) $parent->term_id, $taxonomy ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $parent->name ) ) . '">'.$name.'</a>' . $separator;

		} else {

			$chain .= $name.$separator;

		}



		return $chain;

	}

}





if(!function_exists('ht_kb_related_articles')){

    /**

    * Display related articles

    * @pluggable

    */

    function ht_kb_related_articles(){

        global $post, $ht_knowledge_base_options;

        $orig_post = $post;

        $categories = get_the_terms($post->ID, 'ht_kb_category');



        if ($categories) {  

            $category_ids = array();

            foreach($categories as $individual_category) 

                $category_ids[] = $individual_category->term_id;



            $args=array(

	            'post_type' => 'ht_kb',

	            'tax_query' => array(

	                array(

	                    'taxonomy' => 'ht_kb_category',

	                    'field' => 'term_id',

	                    'terms' => $category_ids

	                )

	            ),

	            'post__not_in' => array($post->ID),

	            'posts_per_page'=> 6, // Number of related posts that will be shown.

	            'ignore_sticky_posts'=>1

            );



            $related_articles_query = new wp_query( $args );

            

            if( $related_articles_query->have_posts() ) { ?>

             

             <section id="ht-kb-related-articles" class="clearfix">

             <h3 id="ht-kb-related-articles-title">
<!--              Askit
 -->             <?php echo "Solutii Asemanatoare"; // _e('Related Articles', 'ht-knowledge-base'); ?></h3>
<!-- end Askit
 -->                <ul class="ht-kb-article-list"><?php



	            while( $related_articles_query->have_posts() ) {

	                $related_articles_query->the_post();

	            

				  	//set post format class  

	                if ( has_post_format( 'video' )) { 

	                  $ht_kb_format_class = 'format-video';

	                } else {

	                  $ht_kb_format_class = 'format-standard';

	                }



	               ?>

	                

	                <li class="<?php echo $ht_kb_format_class; ?>">

	                	<a href="<?php the_permalink()?>" rel="bookmark" title="<?php echo esc_attr( sprintf( the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_title(); ?></a>

	                	<?php if ( $ht_knowledge_base_options['related-rating'] && function_exists('ht_usefulness') ) {      

					        $article_usefulness = ht_usefulness( get_the_ID() );

					        $helpful_article = ( $article_usefulness >= 0 ) ? true : false;

					        $helpful_article_class = ( $helpful_article ) ? 'ht-kb-helpful-article' : 'ht-kb-unhelpful-article';

					      ?>

					        <span class="ht-kb-usefulness <?php echo $helpful_article_class; ?>"><?php echo $article_usefulness  ?></span>

					      <?php 



					  	  } //rating ?>

	                </li>



	        	<?php } ?>

        		</ul>

    		</section>

        <?php    } //end $related_articles_query

         } //end if  categories

        $post = $orig_post;

        wp_reset_postdata();

    }

}





if(!function_exists('ht_kb_entry_meta_display')){

	/**

	* Display entry meta

	* @pluggable

	*/

	function ht_kb_entry_meta_display(){

			global $post; ?>



			<ul class="ht-kb-entry-meta clearfix">



				<li class="ht-kb-em-date"> 

				    <span><?php _e( 'Data' , 'ht-knowledge-base' ) ?></span>

				    <a href="<?php the_permalink(); ?>" rel="bookmark" itemprop="url"><time datetime="<?php the_time('Y-m-d')?>" itemprop="datePublished"><?php the_time( get_option('date_format') ); ?></time></a>

				</li>

				<li class="ht-kb-em-author">

					<span><?php _e( 'Autor' , 'ht-knowledge-base' ) ?></span>

					<a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>" rel="me" itemprop="author"><?php echo esc_attr( get_the_author() ); ?></a>

				</li>


				<?php if( !is_tax() ) : ?>

					<li class="ht-kb-em-category">

					    <span><?php _e( 'Categorie' , 'ht-knowledge-base' ) ?></span>

					    <?php 

						    $terms = get_the_term_list( $post->ID, 'ht_kb_category', ' ', ', ', '' );

						    if(empty($terms)){

						    	_e('Diverse', 'ht-knowledge-base');

						    } else {

						    	echo $terms;

						    }

					    ?>

					</li>

				<?php endif; //is tax ?>

				
				 <!-- Vlad adaugat numar like-uri si view-uri -->

		        <?php 

		         $info_solutie =get_post_meta(get_the_ID()); 
		         $views = $info_solutie["_ht_kb_post_views_count"][0];
		         $usefulness = ht_usefulness( get_the_ID() );
		        ?>

		        <li><span class="ht-kb-usefulness ht-kb-helpful-article author-use"><?php echo $usefulness; ?></span></li>
		        <li><span class="view-s-icon ht-kb-helpful-article author-use"><?php echo $views; ?></span></li>

 			   <!-- end Vlad -->

				<?php if ( comments_open() && get_comments_number() > 0 ){ ?>

					<li class="ht-kb-em-comments">

					    <span><?php _e( 'Comments' , 'ht-knowledge-base' ) ?></span>

						<?php comments_popup_link( __( '0', 'ht-knowledge-base' ), __( '1', 'ht-knowledge-base' ), __( '%', 'ht-knowledge-base' ) ); ?>

					</li>

				<?php } ?>



			</ul>



		<?php

	} //end function

}//end function exists





if(!function_exists('ht_kb_display_attachments')){

	/**

	* Display article attachments

	* @pluggable

	*/

	function ht_kb_display_attachments(){

			global $post;

			$attachments = get_post_meta($post->ID, 'ht_knowledge_base_file_advanced', true);

			if( ! empty( $attachments ) ): ?>



			<section id="ht-kb-attachments">

				<h3 class="ht-kb-attachments"><?php _e('Article Attachments', 'ht-knowledge-base'); ?></h3>

				<ul>

					<?php

						foreach ($attachments as $id => $attachment) {



							$attachment_post  = get_post($id);

							$default_attachment_name = __('Attachment', 'ht-knowledge-base');

							$attachment_name = !empty($attachment_post) ? $attachment_post->post_name : $default_attachment_name;

							?>

							<li class="ht-kb-attachment-item">

								<a href="<?php echo wp_get_attachment_url($id); ?>"><?php echo $attachment_name; ?></a>

							</li>

							

							<?php



						}

					?>

				</ul>



			</section><!-- article-attachments -->



		<?php

			endif; //end test for 

	} //end function

}//end function exists





if(!function_exists('ht_kb_display_tags')){

	/**

	* Display article tags

	* @pluggable

	*/

	function ht_kb_display_tags(){

		global $post; ?>

		<div class="tags">

			<?php echo get_the_term_list( $post->ID, 'ht_kb_tag', __('Etichetare: ', 'ht-knowledge-base'), '', '' );?>

		</div>

		<?php

	} //end function

}//end function exists





if(!function_exists('ht_kb_display_search')){

	/**

	* Display article search

	* @pluggable

	*/

	function ht_kb_display_search(){

		global $post, $ht_knowledge_base_options; 

		$placeholder_text = 	(isset($ht_knowledge_base_options) && is_array($ht_knowledge_base_options) && array_key_exists('search-placeholder-text', $ht_knowledge_base_options)) ? 

								$ht_knowledge_base_options['search-placeholder-text'] : 

								__('Search the Knowledge Base', 'ht-knowledge-base');



		?>

		<div class="ht-kb-article-search">

			<form role="search" method="get" id="searchform" class="searchform" action="<?php echo home_url( '/' ); ?>">
				<label class="screen-reader-text" for="s">Search for:</label>

				<input type="text" value="" placeholder="<?php echo $placeholder_text; ?>" name="s" id="s" autocomplete="off" />

				<input type="hidden" name="ht-kb-search" value="1" />

				<button type="submit" id="searchsubmit" class="searchcustom"> <i class="fa fa-search"></i></button>

		</form>

		</div>

		<?php

	} //end function

}//end function exists





if(!function_exists('ht_kb_display_sub_cats')){

	/**

	* Display sub categories

	* @pluggable

	*/

	function ht_kb_display_sub_cats($master_tax_terms, $parent_term_id, $depth, $display_sub_cat_count, $display_sub_cat_articles, $numberposts){

		//return if max depth reached

		if($depth==0){

			return;

		}



		//populate child tax terms

		$child_tax_terms = wp_list_filter($master_tax_terms,array('parent'=>$parent_term_id));

		if(count($child_tax_terms)>0){

			?>

			<ul class="ht-kb-sub-cats">
			
			<?php

			foreach ($child_tax_terms as $term) {

				?>

				<li class="ht-kb-sub-cat">

					

					<a href="<?php echo esc_attr(get_term_link($term, 'ht_kb_category')); ?>" title="<?php echo sprintf( __( 'View all posts in %s', 'ht-knowledge-base' ), $term->name ); ?>" ><?php echo $term->name; ?></a>

					<?php if($display_sub_cat_count): ?>

						<span class="ht-kb-category-count"><?php echo $term->count; ?> <?php _e(' Solutii', 'ht-knowledge-base'); ?></span>

					<?php endif; ?>

					<?php

					//recursive

					ht_kb_display_sub_cats($master_tax_terms, $term->term_id, $depth--, $display_sub_cat_count, $display_sub_cat_articles, $numberposts);



					//continue if $display_sub_cat_articles == false

					if(!$display_sub_cat_articles){

						continue;

					}



					//else show all the articles in this category



					//get posts per category

					$args = array( 

						'post_type'  => 'ht_kb',

						'posts_per_page' => $numberposts,

						'orderby' => 'date',

						'tax_query' => array(

							array(

								'taxonomy' => 'ht_kb_category',

								'field' => 'term_id',

								'include_children' => false,

								'terms' => $term->term_id

							)

						)

					);

					$sub_cat_posts = get_posts( $args );

					

					?>



					<ul class="ht-kb-article-list">



						<?php

						foreach( $sub_cat_posts as $post ) : ?>

									<?php

										  	//set post format class  

							                if ( get_post_format( $post->ID )=='video') { 

							                  $ht_kb_format_class = 'format-video';

							                } else {

							                  $ht_kb_format_class = 'format-standard';

							                }

						            ?>

									<li class="<?php echo $ht_kb_format_class; ?>"><a href="<?php echo get_permalink($post->ID); ?>" rel="bookmark"><?php echo get_the_title($post->ID); ?></a></li>

						    

						<?php endforeach; ?>

					</ul><!-- End Get posts per Category -->

				</li> <!--  /.ht-kb-sub-cat -->



				<?php



			}

			?>

			</ul><!--/sub-cats-->

			<?php

		}

	}//end function

}//end function exists







if(!function_exists('get_ht_kb_term_meta')){

	/**

	* Get term meta

	* @pluggable

	* @return (Array) The term meta

	*/

	function get_ht_kb_term_meta($term){

			//// put the term ID into a variable

			$t_id = $term->term_id;

		 

			// retrieve the existing value(s) for this meta field. This returns an array

			$term_meta = get_option( "taxonomy_$t_id" );



			return $term_meta;

	}//end function

}//end function exists





if(!function_exists('get_ht_kb_tags')){

	/**

	* Get all knowledgebase tags

	* @pluggable

	* @return (Array) The ht_kb_tag taxonomy terms

	*/

	function get_ht_kb_tags(){

		$taxonomies = array('ht_kb_tag');



		$args = array(

		    'orderby'       => 'name', 

		    'order'         => 'ASC',

		    'hide_empty'    => true, 

		    'exclude'       => array(), 

		    'exclude_tree'  => array(), 

		    'include'       => array(),

		    'number'        => '', 

		    'fields'        => 'all', 

		    'slug'          => '', 

		    'parent'         => '',

		    'hierarchical'  => true, 

		    'child_of'      => 0, 

		    'get'           => '', 

		    'name__like'    => '',

		    'pad_counts'    => false, 

		    'offset'        => '', 

		    'search'        => '', 

		    'cache_domain'  => 'core'

		);



		$tags = get_terms( $taxonomies, $args );



		return $tags;

	}//end function

}//end function exists





if(!function_exists('get_ht_kb_categories')){

	/**

	* Get all knowledgebase categories

	* @pluggable

	* @return (Array) The ht_kb_category taxonomy terms

	*/

	function get_ht_kb_categories(){

		$taxonomies = array('ht_kb_category');



		$args = array(

		    'orderby'       => 'name', 

		    'order'         => 'ASC',

		    'hide_empty'    => true, 

		    'exclude'       => array(), 

		    'exclude_tree'  => array(), 

		    'include'       => array(),

		    'number'        => '', 

		    'fields'        => 'all', 

		    'slug'          => '', 

		    'parent'         => '',

		    'hierarchical'  => true, 

		    'child_of'      => 0, 

		    'get'           => '', 

		    'name__like'    => '',

		    'pad_counts'    => false, 

		    'offset'        => '', 

		    'search'        => '', 

		    'cache_domain'  => 'core'

		);



		$categories = get_terms( $taxonomies, $args );



		return $categories;

	}//end function

}//end function exists



if(!function_exists('get_most_helpful_article_id')){

	/**

	* Get the id of the most helpful article

	* @pluggable

	* @return (Int) ID of most helpful article

	*/

	function get_most_helpful_article_id(){

		$most_helpful_article_id = 0;

		

		$most_helpful = new WP_Query('meta_key=_ht_kb_usefulness&post_type=ht_kb&orderby=meta_value_num&order=DESC');

		if ($most_helpful->have_posts()) : 

			while ($most_helpful->have_posts()) : $most_helpful->the_post(); 

				$most_helpful_article_id = get_the_ID();

				//this is the most helpful, break.

				break;

			endwhile; 

		endif;

		wp_reset_postdata();

		return $most_helpful_article_id;

	}//end function

}//end function exists



if(!function_exists('is_most_helpful_article_id')){

	/**

	* Is the ID of the most helpful article

	* @pluggable

	* @param (Int) $article_id The test article ID

	* @return (Boolean) True when article ID matches most helpful article ID

	*/

	function is_most_helpful_article_id($article_id){

		$most_helpful_article_id = get_most_helpful_article_id();

		return $most_helpful_article_id == $article_id;

	}//end function

}//end function exists



if(!function_exists('display_is_most_helpful_article')){

	/**

	* Displays badge if most helpful article

	* @pluggable

	*/

	function display_is_most_helpful_article(){

		global $post;

		if(is_most_helpful_article_id($post->ID)){

			?>

			<span class="ht-kb-most-helpful-article">Cea Mai Apreciata Solutie</span>

			<?php

		}

	}//end function

}//end function exists



if(!function_exists('get_most_viewed_article_id')){

	/**

	* Get the id of the most viewed article

	* @pluggable

	* @return (Int) ID of most viewed article

	*/

	function get_most_viewed_article_id(){

		

		$most_viewed_article_id = 0;

		$most_viewed = new WP_Query('meta_key=_ht_kb_post_views_count&post_type=ht_kb&orderby=meta_value_num&order=DESC');

		if ($most_viewed->have_posts()) : 

			while ($most_viewed->have_posts()) : $most_viewed->the_post(); 

				$most_viewed_article_id = get_the_ID();

				//this is the most viewed, break.

				break;

			endwhile; 

		endif;

		wp_reset_postdata();

		return $most_viewed_article_id;



		return 0;

	}//end function

}//end function exists



if(!function_exists('is_most_viewed_article_id')){

	/**

	* Is the id of the most viewed article

	* @pluggable

	* @param (Int) $article_id The test article ID

	* @return (Boolean) True when article ID matches most viewed article ID

	*/

	function is_most_viewed_article_id($article_id){

		$most_viewed_article_id = get_most_viewed_article_id();

		return $most_viewed_article_id == $article_id;

	}//end function

}//end function exists



if(!function_exists('display_is_most_viewed_article')){

	/**

	* Display badge if most viewed article

	* @pluggable

	*/

	function display_is_most_viewed_article(){

		global $post;

		if(is_most_viewed_article_id($post->ID)){ ?>

			<span class="ht-kb-most-viewed-article">Cea Mai Vizualizata Solutie</span>

		<?php	}

	}//end function

}//end function exists



if(!function_exists('get_most_helpful_user_id')){

	/**

	* Get the id helpful user id

	* @pluggable

	* @return (Int) ID of most helpful user

	*/

	function get_most_helpful_user_id(){

		//start here use WP_User_Query

		//this *should* be orderby meta_value_num, but not available 

		$users = get_users('meta_key=_ht_kb_usefulness&orderby=meta_value&order=DESC');

		if (!empty($users)) : 

			foreach ($users as $key => $user) {

				return $user->ID;

			}

		endif;

		return 0;

	}//end function

}//end function exists





if(!function_exists('is_most_helpful_user_id')){

	/**

	* Is the id of the most helpful user

	* @pluggable

	* @param (String) $user_id The test user ID

	* @return (Boolean) True when user ID matches most helpful user ID

	*/

	function is_most_helpful_user_id($user_id){

		$most_helpful_user_id = get_most_helpful_user_id();

		return $most_helpful_user_id == $user_id;

	}//end function

}//end function exists





if(!function_exists('display_is_most_helpful_user')){

	/**

	* Is the id of the most helpful user

	* @pluggable

	* @param (String) $user_id The test user ID

	*/

	function display_is_most_helpful_user($user_id){

		if( is_most_helpful_user_id( $user_id ) ){ ?>

			<span class="ht-kb-most-helpful-user">Cel Mai Apreciat Autor</span>

		<?php	}

	}//end function

}//end function exists



if(!function_exists('ht_kb_display_uncategorized_articles')){
	/**
	* Display uncategorized articles
	* @pluggable
	*/

	function ht_kb_display_uncategorized_articles(){
		global $ht_kb_display_uncategorized_articles, $ht_knowledge_base_options;

		//now getting uncategorized posts
		$ht_kb_display_uncategorized_articles = true;

		//set number of articles to fetch
		$numberposts = 20;
		//$numberposts = (array_key_exists('tax-cat-article-number', $ht_knowledge_base_options)) ? $ht_knowledge_base_options['tax-cat-article-number'] : 10;

		$args = array(
			'orderby'       =>  'term_order',
			'depth'         =>  0,
			'child_of'      => 	0,
			'hide_empty'    =>  0,
			'pad_counts'   	=>	true
		); 
		$master_tax_terms = get_terms('ht_kb_category', $args);

		$top_level_tax_terms = wp_list_filter($master_tax_terms,array('parent'=>0));
		$tax_terms_ids = array();
		if( !empty ($master_tax_terms ) && !is_a( $master_tax_terms, 'WP_Error' ) && is_array( $master_tax_terms ) ){
			foreach ( (array)$master_tax_terms as $key => $term ) {
				array_push($tax_terms_ids, $term->term_id);
			}
		}

		$args = array( 
				'numberposts' => $numberposts, 
				'post_type'  => 'ht_kb',
				'orderby' => 'date',
				'suppress_filters' => false,
				'tax_query' => array(
					array(
						'taxonomy' => 'ht_kb_category',
						'field' => 'term_id',
						'include_children' => false,
						'terms' => $tax_terms_ids,
						'operator'  => 'NOT IN'
					)
				)
			);
		
		$uncategorized_posts = get_posts( $args );
		if( !empty( $uncategorized_posts ) && !is_a( $uncategorized_posts, 'WP_Error' ) ): ?>

			<li class="bbp-body ht-knowledge-uncategoriezed">
				<div id="bbp-forum-uncategorized" <?php bbp_forum_class( '', array( 'p-3 p-sm-4 card card-static mb-3 ov-v' ) ); ?>>
					<div class="row">
						<div class="col-12 col-xl-5 col-forum-info col-posts-info">
							<div class="row d-flex align-items-center align-items-md-start">
								<div class="col-auto pr-0 topic-img-row">
									<div class="bg-secondary p-3 rounded-full d-flex justify-content-center align-items-center">
										<i class="cera-icon cera-message-circle fa-2x text-primary"></i>
									</div>
								</div>

								<div class="col">
									<h2 class="entry-title h5 mt-2">
										<?php _e( 'Miscellaneous', 'ht-knowledge-base') ?>
									</h2>
								</div>
							</div>
						</div>

						<div class="col-12 col-xl-7  col-forum-meta mt-4 mt-md-0">
							<div class="row">
								<div class="col-12 col-md-6 col-lg-5 col-forum-meta mt-4 mt-md-0">
									<div class="row">
										<div class="col forum-topic-count">
										</div>
										<div class="col forum-reply-count">
											<div class="small text-uppercase font-weight-bold">
												<?php _e(' Solutions', 'ht-knowledge-base'); ?>
											</div>
											<div class="h3">
												<?= sizeof($uncategorized_posts); ?>
											</div>
										</div>
									</div>
								</div>

								<div class="col-12 col-md-6 col-lg-7 col-forum-meta mt-4 mt-md-0">
									<div class="forum-freshness">
										<div class="small text-uppercase font-weight-bold">
											<?php esc_html_e( 'Latest', 'bbpress' ); 
											?>
										</div>
										<div class="d-flex mt-2 small align-items-center">
											<ul class="ht-kb-article-list">
												<?php 
												foreach( $uncategorized_posts as $post ):
													//set post format class

													if ( get_post_format( $post->ID )=='video') { 
														$ht_kb_format_class = 'format-video';
													} else {
														$ht_kb_format_class = 'format-standard';
													} ?>

													<li class="<?php echo $ht_kb_format_class; ?>">
														<div class="row">
															<div class="col-3 col-md-2 views-counter-wrapper">
																<div class="row no-gutters ">
																	<div class="col-4">
																		<i class="fa fa-eye"></i>
																	</div>
																	<div class="col-8">
																		<a href="<?php echo get_permalink($post->ID); ?>">
																			<span>
																				<?php
																				$meta = get_post_meta( $post->ID );
																				echo (isset($meta['_ht_kb_post_views_count'])) ? $meta['_ht_kb_post_views_count'][0] : 0 ;
																				?>
																			</span>
																		</a>
																	</div>
																</div>
															</div>

															<div class="col-9 col-md-10">
																<a href="<?php echo get_permalink($post->ID); ?>">
																	<span>
																		<?php echo get_the_title($post->ID); ?>
																	</span>
																</a>
															</div>
														</div>
													</li>

												<?php endforeach; ?>
											</ul><!-- End Get posts per Category -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- #bbp-forum--uncategorized -->
			</li>

			<?php endif;

		$ht_kb_display_uncategorized_articles = false;

	}//end function

}//end function exists



if(!function_exists('ht_kb_display_archive')){

	/**

	* Display archive articles

	* @pluggable

	*/

	function ht_kb_display_archive($columns=2, $sub_cat_depth=2, $display_sub_cat_count=true, $display_sub_cat_articles=true){
		global $ht_kb_display_archive, $ht_knowledge_base_options;
		//now displaying archive posts
		$ht_kb_display_archive = true;

		//set user options
		$columns = (array_key_exists('archive-columns', $ht_knowledge_base_options)) ? $ht_knowledge_base_options['archive-columns'] : $columns;
		$sub_cat_display = (array_key_exists('sub-cat-display', $ht_knowledge_base_options)) ? $ht_knowledge_base_options['sub-cat-display'] : $sub_cat_display;
		$sub_cat_depth = (array_key_exists('sub-cat-depth', $ht_knowledge_base_options)) ? $ht_knowledge_base_options['sub-cat-depth'] : $sub_cat_depth;
		$display_sub_cat_count = (array_key_exists('sub-cat-article-count', $ht_knowledge_base_options)) ? $ht_knowledge_base_options['sub-cat-article-count'] : $display_sub_cat_count;
		$display_sub_cat_articles = (array_key_exists('sub-cat-article-display', $ht_knowledge_base_options)) ? $ht_knowledge_base_options['sub-cat-article-display'] : $display_sub_cat_articles;

		//set number of posts to sub cat article number or global posts_per_page option
		$numberposts = (array_key_exists('sub-cat-article-number', $ht_knowledge_base_options)) ? $ht_knowledge_base_options['sub-cat-article-number'] : get_option('posts_per_page');

		//list terms in a given taxonomy
		$args = array(
			'orderby'       =>  'term_order',
			'depth'         =>  0,
			'child_of'      => 	0,
			'hide_empty'    =>  0,
			'pad_counts'   	=>	true,
		); 
		$master_tax_terms = get_terms('ht_kb_category', $args);
		$categories = wp_list_filter($master_tax_terms,array('parent'=>0));
		$ht_kb_category_count = count($categories);
		$cat_counter = 0; ?>
		
		<li class="bbp-body">
			<?php
			foreach ($categories as $category) { 
				$t_id = $category->term_id; ?>

				<div id="bbp-forum-<?= $t_id; ?>" <?php bbp_forum_class( '', array( 'p-3 p-sm-4 card card-static mb-3 ov-v' ) ); ?>>
					<div class="row">
						<div class="col-12 col-xl-5 col-forum-info col-posts-info">
							<div class="row d-flex align-items-center align-items-md-start">
								<div class="col-auto pr-0 topic-img-row">
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
								</div>

								<div class="col">
									<h2 class="entry-title h5 mt-2">
										<a class="bbp-forum-title" 
											href="<?php echo esc_attr(get_term_link($category, 'ht_kb_category')) ?>" 
											title="<?php echo sprintf( __( 'View all posts in %s', 'ht-knowledge-base' ), $category->name ) ?>"><?php echo $category->name; ?></a>
									</h2>
									<div class="forum-content d-md-block mb-0 pr-0 pr-sm-5">
										<?php
										$ht_kb_tax_desc =  $category->description;
										if( !empty($ht_kb_tax_desc) ): ?>
											<p class="ht-kb-category-desc"><?php echo $ht_kb_tax_desc ?></p>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<?php bbp_forum_row_actions(); ?>
						</div>
						
						<?php
						$id_child = $category->term_id;
						$children = get_term_children( $id_child, 'ht_kb_category');
						$subcat_no = 0;
						foreach ($children as $id) {
							$subcat_no++;
						}
						?>

						<div class="col-12 col-xl-7  col-forum-meta mt-0 mt-md-4 mt-xl-0">
							<div class="row">
								<div class="col-12 col-md-6 col-lg-5 col-forum-meta mt-4 mt-md-0">
									<div class="row">
										<div class="col forum-topic-count">
											<div class="small text-uppercase font-weight-bold">
												<?php _e('Subcategories', 'ht-knowledge-base');?>
											</div>
											<div class="h3">
												<?= $subcat_no; ?>
											</div>
										</div>
										<div class="col forum-reply-count">
											<div class="small text-uppercase font-weight-bold">
												<?php _e(' Solutions', 'ht-knowledge-base'); ?>
											</div>
											<div class="h3">
												<?= $category->count; ?>
											</div>
										</div>
									</div>
								</div>

								<div class="col-12 col-md-6 col-lg-7 col-forum-meta mt-4 mt-md-0">
									<div class="forum-freshness">
										<div class="small text-uppercase font-weight-bold">
											<?php esc_html_e( 'Latest - ', 'bbpress' ); 
											echo $category->name;
											?>
										</div>
										<div class="d-flex mt-2 small align-items-center">
											<?php
											//get posts per category
											$args = array( 
												'numberposts' => $numberposts, 
												'post_type'  => 'ht_kb',
												'posts_per_page' => $numberposts,
												'orderby' => 'date',
												'suppress_filters' => 0,
												'tax_query' => array(
													array(
														'taxonomy' => 'ht_kb_category',
														'field' => 'term_id',
														'include_children' => false,
														'terms' => $category->term_id
													)
												)
											);

											$cat_posts = get_posts( $args );
											if( !empty( $cat_posts ) && !is_a( $cat_posts, 'WP_Error' ) ): ?>
												<ul class="ht-kb-article-list">
													<?php 
													foreach( $cat_posts as $post ) :
														//set post format class  

														if ( get_post_format( $post->ID )=='video') { 
															$ht_kb_format_class = 'format-video';
														} else {
															$ht_kb_format_class = 'format-standard';
														} ?>

														<li class="<?php echo $ht_kb_format_class; ?>">
															<div class="row">
																<div class="col-3 col-md-2 views-counter-wrapper">
																	<div class="row no-gutters ">
																		<div class="col-4">
																			<i class="fa fa-eye"></i>
																		</div>
																		<div class="col-8">
																			<a href="<?php echo get_permalink($post->ID); ?>">
																				<span>
																					<?php
																						$meta = get_post_meta( $post->ID );
																						echo $meta['_ht_kb_post_views_count'][0];
																					?>
																				</span>
																			</a>
																		</div>
																	</div>
																</div>

																<div class="col-9 col-md-10">
																	<a href="<?php echo get_permalink($post->ID); ?>">
																		<span>
																			<?php
																				echo get_the_title($post->ID);
																			?>
																		</span>
																	</a>
																</div>
															</div>
														</li>

													<?php endforeach; ?>
												</ul><!-- End Get posts per Category -->
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- #bbp-forum-<?= $t_id; ?> -->

						

				<?php //endif; ?>
			<?php
			} // close list terms in a given taxonomy
			?>
		</li>
		
		<?php		

		//finished displaying archive posts

		$ht_kb_display_archive = false;



	}//end function

}//end function exists



