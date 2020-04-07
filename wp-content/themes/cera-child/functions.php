<?php
/**
 * Cera Child functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package cera-child
 */

define( 'CERA_CHILD_VERSION', '1.0' );

/**
 * Initialize all the things.
 */
global $cera_child;
$cera_child = require get_stylesheet_directory() . '/inc/class-cera-child.php';

/**
 * Add your customizations below this line.
 */


add_action('admin_init', 'my_general_section');  
function my_general_section() {  
    add_settings_section(  
        'phone_section', // Section ID 
        'Phone number', // Section Title
        'my_section_options_callback', // Callback
        'general' // What Page?  This makes the section show up on the General Settings Page
    );

    add_settings_field( // Option 1
        'phone_number', // Option ID
        'Number', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'phone_section', // Name of our section
        array( // The $args
            'phone_number' // Should match Option ID
        )  
	); 

	add_settings_field( // Option 1
        'phone_number_label', // Option ID
        'Label', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'phone_section', // Name of our section
        array( // The $args
            'phone_number_label' // Should match Option ID
        )  
    ); 

	register_setting('general','phone_number', 'esc_attr');
    register_setting('general','phone_number_label', 'esc_attr');
}

function my_section_options_callback() { // Section Callback
    echo '<p>Number displayed on call to action button</p>';  
}

function my_textbox_callback($args) {  // Textbox Callback
    $option = get_option($args[0]);
    echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
}




add_action('admin_notices', 'propuneri_solutii_admin_notice');
function propuneri_solutii_admin_notice()
{
    global $pagenow;

    // Only show this message on the admin dashboard and if asked for
    if ('edit.php' === $pagenow && ! empty($_GET['post_type']))
    {
        echo '<div style="color: tomato;
            padding-right: 30px;
            background: white;
            padding-top: 10px;
            padding-bottom: 10px;
            font-weight: bold;
            padding-left: 10px;
            font-size: 19px;"><p style="font-size:19px; font-weight:bold;">News: Preluarea temelor de solutii din Solutii Propuse. Pasi:</p>
            <ul>
            <li>- Alege titlul pentru crearea unei solutii</li>
            <li>- Verifica la Autor ca Solutia sa nu fie asignata altei persoane</li>
            <li>- Edit:</li>
            <li>- Schimba la Autor in numele tau</li>
            <li>- Schimba statusul solutiei la "In Progress"</li>
            <li>- Save</li>
            <li>- Poti edita numele titlului </li>
            <li>- Verifica in interiorul solutiei detaliile ajutatoare, la *Situatie</li>
            <li>- Trecerea solutiei la statusul "Pending Review" si save</li>
            </ul>
            </div>';
    }
}

function appthemes_check_user_role( $role, $user_id = null ) {
    if ( is_numeric( $user_id ) )
        $user = get_userdata( $user_id );
    else
        $user = wp_get_current_user();
    
    if ( empty( $user ) )
        return false;
 
    return in_array( $role, (array) $user->roles );
}

add_action('admin_menu', 'no_posts_for_contributors');
function no_posts_for_contributors() {
  global $user_ID;

  if (appthemes_check_user_role("contributor")) {
    remove_menu_page('edit.php');
    remove_menu_page('edit-comments.php');
    remove_menu_page('tools.php');
    remove_menu_page('upload.php');
  }
}

add_action('admin_menu', 'add_propuneri_admin_menu_item');
function add_propuneri_admin_menu_item() {
                    // $page_title,            $menu_title, $capability, $menu_slug,           $callback_function
    add_submenu_page('edit.php?post_type=ht_kb', __('Solutii propuse'), __('Solutii propuse'),  'edit_others_posts', 'edit.php?post_type=ht_kb&post_status=solutii-propuse' );
}

add_action( 'admin_enqueue_scripts', 'remove_fields_from_profile_tab' );
function remove_fields_from_profile_tab($hook) {
    if ('profile.php' != $hook) {
        return;
    }

    if (!current_user_can('publish_posts')) {
	    $ss_url = get_stylesheet_directory_uri();

	    wp_enqueue_script( 'my_admin_script', "{$ss_url}/js/profile.js" );
    }

}

add_action( 'init', 'custom_post_type', 0 );
function custom_post_type() {
    add_post_type_support( 'ht_kb', 'post-formats' );
}

if ( (!current_user_can('manage_options') && is_user_logged_in()) || !is_user_logged_in() ) {
    add_filter('show_admin_bar', '__return_false');
}

add_action('admin_head', 'hide_editor');
function hide_editor() { 
  if(get_post_type() == 'ht_kb') { ?> 
    <style> #postdivrich { display:none; } </style> 
    <?php 
  }
}

/** Admin Enqueue **/
add_action( 'admin_enqueue_scripts', 'admin_queue' );
function admin_queue( $hook ) {
    global $post; 

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'ht_kb' === $post->post_type ) { 
            wp_enqueue_script( 'block-user-script-inserting', get_bloginfo( 'template_directory' ) . '-child/assets/js/admin/user-block-scripts.js', 'jquery', '', true );
        }
    }
}


if ( ! function_exists( 'cera_grimlock_the_post_thumbnail' ) ) :
	/**
	 * Prints HTML for the post thumbnail :
	 *     - For the Video, Audio and Image formats, the post thumbnail is replaced by the media
	 *       found in the post content (either the video player, the image or the audio player).
	 *     - In any other case, the post thumbnail is displayed.
	 *
	 * @since 1.0.0
	 *
	 * @param string $size The size for the thumbnail.
	 * @param array  $attr The array of attributes for the thumbnail tag.
	 */
	function cera_grimlock_the_post_thumbnail( $size = 'medium', $attr = array() ) {
		if ( has_post_format( array( 'video', 'audio', 'image', 'gallery' ) ) ) :
            if(has_post_format('video')):

                if(get_field('solutie_1')): 
                    $html = get_field('solutie_1');
                    $dom = new DOMDocument();
                    $dom->loadHTML($html);
                    $xpath = new DOMXPath($dom);
                    $div = $xpath->query('//div[@class="wp-video"]');
                    $div = $div->item(0);
                    $videoTag = $dom->saveXML($div);

                    if($videoTag): ?>
                        <div class="post-media post-media-video"><?= $videoTag ?></div>
                    <?php endif; 
                endif; 
            else: ?>
                <div class="post-media"><?php the_content(); ?></div>
            <?php endif;
		elseif ( has_post_thumbnail() ) : ?>
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-thumbnail" title="<?php the_title_attribute(); ?>" rel="bookmark">
				<?php the_post_thumbnail( $size, $attr ); ?>
			</a>
			<?php
		endif;
	}
endif;

// Remove plugins updates because of the inline modifications made inside of them
add_filter( 'site_transient_update_plugins', 'remove_plugin_updates' );
function remove_plugin_updates( $value ) {
    unset( $value->response['buddypress/class-buddypress.php'] );
    unset( $value->response['ht-knowledge-base/ht-knowledge-base.php'] );
    unset( $value->response['buddypress-global-search/buddypress-global-search.php'] );
	unset( $value->response['social-articles/social-articles.php']);
	unset( $value->response['custom-menu-class/custom-menu-class.php']); // PHP7.3 fixes
	unset( $value->response['wp-super-cache/wp-cache.php']); // wordpress error on wp-content/plugins/wp-super-cache/wp-cache-phase2.php line 3096
	unset( $value->response['super-socializer/super_socializer.php']);
	unset( $value->response['grimlock/grimlock.php']);
	unset( $value->response['grimlock-buddypress/grimlock-buddypress.php']);
	unset( $value->response['grimlock-login/grimlock-login.php']);
	unset( $value->response['grimlock-animate/grimlock-animate.php']);
    return $value;
}

/**
 * Remove the "Time to Update" nag message in WordPress
 */
function keel_hide_core_updates_nag() {
    remove_action( 'admin_notices', 'update_nag', 3 );
}
add_action( 'admin_menu', 'keel_hide_core_updates_nag' );

/**
 * Remove the ability to update from the Dashboard
 */
function keel_remove_core_updates_action() {
	?>
		<style type="text/css">
			.core-updates {
				display: none;
				visibility: hidden;
			}
		</style>
	<?php
}
add_action( 'admin_head', 'keel_remove_core_updates_action' );

/**
 * Redirect buddypress pages to registration page
 */
add_action( 'template_redirect', 'cera_restrict_buddypress' );
function cera_restrict_buddypress() {
	// If not logged in and on a bp page except registration or activation
	if ( ! is_user_logged_in() && is_buddypress() && ! bp_is_blog_page() && ! bp_is_activation_page() && ! bp_is_register_page() ) {
		wp_redirect( home_url( '/register/' ) );
		exit();
	}
}

add_filter( 'body_class', 'cera_child_body_classes', 10, 2 );
function cera_child_body_classes($classes, $class){
    if( is_archive() ){
        $classes[] = 'archive';
    }    
    return $classes;
}

add_action('wp_ajax_nopriv_archive_category', 'archive_category_function');
add_action('wp_ajax_archive_category', 'archive_category_function');
function archive_category_function() {
    if(function_exists('ht_kb_display_archive')): 		
        ht_kb_display_archive();
    endif;

    if(function_exists('ht_kb_display_uncategorized_articles')):
        ht_kb_display_uncategorized_articles();
    endif;

    wp_die();
}

add_action('wp_ajax_sidebar_right', 'sidebar_right_function');
add_action('wp_ajax_nopriv_sidebar_right', 'sidebar_right_function');
function sidebar_right_function() {
    get_sidebar( 'right' );

    wp_die();
}

add_action('wp_ajax_cera_footer', 'cera_footer_function');
add_action('wp_ajax_nopriv_cera_footer', 'cera_footer_function');
function cera_footer_function() {
    do_action( 'cera_footer' );

    wp_die();
}

add_action('wp_ajax_cera_after_site', 'cera_after_site_function');
add_action('wp_ajax_nopriv_cera_after_site', 'cera_after_site_function');
function cera_after_site_function() {
    do_action( 'cera_after_site' );

    wp_die();
}

add_action('wp_ajax_cera_header', 'cera_header_function');
add_action('wp_ajax_nopriv_cera_header', 'cera_header_function');
function cera_header_function() {
	do_action( 'cera_header' );

    wp_die();
}

add_action('wp_ajax_homepage_1', 'homepage1_function');
add_action('wp_ajax_nopriv_homepage_1', 'homepage1_function');
function homepage1_function() {
	dynamic_sidebar( 'homepage-1' );

    wp_die();
}

add_action('wp_ajax_nopriv_grimlock_vertical_navbar', 'grimlock_vertical_navbar_function');
add_action('wp_ajax_grimlock_vertical_navbar', 'grimlock_vertical_navbar_function');
function grimlock_vertical_navbar_function() {
	do_action( 'grimlock_vertical_navbar', $_GET['props'] );

    wp_die();
}

add_action('acf/save_post', 'my_acf_save_post', 20);
function my_acf_save_post( $post_id ) {

    // Get previous values.
    $prev_values = get_fields( $post_id );

    // Get submitted values.
    $values = $_POST['acf'];

    $submitedStatus = $_POST['acf']['current_step'];
    if ($submitedStatus == 1){
        $value = 'pending';
    }else if ($submitedStatus == 2){
        $value = 'draft';
    }

    $my_post = array(
        'ID'     => $post_id,
        'post_status' => $value,
        'post_type'   => 'ht_kb',
    );
    remove_action('acf/save_post', 'my_acf_save_post', 20);
    // Update the post into the database
    wp_update_post($my_post);

    // Add the action back
    add_action('acf/save_post', 'my_acf_save_post', 20);
}

add_filter( 'body_class', 'cpt_ht_kb_customizations' );
function cpt_ht_kb_customizations( $classes ) {

	if ( is_singular( 'ht_kb' ) ) {
        $classes[] = 'layout-no-sidebar';
        $classes[] = 'single';
        $classes[] = 'single-post';
        $classes[] = 'single-format-standard';
        $classes[] = 'post-template-default';
        $classes[] = 'grimlock--single';
        $classes[] = 'grimlock--custom_header-title-displayed';
		$classes[] = 'grimlock--custom_header-subtitle-displayed';
		$classes[] = 'grimlock--custom_header-displayed';
	} 
	return $classes;
}

// Single Post functions ---------------------------------------------------------

add_action( 'cera_single_custom','cera_single_custom',10 );
if (!function_exists('cera_single_custom')):
	/**
	 * Prints HTML for the single post.
	 *
	 * @since 1.0.0
	 */
	function cera_single_custom() {
		?>

		<header class="grimlock--page-header entry-header">
			<?php
			cera_the_category_list();
            // the_title( '<h1 class="page-title entry-title">', '</h1>' );
            ?>
            <h1 class="page-title entry-title"><?= get_the_title() ?></h1>
            <?php
            do_action( 'cera_breadcrumb' );

			if ( 'ht_kb' === get_post_type() ) : ?>
				<span class="entry-meta">
					<?php cera_the_author_custom(); ?>
					<?php cera_the_date(); ?>
				</span><!-- .entry-meta -->
			<?php
			endif; ?>
		</header><!-- .entry-header -->

		<div class="grimlock--single-content grimlock--page-content entry-content">

			<p><h3>Situatie</h3><?php the_field('situatie'); ?></p>
			<?php if (get_field('tip') == 'Rezolvare problema (Fix IT)') { if(get_field('simptome')) {?> <h3>Simptome</h3><p><?php the_field('simptome'); ?></p><?php } ?><?php } ?>
			<?php if(get_field('backup')) { ?> <h3>Backup</h3> <?php the_field('backup'); } ?>
			<h3>Solutie</h3>
			<?php if(get_field('add_step_2')) { ?> <h5>Pasi de urmat</h5><?php } ?>
			<div id="solutie_1"><?php the_field('solutie_1'); ?></div>
			<?php if(get_field('add_step_2')) { ?> <div id="solutie_2"><?php the_field('solutie_2'); ?></div><?php } ?>
			<?php if(get_field('add_step_3')) { ?> <div id="solutie_3"><?php the_field('solutie_3'); ?></div><?php } ?>
			<?php if(get_field('add_step_4')) { ?> <div id="solutie_4"><?php the_field('solutie_4'); ?></div><?php } ?>
			<?php if(get_field('add_step_5')) { ?> <div id="solutie_5"><?php the_field('solutie_5'); ?></div><?php } ?>
			<?php if(get_field('add_step_6')) { ?> <div id="solutie_6"><?php the_field('solutie_6'); ?></div><?php } ?>
			<?php if(get_field('add_step_7')) { ?> <div id="solutie_7"><?php the_field('solutie_7'); ?></div><?php } ?>
			<?php if(get_field('add_step_8')) { ?> <div id="solutie_8"><?php the_field('solutie_8'); ?></div><?php } ?>
			<?php if(get_field('add_step_9')) { ?> <div id="solutie_9"><?php the_field('solutie_9'); ?></div><?php } ?>
			<?php if(get_field('add_step_10')) { ?> <div id="solutie_10"><?php the_field('solutie_10'); ?></div><?php } ?>
			<?php if(get_field('add_step_11')) { ?> <div id="solutie_11"><?php the_field('solutie_11'); ?></div><?php } ?>
			<?php if(get_field('add_step_12')) { ?> <div id="solutie_12"><?php the_field('solutie_12'); ?></div><?php } ?>
			<?php if(get_field('add_step_13')) { ?> <div id="solutie_13"><?php the_field('solutie_13'); ?></div><?php } ?>
			<?php if(get_field('add_step_14')) { ?> <div id="solutie_14"><?php the_field('solutie_14'); ?></div><?php } ?>
			<?php if(get_field('add_step_15')) { ?> <div id="solutie_15"><?php the_field('solutie_15'); ?></div><?php } ?>
			<?php if(get_field('add_step_16')) { ?> <div id="solutie_16"><?php the_field('solutie_16'); ?></div><?php } ?>
			<?php if(get_field('add_step_17')) { ?> <div id="solutie_17"><?php the_field('solutie_17'); ?></div><?php } ?>
			<?php if(get_field('add_step_18')) { ?> <div id="solutie_18"><?php the_field('solutie_18'); ?></div><?php } ?>
			<?php if(get_field('add_step_19')) { ?> <div id="solutie_19"><?php the_field('solutie_19'); ?></div><?php } ?>
			<?php if(get_field('add_step_20')) { ?> <div id="solutie_20"><?php the_field('solutie_20'); ?></div><?php } ?>
			<h3>Tip solutie</h3><?php the_field('solutie_select'); ?>
			<?php if(get_field('solutie_impact')) { ?> <h3>Impact colateral</h3> <?php the_field('solutie_impact'); } ?>
			<?php if(get_field('solutie_backout')) { ?><h3>Plan de restaurare in caz de nefunctionare</h3><?php the_field('solutie_backout');?><?php } ?>

            <?php
			// the_content();
			// $content = $item->post_content;
			
			echo apply_filters( 'the_content', $GLOBALS['post']->post_content );

			$voting =  get_post_meta( get_the_ID(), 'ht_knowledge_base_voting_checkbox', true );
			$allow_voting_on_this_article = $voting ? true : false;
			if( class_exists('HT_Voting') ): ?>
				<div id="ht-kb-rate-article">
				<?php // voting
				global $ht_knowledge_base_options;
				if( $ht_knowledge_base_options['voting-display'] && $allow_voting_on_this_article ){ ?>
					<h3 id="ht-kb-rate-article-title"><?php echo "Voteaza";?></h3>
					<?php if( $ht_knowledge_base_options['anon-voting'])
						echo do_shortcode('[ht_voting allow="anon"]');
					else
						echo do_shortcode('[ht_voting allow="user"]');
					} ?>
				</div>
			<?php endif;

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'cera' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text sr-only">' . esc_html__( 'Page', 'cera' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text sr-only">, </span>',
			) );
			cera_the_author_biography(); ?>
		</div><!-- .entry-content -->

		<footer class="grimlock--single-footer entry-footer d-none">
			<?php cera_the_tag_list_custom(); ?>
		</footer><!-- .entry-footer -->

		<?php
	}
endif;

if (!function_exists('cera_the_tag_list_custom')):
	/**
	 * Prints HTML with meta information for the post tags.
	 */
	function cera_the_tag_list_custom(){
		if ('ht_kb' === get_post_type()) {
			$tags_list = get_the_tag_list( '', ' ' );
			if ($tags_list){
				// $tags_list doesn't need to be escaped here cause it comes from native WP get_the_tag_list() function
				printf( '<span class="tags-links">%1$s</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}
endif;

if (!function_exists('cera_the_author_custom')):
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function cera_the_author_custom() {
		if ('post' === get_post_type() || 'ht_kb' === get_post_type()) {
			printf(
				'<span class="byline author"><span class="byline-label">' . esc_html__( 'by', 'cera' ) . ' </span>%1$s %2$s</span>',
				'<span class="author-avatar"><span class="avatar-round-ratio"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_avatar( get_the_author_meta( 'ID' ), 50 ) . '</a></span></span>',
				'<span class="author-vcard vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
			);
		}
	}
endif;

if (!function_exists('cera_the_date')):
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function cera_the_date() {
		if ( 'post' === get_post_type() || 'attachment' === get_post_type() || 'ht_kb' === get_post_type()) {
			$allowed_html = array(
				'time' => array(
					'class'    => true,
					'datetime' => true,
				),
			);

			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);

			printf(
				'<span class="posted-on"><span class="posted-on-label">' . esc_html__( 'Posted on', 'cera' ) . ' </span>%s</span>',
				'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . wp_kses( $time_string, $allowed_html ) . '</a>'
			);
		}
	}
endif;

if (!function_exists('cera_the_category_list')):
	/**
	 * Prints HTML with meta information for the categories.
	 */
	function cera_the_category_list() {
		if ('post' === get_post_type() || 'ht_kb' === get_post_type()) {

			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ' ', 'cera' ) );
			if ( $categories_list && cera_categorized_blog() ) {
				// $categories_list doesn't need to be escaped here cause it comes from native WP get_the_category_list() function
				printf( '<span class="cat-links">%1$s</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}
endif;

if (!function_exists('cera_the_author_biography')):
	/**
	 * Display the author biography.
	 */
	function cera_the_author_biography() {
		if ( '' !== get_the_author_meta( 'description' ) && ('post' === get_post_type() || 'ht_kb' === get_post_type())) :
			$avatar_args = array(
				'class' => array( 'd-flex', 'align-self-start', 'mr-3' ),
			); ?>
			<div class="card card-static card--author-info bg-black-faded">
				<div class="media author-info">
					<span class="avatar-round-ratio big">
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), 140, '', '', $avatar_args ); ?>
						</a>
					</span>
					<div class="author-description media-body">
						<h4 class="author-title h5"><span class="author-heading"><?php esc_html_e( 'By', 'cera' ); ?></span> <?php echo get_the_author(); ?></h4>
						<div class="author-bio">
							<?php the_author_meta( 'description' ); ?>
							<div class="mt-1">
								<a class="btn btn-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
									<?php
									/* translators: %s: The author name */
									printf( esc_html__( 'View all posts by %s', 'cera' ), esc_html( get_the_author() ) ); ?>
								</a>
							</div>
						</div><!-- .author-bio -->
					</div><!-- .author-description -->
				</div><!-- .author-info -->
			</div>
			<?php
		endif;
	}
endif;

if (!function_exists('cera_search_post')):
	/**
	 * Prints HTML for the post.
	 *
	 * @since 1.0.0
	 */
	function cera_search_post() {
		?>
		<div class="card">

			<?php if ( has_post_format( array( 'video', 'audio', 'image', 'gallery' ) ) ) : ?>
				<div class="post-media"><?php the_content(); ?></div>
			<?php elseif ( has_post_thumbnail() ) : ?>
				<?php
				cera_the_post_thumbnail( 'thumbnail-6-6-cols-classic', array(
					'class' => 'card-img wp-post-image',
				) ); ?>
			<?php endif; ?>

			<div class="card-body">
				<?php
				if (('post' === get_post_type() || 'ht_kb' === get_post_type()) &&  has_post_format() || is_sticky()): ?>
					<div class="card-body-labels entry-labels">
						<?php
						cera_the_sticky_mark();
						cera_the_post_format(); ?>
					</div>
					<?php
				endif; ?>

				<header class="card-body-header entry-header">
					<div class="card-body-meta entry-meta">
						<?php cera_the_category_list(); ?>
					</div><!-- .entry-meta -->
					<?php the_title( '<h2 class="entry-title h4"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
				</header><!-- .entry-header -->

				<div class="card-body-content entry-content">
					<?php if ( has_post_format( array( 'link', 'quote' ) ) ) : ?>
						<?php the_content(); ?>
						<a href="<?php the_permalink(); ?>" class="more-link"><?php esc_html_e( 'Continue reading', 'cera' ); ?></a>
					<?php else : ?>
						<?php the_excerpt(); ?>
						<a href="<?php the_permalink(); ?>" class="more-link btn btn-secondary btn-sm"><?php esc_html_e( 'Continue reading', 'cera' ); ?></a>
						<?php if ( has_tag() ): cera_the_tag_list_custom(); endif; ?>
					<?php endif; ?>

				</div><!-- .entry-content -->

			</div><!-- .card-body-->

			<?php if ( 'post' === get_post_type() || 'ht_kb' === get_post_type()) : ?>
				<footer class="card-footer entry-footer">
					<?php
					cera_the_author();
					cera_the_date();
					cera_comments_link();
					?>
				</footer><!-- .entry-footer -->
			<?php endif; ?>

		</div><!-- .card-->
		<?php
	}
endif;

add_filter('autoptimize_filter_noptimize','invoice_noptimize',10,0);
function invoice_noptimize() {
	$noOptimize = false;
	if (strpos($_SERVER['REQUEST_URI'],'members')!==false) {
		if (strpos($_SERVER['REQUEST_URI'],'profile')!==false) {
			$noOptimize = true;
		}

		if (strpos($_SERVER['REQUEST_URI'],'friends')!==false) {
			$noOptimize = true;
		}

		if (strpos($_SERVER['REQUEST_URI'],'groups')!==false) {
			$noOptimize = true;
		}

		if (strpos($_SERVER['REQUEST_URI'],'articles')!==false) {
			$noOptimize = true;
		}
	}	

}

function contributes($columns) {
    $columns['solutii'] = __('Solutii', 'solutii');
    return $columns;
}
add_filter('manage_users_columns', 'contributes');

function contributes_columns( $value, $column_name, $user_id ) {
    if ( 'solutii' != $column_name )//Replace 'contributes' with the column name from the filter you previously created
        return $value;
    global $wp_query;
    $posts = query_posts('post_type=ht_kb&author='.$user_id.'&order=ASC&posts_per_page=30');//Replace post_type=contribute with the post_type=yourCustomPostName
    $posts_count = count($posts);
    $posts_count = "<a href='".site_url()."/wp-admin/edit.php?author={$user_id}&post_type=ht_kb'>{$posts_count}</a>";
    return $posts_count;
}
add_action('manage_users_custom_column', 'contributes_columns', 10, 3);

function new_nav_menu_items($items, $args) {
	if($args->theme_location == 'primary') {
		$args = array(
			'orderby'       =>  'term_order',
			'depth'         =>  0,
			'child_of'      => 	0,
			'hide_empty'    =>  0,
			'pad_counts'   	=>	true,
		); 
		$master_tax_terms = get_terms('ht_kb_category', $args);
		$categories = (array) wp_list_filter($master_tax_terms,array('parent'=>0));
		
		function reverseOrder($a,$b) {
			return $b->count <=> $a->count;
		}

		usort($categories, "reverseOrder"); 

		foreach($categories as $key=>$category) { 
			if($key < 5) {
				$categoryScript .= '<li id="menu-item-' . $category->term_id .'" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-' . $category->term_id .'"><a href="' . get_term_link( $category ) . '"><i class="number text-primary" aria-hidden="true">'. $category->count . '</i> <span>' . $category->name.'</span></a></li>';
			}
		} 

		$items = $items . $categoryScript;
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', 'new_nav_menu_items', 1, 2);

function defer_parsing_of_js( $url ) {
    if ( is_admin() ) {
		return $url; //don't break WP Admin
	}

    if ( FALSE === strpos( $url, '.js' ) ) {
		return $url;
	}

    if ( strpos( $url, 'jquery.js' ) ) {
		return $url;
	}
	
    return str_replace( ' src', ' defer src', $url );
}

add_filter( 'script_loader_tag', 'defer_parsing_of_js', 10 );